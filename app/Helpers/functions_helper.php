<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


function db($tabel, $db = null)
{
    if ($db == null || $db == 'data') {
        $db = \Config\Database::connect();
    } else {
        $db = \Config\Database::connect(strtolower(str_replace(" ", "_", $db)));
    }
    $db = $db->table($tabel);

    return $db;
}

function clear($text)
{
    $text = trim($text);
    $text = htmlspecialchars($text);
    return $text;
}



function upper_first($text)
{
    $text = clear($text);
    $exp = explode(" ", $text);

    $val = [];
    foreach ($exp as $i) {
        $lower = strtolower($i);
        $val[] = ucfirst($lower);
    }

    return implode(" ", $val);
}

function sukses($url, $pesan)
{
    session()->setFlashdata('sukses', $pesan);
    header("Location: " . $url);
    die;
}

function gagal($url, $pesan)
{
    session()->setFlashdata('gagal', $pesan);
    header("Location: " . $url);
    die;
}

function sukses_js($pesan, $data = null, $data2 = null, $data3 = null, $data4 = null)
{
    $data = [
        'status' => '200',
        'message' => $pesan,
        'data' => $data,
        'data2' => $data2,
        'data3' => $data3,
        'data4' => $data4
    ];

    echo json_encode($data);
    die;
}

function gagal_js($pesan)
{
    $data = [
        'status' => '400',
        'message' => $pesan
    ];

    echo json_encode($data);
    die;
}

function menus()
{

    $db = db('menu');

    $q = $db->where('active', 1)->where('role', session('role'))->orderBy('no_urut', 'ASC')->get()->getResultArray();

    return $q;
}

function menu($req = null)
{
    if ($req == null) {
        foreach (menus() as $i) {
            if ($i['controller'] == url()) {
                return $i;
            }
        }
    } else {
        foreach (menus() as $i) {
            if ($i['controller'] == $req) {
                return $i;
            }
        }
    }
}

function check_role()
{
    $db = db('menu');

    $q = $db->where('role', session('role'))->where('controller', url())->get()->getRowArray();

    if (!$q) {
        gagal(base_url('home'), 'You are not allowed.');
    }
}


// function url($req = 3)
// {
//     $url = service('uri');
//     $res = $url->getPath();

//     $req = $req - 1;
//     $exp = explode("/", $res);


//     if (array_key_exists($req, $exp)) {
//         return $exp[$req];
//     }

//     return '';
// }
function url($req = 4)
{
    $url = service('uri');
    $res = $url->getPath();


    $req = $req - 1;

    $exp = explode("/", $res);
    dd($exp);

    if (array_key_exists($req, $exp)) {
        return $exp[$req];
    }

    return '';
}


function settings()
{
    $db = db('settings');
    $q = $db->get()->getRowArray();
    return $q;
}
function options($kategori)
{
    $db = db('options');
    if ($kategori == 'Role') {
        if (session('role') == 'Root') {
            $q = $db->where('kategori', $kategori)->orderBy(($kategori == 'Ket' ? 'id' : 'value'), 'ASC')->get()->getResultArray();
        } else {
            $q = $db->where('kategori', $kategori)->whereNotIn('value', ['Root'])->orderBy(($kategori == 'Ket' ? 'id' : 'value'), 'ASC')->get()->getResultArray();
        }
    } else {
        $q = $db->where('kategori', $kategori)->orderBy(($kategori == 'Ket' ? 'id' : 'value'), 'ASC')->get()->getResultArray();
    }
    return $q;
}

function rupiah($uang)
{
    return 'Rp. ' . number_format($uang, 0, ",", ".");
}

function rp_to_int($uang)
{
    $uang = str_replace("Rp. ", "", $uang);
    $uang = str_replace(".", "", $uang);
    return $uang;
}

function get_job($tahun, $bulan, $order = null)
{
    $tahun = ($tahun == null ? date('Y') : $tahun);
    $bulan = ($bulan == null ? date('m') : $bulan);
    $db = db('job');
    $db;
    if ($order !== null) {
        $db->where('ket', 'Done');
    }
    $job = $db->orderBy('tgl', 'ASC')->orderBy('nama', 'ASC')->get()->getResultArray();

    $dbp = db('pengeluaran');

    $data = [];
    $th = [];
    foreach ($job as $i) {
        if (!in_array(date('Y', $i['tgl']), $th)) {
            $th[] = date('Y', $i['tgl']);
        }

        if ($tahun !== 'All' && $bulan !== 'All') {
            if (date('Y', $i['tgl']) == $tahun && date('m', $i['tgl']) == $bulan) {
                $q = $dbp->where('job_id', $i['id'])->orderBy('crew', 'ASC')->get()->getResultArray();
                $salaries = 0;

                foreach ($q as $e) {
                    $salaries += $e['fee'];
                }
                $data[] = ['job' => $i, 'crew' => $q, 'salaries' => $salaries];
            }
        }

        if ($tahun == 'All' && $bulan == 'All') {
            $q = $dbp->where('job_id', $i['id'])->orderBy('crew', 'ASC')->get()->getResultArray();
            $salaries = 0;

            foreach ($q as $e) {
                $salaries += $e['fee'];
            }
            $data[] = ['job' => $i, 'crew' => $q, 'salaries' => $salaries];
        }

        if ($tahun !== 'All' && $bulan == 'All') {

            if (date('Y', $i['tgl']) == $tahun) {
                $q = $dbp->where('job_id', $i['id'])->orderBy('crew', 'ASC')->get()->getResultArray();
                $salaries = 0;

                foreach ($q as $e) {
                    $salaries += $e['fee'];
                }
                $data[] = ['job' => $i, 'crew' => $q, 'salaries' => $salaries];
            }
        }

        if ($tahun == 'All' && $bulan !== 'All') {

            if (date('m', $i['tgl']) == $bulan) {
                $q = $dbp->where('job_id', $i['id'])->orderBy('crew', 'ASC')->get()->getResultArray();
                $salaries = 0;

                foreach ($q as $e) {
                    $salaries += $e['fee'];
                }
                $data[] = ['job' => $i, 'crew' => $q, 'salaries' => $salaries];
            }
        }
    }
    $res = ['data' => $data, 'tahun' => $th];
    return $res;
}

function paket()
{
    $db = db('paket');
    $q = $db->orderBy('paket', 'ASC')->get()->getResultArray();

    return $q;
}
function crew()
{
    $db = db('crew');
    $q = $db->orderBy('nama', 'ASC')->get()->getResultArray();

    return $q;
}
function tugas()
{
    $db = db('tugas');
    $q = $db->orderBy('tugas', 'ASC')->get()->getResultArray();

    return $q;
}

function bulan($req = null)
{
    $bulan = [
        ['romawi' => 'I', 'bulan' => 'Januari', 'angka' => '01', 'satuan' => 1],
        ['romawi' => 'II', 'bulan' => 'Februari', 'angka' => '02', 'satuan' => 2],
        ['romawi' => 'III', 'bulan' => 'Maret', 'angka' => '03', 'satuan' => 3],
        ['romawi' => 'IV', 'bulan' => 'April', 'angka' => '04', 'satuan' => 4],
        ['romawi' => 'V', 'bulan' => 'Mei', 'angka' => '05', 'satuan' => 5],
        ['romawi' => 'VI', 'bulan' => 'Juni', 'angka' => '06', 'satuan' => 6],
        ['romawi' => 'VII', 'bulan' => 'Juli', 'angka' => '07', 'satuan' => 7],
        ['romawi' => 'VIII', 'bulan' => 'Agustus', 'angka' => '08', 'satuan' => 8],
        ['romawi' => 'IX', 'bulan' => 'September', 'angka' => '09', 'satuan' => 9],
        ['romawi' => 'X', 'bulan' => 'Oktober', 'angka' => '10', 'satuan' => 10],
        ['romawi' => 'XI', 'bulan' => 'November', 'angka' => '11', 'satuan' => 11],
        ['romawi' => 'XII', 'bulan' => 'Desember', 'angka' => '12', 'satuan' => 12]
    ];

    $res = $bulan;
    foreach ($bulan as $i) {
        if ($i['bulan'] == $req) {
            $res = $i;
        } elseif ($i['angka'] == $req) {
            $res = $i;
        } elseif ($i['satuan'] == $req) {
            $res = $i;
        } elseif ($i['romawi'] == $req) {
            $res = $i;
        }
    }
    return $res;
}

function get_cols($tabel)
{

    $db = \Config\Database::connect();
    $q = $db->getFieldNames($tabel);

    $data = [];

    foreach ($q as $i) {
        if ($i !== 'id' && $i !== 'updated_at' && $i !== 'created_at' && $i !== 'admin') {
            $data[] = $i;
        }
    }
    return $data;
}

function key_jwt()
{
    $db = db('settings');

    $q = $db->get()->getRowArray();
    return $q['key_jwt'];
}

function encode_jwt($data)
{

    $jwt = JWT::encode($data, key_jwt(), 'HS256');

    return $jwt;
}

function decode_jwt($encode_jwt)
{
    try {

        $decoded = JWT::decode($encode_jwt, new Key(key_jwt(), 'HS256'));
        $arr = (array)$decoded;

        return $arr;
    } catch (\Exception $e) { // Also tried JwtException
        $data = [
            'status' => '400',
            'message' => $e->getMessage()
        ];

        echo json_encode($data);
        die;
    }
}
