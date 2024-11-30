<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table      = 'mahasiswa';
    protected $primaryKey = 'id_mhs';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nim',
        'nama_mhs',
        'fakultas',
        'prodi',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'created_at',
        'foto'
    ];

    // Nonaktifkan timestamps
    protected $useTimestamps = false;

    public function showData()
    {
        $db = \Config\Database::connect(); // Hubungkan ke database
        $query = $db->table('mahasiswa')->get(); // Ambil data dari tabel
        return $query->getResult(); // Kembalikan hasil sebagai array objek
    }

    public function showLaporanExcel($table, $id_mhs)
    {
        $db = \Config\Database::connect(); // Hubungkan ke database
        $query = $db->table($table)->getWhere($id_mhs); // Jalankan query dengan kondisi
        return $query->getResult(); // Kembalikan hasil sebagai array objek
    }

   

}
