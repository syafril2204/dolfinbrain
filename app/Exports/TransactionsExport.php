<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $search;
    protected $status;
    protected $startDate;
    protected $endDate;

    public function __construct($search, $status, $startDate, $endDate)
    {
        $this->search = $search;
        $this->status = $status;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Query ini mereplikasi logika filter dari halaman admin.
     */
    public function query()
    {
        return Transaction::query()
            ->with('user', 'position.formation', 'affiliate')
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('reference', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($userQuery) {
                            $userQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->startDate, fn($q) => $q->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate, fn($q) => $q->whereDate('created_at', '<=', $this->endDate))
            ->latest();
    }

    /**
     * Menentukan header untuk file Excel.
     */
    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Referensi',
            'Nama Pengguna',
            'Email Pengguna',
            'Formasi',
            'Posisi',
            'Tipe Paket',
            'Jumlah (Rp)',
            'Metode Pembayaran',
            'Status',
            'Kode Afiliasi',
            'Nama Afiliasi',
            'Tanggal Transaksi',
        ];
    }

    /**
     * Memetakan data dari setiap transaksi ke kolom yang sesuai.
     *
     * @param Transaction $transaction
     */
    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->reference,
            $transaction->user->name ?? 'N/A',
            $transaction->user->email ?? 'N/A',
            $transaction->position->formation->name ?? 'N/A',
            $transaction->position->name ?? 'N/A',
            ucfirst($transaction->package_type),
            $transaction->amount,
            $transaction->payment_method,
            ucfirst($transaction->status),
            $transaction->affiliate->code ?? '-',
            $transaction->affiliate->name ?? '-',
            $transaction->created_at->format('d-m-Y H:i:s'),
        ];
    }

    /**
     * Memberikan style pada header.
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
