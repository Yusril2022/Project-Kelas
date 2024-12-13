<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use App\Models\MahasiswaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    public function index()
    {
        //
        return view('Layout/Dashboard');
    }

    public function exportAll()
    {
        $mahasiswaModel = new MahasiswaModel();
        $mahasiswa = $mahasiswaModel->findAll();

        // Membuat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'NIM');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Fakultas');
        $sheet->setCellValue('E1', 'Prodi');
        $sheet->setCellValue('F1', 'Alamat');
        $sheet->setCellValue('G1', 'Tanggal Lahir');
        $sheet->setCellValue('H1', 'Jenis Kelamin');

        // Menambahkan data mahasiswa ke dalam file Excel
        $row = 2; // Dimulai dari baris kedua
        foreach ($mahasiswa as $mhs) {
            $sheet->setCellValue('A' . $row, $mhs['id_mhs']);
            $sheet->setCellValue('B' . $row, $mhs['nim']);
            $sheet->setCellValue('C' . $row, $mhs['nama_mhs']);
            $sheet->setCellValue('D' . $row, $mhs['fakultas']);
            $sheet->setCellValue('E' . $row, $mhs['prodi']);
            $sheet->setCellValue('F' . $row, $mhs['alamat']);
            $sheet->setCellValue('G' . $row, $mhs['tanggal_lahir']);
            $sheet->setCellValue('H' . $row, $mhs['jenis_kelamin']);
            $row++;
        }

        // Mengatur header untuk unduhan file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="data_mahasiswa.xlsx"');
        header('Cache-Control: max-age=0');

        // Menulis file Excel ke output
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function exportToPDF()
    {
        $mahasiswaModel = new MahasiswaModel();
        $mahasiswa = $mahasiswaModel->findAll();

        // Membuat HTML untuk diubah menjadi PDF
        $html = '<h1 style="text-align: center;">Data Mahasiswa</h1>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">';
        $html .= '<thead>
                    <tr>
                        <th>ID</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Fakultas</th>
                        <th>Prodi</th>
                        <th>Alamat</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                    </tr>
                  </thead>';
        $html .= '<tbody>';

        foreach ($mahasiswa as $mhs) {
            $html .= '<tr>
                        <td>' . $mhs['id_mhs'] . '</td>
                        <td>' . $mhs['nim'] . '</td>
                        <td>' . $mhs['nama_mhs'] . '</td>
                        <td>' . $mhs['fakultas'] . '</td>
                        <td>' . $mhs['prodi'] . '</td>
                        <td>' . $mhs['alamat'] . '</td>
                        <td>' . $mhs['tanggal_lahir'] . '</td>
                        <td>' . $mhs['jenis_kelamin'] . '</td>
                      </tr>';
        }

        $html .= '</tbody></table>';

        // Inisialisasi Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // (Opsional) Mengatur orientasi halaman dan ukuran
        $dompdf->setPaper('A4', 'landscape');

        // Render HTML menjadi PDF
        $dompdf->render();

        // Output file PDF ke browser untuk diunduh
        $dompdf->stream("data_mahasiswa.pdf", ["Attachment" => 1]);
    }

    

    // public function exportExcel($id_mhs)
    // {
    //     // Judul laporan
    //     $data = ['title' => 'Laporan Excel'];
    
    //     // Kondisi untuk filter data berdasarkan ID mahasiswa
    //     $where = ['id_mhs' => $id_mhs];
    
    //     // Load model dan dapatkan data berdasarkan kondisi
    //     $mahasiswaModel = new \App\Models\MahasiswaModel();
    //     $data['mahasiswa'] = $mahasiswaModel->where($where)->findAll();
    
    //     // Load view untuk laporan Excel
    //     return view('Admin/laporan_excel', $data);
    // }
}
