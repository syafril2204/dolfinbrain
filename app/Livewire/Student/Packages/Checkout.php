<?php

namespace App\Livewire\Student\Packages;

use App\Models\Position;
use App\Models\Transaction;
use App\Services\TripayService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class Checkout extends Component
{
    public $packageType;
    public ?Position $position;
    public $packageName;
    public $price;
    public $phone_number;
    public $originalPrice;
    public $discountAmount;
    public $transactionId;
    public $agree = false;
    public $pendingTransaction;

    public $paymentChannels = [];
    public $selectedPaymentMethod;

    public function mount($package_type)
    {
        $this->phone_number = auth()->user()->phone_number ?? '';
        if (!in_array($package_type, ['mandiri', 'bimbingan'])) {
            abort(404);
        }

        $this->packageType = $package_type;
        $user = Auth::user();

        if (!$user->position_id) {
            session()->flash('error', 'Silakan pilih jabatan terlebih dahulu.');
            return $this->redirect(route('students.packages.index'));
        }

        $pendingTransaction = Transaction::where('user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->first();
        $this->pendingTransaction = $pendingTransaction;

        // if ($pendingTransaction) {
        //     if ($pendingTransaction->position_id == $user->position_id && $pendingTransaction->package_type == $this->packageType) {
        //         session()->flash('message', 'Anda sudah memiliki transaksi tertunda untuk paket ini. Silakan selesaikan pembayaran.');
        //         return $this->redirect(route('students.packages.instruction', ['transaction' => $pendingTransaction->reference]));
        //     } else {
        //         $pendingTransaction->delete();
        //     }
        // }

        $this->setupCheckout();
    }

    public function setupCheckout()
    {
        $user = Auth::user();
        $this->position = Position::with('formation')->find($user->position_id);
        $this->packageName = ($this->packageType === 'mandiri') ? 'Paket Aplikasi' : 'Paket Bimbel';
        $this->price = ($this->packageType === 'mandiri') ? $this->position->price_mandiri : $this->position->price_bimbingan;
        $this->originalPrice = $this->price * 1.2;
        $this->discountAmount = $this->originalPrice - $this->price;
        $this->transactionId = 'TRX' . strtoupper(Str::random(10));

        try {
            $tripay = new TripayService();
            $channels = $tripay->getPaymentChannels();
            $this->paymentChannels = collect($channels)->groupBy('group')->all();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memuat metode pembayaran. Coba lagi nanti.');
            $this->paymentChannels = [];
        }
    }

    public function createTransaction()
    {
        $this->validate([
            'agree' => 'accepted',
            'selectedPaymentMethod' => 'required',
            'phone_number' => 'required',
        ], [
            'agree.accepted' => 'Anda harus menyetujui Syarat & Ketentuan.',
            'selectedPaymentMethod.required' => 'Silakan pilih metode pembayaran.',
            'phone_number.required' => 'Silahkan inputkan Nomor HP anda'
        ]);

        $user = Auth::user();


        if ($this->pendingTransaction) {
            $this->pendingTransaction->delete();
        }
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'position_id' => $this->position->id,
            'package_type' => $this->packageType,
            'reference' => 'INV-' . $user->id . '-' . time(),
            'payment_method' => $this->selectedPaymentMethod,
            'phone_number' => $this->phone_number,
            'amount' => $this->price,
            'status' => 'pending',
        ]);

        auth()->user()->update([
            'phone_number' => $this->phone_number
        ]);

        $tripay = new TripayService();
        $tripayResponse = $tripay->createTransaction($transaction, $user, $this->position, $this->packageType, $this->selectedPaymentMethod, $this->phone_number);

        if (isset($tripayResponse['success']) && $tripayResponse['success'] == true) {
            $tripayData = $tripayResponse['data'];
            $transaction->update([
                'checkout_url' => $tripayData['checkout_url'],
                'payment_code' => $tripayData['pay_code'] ?? null,
                'qr_url' => $tripayData['qr_url'] ?? null,
                'expired_at' => \Carbon\Carbon::createFromTimestamp($tripayData['expired_time']),
            ]);

            return redirect()->route('students.packages.instruction', ['transaction' => $transaction->reference]);
        } else {
            session()->flash('error', 'Gagal membuat transaksi. Silakan coba lagi. ' . ($tripayResponse['message'] ?? ''));
        }
    }

    public function render()
    {
        return view('livewire.student.packages.checkout')
            ->layout('components.layouts.app');
    }
}
