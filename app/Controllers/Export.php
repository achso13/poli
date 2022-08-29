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

    public function kunjungan()
    {
        $data['result'] =  $this->appointmentModel->getAppointments(NULL, "Offline");

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Tanggal')
            ->setCellValue('C1', 'Nama Pasien')
            ->setCellValue('D1', 'Jenis Kelamin')
            ->setCellValue('E1', 'Usia')
            ->setCellValue('F1', 'Unit Kerja')
            ->setCellValue('G1', 'Keluhan')
            ->setCellValue('H1', 'Nama Dokter');

        $column = 2;

        if (!empty($data['result'])) {
            foreach ($data['result'] as $row) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $column, $column - 1)
                    ->setCellValue('B' . $column, $row['tanggal_kunjungan'])
                    ->setCellValue('C' . $column, $row['nama_pasien'])
                    ->setCellValue('D' . $column, $row['jenis_kelamin'])
                    ->setCellValue('E' . $column, countAge($row['tanggal_lahir']))
                    ->setCellValue('F' . $column, $row['nama_bagian'] . ' - ' . $row['nama_biro'])
                    ->setCellValue('G' . $column, $row['keluhan'])
                    ->setCellValue('H' . $column, $row['nama_dokter']);
                $column++;
            }
        }

        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Kunjungan';

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function tiket()
    {
        $data['result'] =  $this->appointmentModel->getAppointments(NULL, "Online");

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Tanggal')
            ->setCellValue('C1', 'Nama Pasien')
            ->setCellValue('D1', 'Jenis Kelamin')
            ->setCellValue('E1', 'Usia')
            ->setCellValue('F1', 'Unit Kerja')
            ->setCellValue('G1', 'Keluhan')
            ->setCellValue('H1', 'Nama Dokter');

        $column = 2;

        if (!empty($data['result'])) {
            foreach ($data['result'] as $row) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $column, $column - 1)
                    ->setCellValue('B' . $column, $row['tanggal_kunjungan'])
                    ->setCellValue('C' . $column, $row['nama_pasien'])
                    ->setCellValue('D' . $column, $row['jenis_kelamin'])
                    ->setCellValue('E' . $column, countAge($row['tanggal_lahir']))
                    ->setCellValue('F' . $column, $row['nama_bagian'] . ' - ' . $row['nama_biro'])
                    ->setCellValue('G' . $column, $row['keluhan'])
                    ->setCellValue('H' . $column, $row['nama_dokter']);
                $column++;
            }
        }

        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Tiket';

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
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'ID Obat')
            ->setCellValue('C1', 'Nama Obat')
            ->setCellValue('D1', 'Stok')
            ->setCellValue('E1', 'Satuan')
            ->setCellValue('F1', 'Update Terakhir');

        $column = 2;

        if (!empty($data['result'])) {
            foreach ($data['result'] as $row) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $column, $column - 1)
                    ->setCellValue('B' . $column, $row['id_obat'])
                    ->setCellValue('C' . $column, $row['nama_obat'])
                    ->setCellValue('D' . $column, $row['stok'])
                    ->setCellValue('E' . $column, $row['satuan'])
                    ->setCellValue('F' . $column, $row['updated_at']);

                $column++;
            }
        }

        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Obat';

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
