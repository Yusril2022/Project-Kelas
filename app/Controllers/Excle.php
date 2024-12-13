<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Excle extends BaseController
{
    public function exportAll()
    {
        // Judul halaman
        $data = ['title' => 'Laporan Data Excel'];
    
        // Load model dan dapatkan data
        $mahasiswaModel = new \App\Models\MahasiswaModel();
        $data['mahasiswa'] = $mahasiswaModel->findAll(); // Mendapatkan semua data
    
        // Load view untuk menghasilkan laporan
        return view('Admin/excel', $data);
    }

    public function exportExcel($id_mhs)
    {
        // Judul laporan
        $data = ['title' => 'Laporan Excel'];
    
        // Kondisi untuk filter data berdasarkan ID mahasiswa
        $where = ['id_mhs' => $id_mhs];
    
        // Load model dan dapatkan data berdasarkan kondisi
        $mahasiswaModel = new \App\Models\MahasiswaModel();
        $data['mahasiswa'] = $mahasiswaModel->where($where)->findAll();
    
        // Load view untuk laporan Excel
        return view('Admin/laporan_excel', $data);
    }
}
