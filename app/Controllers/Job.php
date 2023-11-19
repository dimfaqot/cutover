<?php

namespace App\Controllers;

class Job extends BaseController
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
        $data = get_job($tahun, $bulan);

        return view(menu()['controller'], ['judul' => menu()['menu'], 'data' => $data['data'], 'tahun' => $data['tahun']]);
    }

    public function add()
    {
        $tgl = strtotime(clear($this->request->getVar('tgl')));
        $pkt = clear($this->request->getVar('paket'));
        $nama = upper_first(clear($this->request->getVar('nama')));
        $acara = clear($this->request->getVar('acara'));
        $lokasi = clear($this->request->getVar('lokasi'));
        $catatan = clear($this->request->getVar('catatan'));
        $url = clear($this->request->getVar('url'));

        $dbp = db('paket');
        $p = $dbp->where('id', $pkt)->get()->getRowArray();
        $paket = '';
        $harga_paket = 0;

        if ($p) {
            $paket = $p['paket'];
            $harga_paket = $p['harga'];
        }



        $data = [
            'tgl' => $tgl,
            'nama' => $nama,
            'lokasi' => $lokasi,
            'paket' => $paket,
            'harga_paket' => $harga_paket,
            'acara' => $acara,
            'catatan' => $catatan,
            'ket' => 'Waiting',
            'created_at' => time(),
            'updated_at' => time(),
            'admin' => session('nama')
        ];



        $db = db(menu()['tabel']);
        if ($db->insert($data)) {
            sukses($url, 'Data saved.');
        } else {
            gagal($url, 'Save failed!.');
        }
    }
    public function update()
    {
        $id = clear($this->request->getVar('id'));
        $tgl = strtotime(clear($this->request->getVar('tgl')));
        $pkt = clear($this->request->getVar('paket'));
        $nama = upper_first(clear($this->request->getVar('nama')));
        $acara = clear($this->request->getVar('acara'));
        $lokasi = clear($this->request->getVar('lokasi'));
        $catatan = clear($this->request->getVar('catatan'));
        $harga_paket = rp_to_int(clear($this->request->getVar('harga_paket')));
        $url = clear($this->request->getVar('url'));

        $db = db(menu()['tabel']);
        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal($url, 'Id not found.');
        }

        $dbp = db('paket');
        $p = $dbp->where('id', $pkt)->get()->getRowArray();
        $paket = $q['paket'];

        if ($p && $p['paket'] !== $q['paket']) {
            $paket = $p['paket'];
            $harga_paket = $p['harga'];
        }



        $exist = $db->whereNotIn('id', [$id])->where('paket', $paket)->get()->getRowArray();

        if ($exist) {
            gagal($url, 'Data already exist!.');
        }


        $q['tgl'] = $tgl;
        $q['nama'] = $nama;
        $q['lokasi'] = $lokasi;
        $q['paket'] = $paket;
        $q['harga_paket'] = $harga_paket;
        $q['acara'] = $acara;
        $q['catatan'] = $catatan;
        $q['updated_at'] = time();
        $q['admin'] = session('nama');


        $db->where('id', $id);
        if ($db->update($q)) {
            sukses($url, 'Data updated.');
        } else {
            gagal($url, 'Update failed!.');
        }
    }
    public function add_crew()
    {
        $job_id = clear($this->request->getVar('id'));
        $crew = upper_first(clear($this->request->getVar('crew')));
        $tugas = clear($this->request->getVar('tugas'));
        $fee = rp_to_int(clear($this->request->getVar('fee')));

        $db = db('pengeluaran');

        $data = [
            'job_id' => $job_id,
            'crew' => $crew,
            'tugas' => $tugas,
            'fee' => $fee,
            'created_at' => time(),
            'updated_at' => time(),
            'admin' => session('nama')
        ];

        if ($db->insert($data)) {
            $q = $db->where('job_id', $job_id)->orderBy('crew', 'ASC')->get()->getResultArray();
            sukses_js('Data saved.', $q);
        } else {
            gagal_js('Save failed!.');
        }
    }
    public function update_crew()
    {
        $id = clear($this->request->getVar('id'));
        $job_id = clear($this->request->getVar('job_id'));
        $val = clear($this->request->getVar('val'));
        $col = clear($this->request->getVar('col'));
        $fee = clear($this->request->getVar('fee'));

        $db = db('pengeluaran');

        $exist = $db->where('id', $id)->get()->getRowArray();

        if (!$exist) {
            gagal_js('Id not found!.');
        }

        $exist[$col] = $val;
        if ($col == 'tugas') {
            $exist['fee'] = $fee;
        }
        $exist['updated_at'] = time();
        $exist['admin'] = session('nama');

        $db->where('id', $id);
        if ($db->update($exist)) {
            $q = $db->where('job_id', $job_id)->orderBy('crew', 'ASC')->get()->getResultArray();
            sukses_js('Data saved.', $q);
        } else {
            gagal_js('Save failed!.');
        }
    }
    public function update_fee()
    {
        $id = clear($this->request->getVar('id'));
        $job_id = clear($this->request->getVar('job_id'));
        $val = rp_to_int(clear($this->request->getVar('val')));



        $db = db('pengeluaran');

        $exist = $db->where('id', $id)->get()->getRowArray();

        if (!$exist) {
            gagal_js('Id not found!.');
        }

        $exist['fee'] = $val;

        $exist['updated_at'] = time();
        $exist['admin'] = session('nama');
        $db->where('id', $id);
        if ($db->update($exist)) {
            $q = $db->where('job_id', $job_id)->orderBy('crew', 'ASC')->get()->getResultArray();
            sukses_js('Data saved.', $q);
        } else {
            gagal_js('Save failed!.');
        }
    }
    public function update_ket()
    {
        $id = clear($this->request->getVar('id'));
        $val = rp_to_int(clear($this->request->getVar('val')));



        $db = db('job');

        $exist = $db->where('id', $id)->get()->getRowArray();

        if (!$exist) {
            gagal_js('Id not found!.');
        }

        $exist['ket'] = $val;

        $exist['updated_at'] = time();
        $exist['admin'] = session('nama');
        $db->where('id', $id);
        if ($db->update($exist)) {
            sukses_js('Data updated.');
        } else {
            gagal_js('Update failed!.');
        }
    }
    public function delete()
    {
        $id = clear($this->request->getVar('id'));
        $tabel = clear($this->request->getVar('tabel'));
        $db = db($tabel);

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id not found!.');
        }

        $db->where('id', $id);
        if ($db->delete()) {
            sukses_js('Deleted success.');
        } else {
            gagal_js('Delete failed!.');
        }
    }
    public function delete_pengeluaran()
    {
        $id = clear($this->request->getVar('id'));
        $job_id = clear($this->request->getVar('job_id'));
        $tabel = clear($this->request->getVar('tabel'));
        $db = db($tabel);

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id not found!.');
        }

        $db->where('id', $id);
        if ($db->delete()) {
            $q = $db->where('job_id', $job_id)->orderBy('crew', 'ASC')->get()->getResultArray();
            sukses_js('Data saved.', $q);
        } else {
            gagal_js('Delete failed!.');
        }
    }
}
