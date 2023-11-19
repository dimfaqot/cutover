<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Please Login!.');
        }
        check_role();
    }
    public function index($tahun = null, $bulan = null)
    {
        $data = get_job($tahun, $bulan, 'laporan');

        $total_income = 0;
        $total_salaries = 0;

        foreach ($data['data'] as $i) {
            $total_income += $i['job']['harga_paket'];
            $total_salaries += $i['salaries'];
        }

        $total = ($total_income - $total_salaries);

        return view(menu()['controller'], ['judul' => menu()['menu'], 'data' => $data['data'], 'tahun' => $data['tahun'], 'total_income' => $total_income, 'total_salaries' => $total_salaries, 'total' => $total]);
    }

    public function cetak($order, $jwt)
    {

        $val = decode_jwt($jwt);



        if ($order == 'pdf') {
            $data = get_job($val['tahun'], $val['bulan'], 'laporan');

            $judul = 'LAPORAN KEUANGAN BULAN ' . ($val['bulan'] == 'All' ? 'SEMUA BULAN ' : strtoupper(bulan($val['bulan'])['bulan'])) . ' ' . ($val['tahun'] == 'All' ? 'SEMUA TAHUN ' : 'TAHUN ' . $val['tahun']);
            $total_income = 0;
            $total_salaries = 0;

            foreach ($data['data'] as $i) {
                $total_income += $i['job']['harga_paket'];
                $total_salaries += $i['salaries'];
            }
            $total = ($total_income - $total_salaries);
            $set = [
                'mode' => 'utf-8',
                'format' => [215, 330],
                'orientation' => 'P',
                'margin-left' => 20,
                'margin-right' => 20,
                'margin-top' => 0,
                'margin-bottom' => 0,
            ];

            $mpdf = new \Mpdf\Mpdf($set);
            $logo = '<img width="80px" src="' .  'logo.png" alt="Logo Djana"/>';
            $html = view('cetak_laporan', ['judul' => $judul, 'data' => $data, 'logo' => $logo, 'jwt' => $jwt, 'total_income' => $total_income, 'total_salaries' => $total_salaries, 'total' => $total]);
            $mpdf->AddPage();
            $mpdf->WriteHTML($html);


            $this->response->setHeader('Content-Type', 'application/pdf');
            $mpdf->Output($judul . '.pdf', 'I');
        }
        if ($order == 'invoice') {
            $id = $val['id'];
            $db = db('job');

            $q = $db->where('id', $id)->get()->getRowArray();

            if (!$q) {
                gagal(base_url('laporan'), 'Id not found!.');
            }
            $q = $db->where('id', $id)->where('ket', 'Done')->get()->getRowArray();
            if (!$q) {
                gagal(base_url('laporan'), 'Belum lunas!.');
            }
            $no = date('dmy', $q['tgl']) . $q['id'];
            $judul = 'INVOICE ' . $no;
            $set = [
                'mode' => 'utf-8',
                'format' => [200, 165],
                'orientation' => 'P',
                'margin-left' => 10,
                'margin-right' => 10,
                'margin-top' => 0,
                'margin-bottom' => 0,
            ];
            $q['no'] = $no;
            $mpdf = new \Mpdf\Mpdf($set);
            $logo = '<img width="80px" src="' .  'logo.png" alt="Logo Djana"/>';
            $html = view('cetak_invoice', ['judul' => $judul, 'data' => $q, 'logo' => $logo, 'jwt' => $jwt, 'cols' => $cols]);
            $mpdf->AddPage();
            $mpdf->WriteHTML($html);


            $this->response->setHeader('Content-Type', 'application/pdf');
            $mpdf->Output($judul . '.pdf', 'I');
        }

        if ($order == 'excel') {
            $data = get_job($val['tahun'], $val['bulan'])['data'];

            $judul = 'LAPORAN KEUANGAN BULAN ' . ($val['bulan'] == 'All' ? 'SEMUA BULAN ' : strtoupper(bulan($val['bulan'])['bulan'])) . ' ' . ($val['tahun'] == 'All' ? 'SEMUA TAHUN ' : 'TAHUN ' . $val['tahun']);
            $cols = ['tgl', 'nama', 'lokasi', 'acara', 'paket', 'harga_paket'];
            $spreadsheet = new Spreadsheet();

            $sheet = $spreadsheet->getActiveSheet();

            $huruf = 'Z';

            foreach ($cols as $k => $c) {
                $huruf++;
                if ($k < 26) {
                    $sheet->setCellValue(substr($huruf, -1) . '1', upper_first(str_replace("_", " ", $c)));
                } else {
                    $sheet->setCellValue('A' . substr($huruf, -1) . '1', upper_first(str_replace("_", " ", $c)));
                }
            }

            $rows = 2;
            $huruf = 'Z';
            foreach ($data as $i) {
                foreach ($cols as $k => $c) {
                    $huruf++;
                    if ($k < 26) {
                        $sheet->setCellValue(substr($huruf, -1) . $rows, ($c == 'tgl' ? date('d/m/Y', $i['job'][$c]) : $i['job'][$c]));
                    } else {
                        $sheet->setCellValue('A' . substr($huruf, -1) . $rows, ($c == 'tgl' ? date('d/m/Y', $i['job'][$c]) : $i['job'][$c]));
                    }
                }
                $huruf = 'Z';
                $rows++;
            }
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename=' . $judul . '.xlsx');
            header('Cache-Control: maxe-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');

            exit;
        }
    }
}
