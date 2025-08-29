<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
     * Mengambil data pengguna dari database.
     */
    public function query()
    {
        // Mengambil semua user dengan role 'student' beserta relasinya
        return User::query()->whereHas('roles', function ($query) {
            $query->where('name', 'student');
        })->with('position.formation');
    }

    /**
     * Menentukan judul header untuk setiap kolom di Excel.
     */
    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Email',
            'Jenis Kelamin',
            'Tanggal Lahir',
            'Domisili',
            'Nomor Telepon',
            'Formasi',
            'Jabatan',
            'Status Akun',
            'Asal Instansi',
            'Tanggal Registrasi',
        ];
    }

    /**
     * Memetakan data dari setiap user ke dalam kolom yang sesuai.
     *
     * @param User $user
     */
    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            $user->gender,
            $user->date_of_birth ? $user->date_of_birth->format('d-m-Y') : '-',
            $user->domicile,
            $user->phone_number,
            $user->position->formation->name ?? '-', // Ambil nama formasi dari relasi
            $user->position->name ?? '-', // Ambil nama posisi dari relasi
            ucfirst($user->status),
            $user->instansi,
            $user->created_at->format('d-m-Y H:i:s'), // Format tanggal registrasi
        ];
    }

    /**
     * Memberikan style pada sheet, misalnya membuat header menjadi bold.
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style baris pertama (header)
            1 => ['font' => ['bold' => true]],
        ];
    }
}
