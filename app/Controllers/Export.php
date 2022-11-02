<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AppointmentModel;
use App\Models\MedicineModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export extends BaseController
{

    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->medicineModel = new MedicineModel();
    }

    public function laporan()
    {
        $data = [
            'title' => 'Laporan',
        ];

        return view('report/index', $data);
    }

    public function export()
    {
        $validType = ['kunjungan', 'resep'];
        $validTypeWithoutDate = ['pasien', 'obat'];

        $type = $this->request->getPost('f_type');
        $tanggal_awal = $this->request->getPost('tanggal_awal');
        $tanggal_akhir = $this->request->getPost('tanggal_akhir');

        if (!in_array($type, $validType) && !in_array($type, $validTypeWithoutDate)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (!in_array($type, $validTypeWithoutDate) && (!$this->request->getVar("tanggal_awal") || !$this->request->getVar("tanggal_akhir"))) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return redirect()->to("/export/$type?tanggal_awal=$tanggal_awal&tanggal_akhir=$tanggal_akhir");
    }

    public function kunjungan()
    {
        if (!$this->request->getVar("tanggal_awal") || !$this->request->getVar("tanggal_akhir")) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $tanggal = [
            $this->request->getVar('tanggal_awal'),
            $this->request->getVar('tanggal_akhir')
        ];

        $data['result'] =  $this->appointmentModel->getAppointments(NULL, "Offline", $tanggal);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Laporan Kunjungan')
            ->setCellValue('A2', 'Tanggal : ' . $this->request->getVar('tanggal_awal') . ' - ' . $this->request->getVar('tanggal_akhir'));
        $spreadsheet->getActiveSheet()->mergeCells('A1:I1');
        $spreadsheet->getActiveSheet()->mergeCells('A2:I2');
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'No')
            ->setCellValue('B4', 'ID Kunjungan')
            ->setCellValue('C4', 'Tanggal')
            ->setCellValue('D4', 'Nama Pasien')
            ->setCellValue('E4', 'Jenis Kelamin')
            ->setCellValue('F4', 'Usia')
            ->setCellValue('G4', 'Unit Kerja')
            ->setCellValue('H4', 'Keluhan')
            ->setCellValue('I4', 'Nama Dokter');

        $column = 5;
        $no = 1;
        if (!empty($data['result'])) {
            foreach ($data['result'] as $row) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $column, $no)
                    ->setCellValue('B' . $column, $row['id_kunjungan'])
                    ->setCellValue('C' . $column, $row['tanggal_kunjungan'])
                    ->setCellValue('D' . $column, $row['nama_pasien'])
                    ->setCellValue('E' . $column, $row['jenis_kelamin'])
                    ->setCellValue('F' . $column, countAge($row['tanggal_lahir']))
                    ->setCellValue('G' . $column, $row['nama_bagian'] . ' - ' . $row['nama_biro'])
                    ->setCellValue('H' . $column, $row['keluhan'])
                    ->setCellValue('I' . $column, $row['nama_dokter']);
                $spreadsheet->getActiveSheet()->getStyle("A$column:H$column")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $column++;
                $no++;
            }
        }

        // STYLING CELL HEADER
        $spreadsheet->getActiveSheet()->getStyle('A1:I2')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:I4')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A4:I4')->getFont()->setBold(true);

        // STYLING CELL BORDER
        $spreadsheet->getActiveSheet()->getStyle('A4:H4')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Kunjungan ' .  $this->request->getVar('tanggal_awal') . ' - ' . $this->request->getVar('tanggal_akhir');

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function tiket()
    {
        if (!$this->request->getVar("tanggal_awal") || !$this->request->getVar("tanggal_akhir")) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $tanggal = [
            $this->request->getVar('tanggal_awal'),
            $this->request->getVar('tanggal_akhir')
        ];

        $data['result'] =  $this->appointmentModel->getAppointments(NULL, "Online", $tanggal);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Laporan Konsultasi Online')
            ->setCellValue('A2', 'Tanggal : ' . $this->request->getVar('tanggal_awal') . ' - ' . $this->request->getVar('tanggal_akhir'));
        $spreadsheet->getActiveSheet()->mergeCells('A1:I1');
        $spreadsheet->getActiveSheet()->mergeCells('A2:I2');
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'No')
            ->setCellValue('B4', 'ID Tiket')
            ->setCellValue('C4', 'Tanggal')
            ->setCellValue('D4', 'Nama Pasien')
            ->setCellValue('E4', 'Jenis Kelamin')
            ->setCellValue('F4', 'Usia')
            ->setCellValue('G4', 'Unit Kerja')
            ->setCellValue('H4', 'Keluhan')
            ->setCellValue('I4', 'Nama Dokter');

        $column = 5;
        $no = 1;
        if (!empty($data['result'])) {
            foreach ($data['result'] as $row) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $column, $no)
                    ->setCellValue('B' . $column, $row['id_kunjungan'])
                    ->setCellValue('C' . $column, $row['tanggal_kunjungan'])
                    ->setCellValue('D' . $column, $row['nama_pasien'])
                    ->setCellValue('E' . $column, $row['jenis_kelamin'])
                    ->setCellValue('F' . $column, countAge($row['tanggal_lahir']))
                    ->setCellValue('G' . $column, $row['nama_bagian'] . ' - ' . $row['nama_biro'])
                    ->setCellValue('H' . $column, $row['keluhan'])
                    ->setCellValue('I' . $column, $row['nama_dokter']);
                $spreadsheet->getActiveSheet()->getStyle("A$column:H$column")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $column++;
                $no++;
            }
        }

        // STYLING CELL HEADER
        $spreadsheet->getActiveSheet()->getStyle('A1:I2')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:I4')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A4:I4')->getFont()->setBold(true);

        // STYLING CELL BORDER
        $spreadsheet->getActiveSheet()->getStyle('A4:H4')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Tiket ' .  $this->request->getVar('tanggal_awal') . ' - ' . $this->request->getVar('tanggal_akhir');

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function obat()
    {
        $data['result'] = $this->medicineModel->findAll();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Laporan Data Obat')
            ->setCellValue('A2', 'Tanggal : ' . date('d-m-Y'));
        $spreadsheet->getActiveSheet()->mergeCells('A1:F1');
        $spreadsheet->getActiveSheet()->mergeCells('A2:F2');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'No')
            ->setCellValue('B4', 'ID Obat')
            ->setCellValue('C4', 'Nama Obat')
            ->setCellValue('D4', 'Stok')
            ->setCellValue('E4', 'Satuan')
            ->setCellValue('F4', 'Update Terakhir');

        $column = 5;
        $no = 1;

        if (!empty($data['result'])) {
            foreach ($data['result'] as $row) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $column, $no)
                    ->setCellValue('B' . $column, $row['id_obat'])
                    ->setCellValue('C' . $column, $row['nama_obat'])
                    ->setCellValue('D' . $column, $row['stok'])
                    ->setCellValue('E' . $column, $row['satuan'])
                    ->setCellValue('F' . $column, $row['updated_at']);
                $spreadsheet->getActiveSheet()->getStyle("A$column:F$column")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $column++;
                $no++;
            }
        }

        // STYLING CELL HEADER
        $spreadsheet->getActiveSheet()->getStyle('A1:F2')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:F4')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A4:F4')->getFont()->setBold(true);

        // STYLING CELL BORDER
        $spreadsheet->getActiveSheet()->getStyle('A4:F4')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Obat ' . date('d-m-Y');

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function resep()
    {
        if (!$this->request->getVar("tanggal_awal") || !$this->request->getVar("tanggal_akhir")) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $tanggal = [
            $this->request->getVar('tanggal_awal'),
            $this->request->getVar('tanggal_akhir')
        ];

        $resepDetailModel = new \App\Models\ResepDetailModel();

        $data['result'] =  $resepDetailModel->getReportResep($tanggal);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Laporan Resep')
            ->setCellValue('A2', 'Tanggal : ' . $this->request->getVar('tanggal_awal') . ' - ' . $this->request->getVar('tanggal_akhir'));
        $spreadsheet->getActiveSheet()->mergeCells('A1:G1');
        $spreadsheet->getActiveSheet()->mergeCells('A2:G2');
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'No')
            ->setCellValue('B4', 'ID Kunjungan')
            ->setCellValue('C4', 'Nama Pasien')
            ->setCellValue('D4', 'Jenis Obat')
            ->setCellValue('E4', 'Jumlah')
            ->setCellValue('F4', 'Satuan')
            ->setCellValue('G4', 'Tanggal Pemberian');
        $column = 5;
        $no = 1;

        if (!empty($data['result'])) {
            foreach ($data['result'] as $row) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $column, $no)
                    ->setCellValue('B' . $column, $row['id_kunjungan'])
                    ->setCellValue('C' . $column, $row['nama_pasien'])
                    ->setCellValue('D' . $column, $row['nama_obat'])
                    ->setCellValue('E' . $column, $row['jumlah'])
                    ->setCellValue('F' . $column, $row['satuan'])
                    ->setCellValue('G' . $column, $row['created_at']);
                $spreadsheet->getActiveSheet()->getStyle("A$column:G$column")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $column++;
                $no++;
            }
        }

        // STYLING CELL HEADER
        $spreadsheet->getActiveSheet()->getStyle('A1:G2')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:G4')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A4:G4')->getFont()->setBold(true);

        // STYLING CELL BORDER
        $spreadsheet->getActiveSheet()->getStyle('A4:H4')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Resep ' .  $this->request->getVar('tanggal_awal') . ' - ' . $this->request->getVar('tanggal_akhir');

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function pasien()
    {
        $patientModel = new \App\Models\PatientModel();
        $data['result'] = $patientModel->getPatients();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Laporan Data Pasien')
            ->setCellValue('A2', 'Tanggal : ' . date('d-m-Y'));
        $spreadsheet->getActiveSheet()->mergeCells('A1:I1');
        $spreadsheet->getActiveSheet()->mergeCells('A2:I2');


        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'No')
            ->setCellValue('B4', 'ID Pasien')
            ->setCellValue('C4', 'NIP')
            ->setCellValue('D4', 'Nama')
            ->setCellValue('E4', 'Unit Kerja')
            ->setCellValue('F4', 'Alamat Rumah')
            ->setCellValue('G4', 'No. Telepon')
            ->setCellValue('H4', 'Tempat, Tanggal Lahir')
            ->setCellValue('I4', 'Jenis Kelamin');

        $column = 5;
        $no = 1;

        if (!empty($data['result'])) {
            foreach ($data['result'] as $row) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $column, $no)
                    ->setCellValue('B' . $column, $row['id_pasien'])
                    ->setCellValue('C' . $column, $row['nip'])
                    ->setCellValue('D' . $column, $row['nama'])
                    ->setCellValue('E' . $column, $row['nama_bagian'] . ' - ' . $row['nama_biro'])
                    ->setCellValue('F' . $column, $row['alamat_rumah'])
                    ->setCellValue('G' . $column, $row['telepon'])
                    ->setCellValue('H' . $column, $row['tempat_lahir'] . ', ' . $row['tanggal_lahir'])
                    ->setCellValue('I' . $column, $row['jenis_kelamin']);
                $spreadsheet->getActiveSheet()->getStyle("A$column:I$column")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $column++;
                $no++;
            }
        }

        // STYLING CELL HEADER
        $spreadsheet->getActiveSheet()->getStyle('A1:I2')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:I4')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A4:I4')->getFont()->setBold(true);

        // STYLING CELL BORDER
        $spreadsheet->getActiveSheet()->getStyle('A4:I4')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

        // SET VALUE OF COLUMN C (NIP) TO STRING
        $spreadsheet->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Pasien ' . date('d-m-Y');

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
