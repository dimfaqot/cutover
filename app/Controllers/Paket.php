<?php

namespace App\Controllers;

class Paket extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Please Login!.');
        }
        check_role();
    }
    public function index(): string
    {
        $db = db(menu()['tabel']);
        $q = $db->orderBy('updated_at', 'DESC')->orderBy('paket', 'ASC')->get()->getResultArray();
        return view(menu()['controller'], ['judul' => menu()['menu'], 'data' => $q]);
    }

    public function add()
    {
        $paket = upper_first(clear($this->request->getVar('paket')));
        $harga = rp_to_int(clear($this->request->getVar('harga')));
        $db = db(menu()['tabel']);

        $exist = $db->where('paket', $paket)->get()->getRowArray();

        if ($exist) {
            gagal(base_url(menu()['controller']), 'Data already exist!.');
        }

        $data = [
            'paket' => $paket,
            'harga' => $harga,
            'created_at' => time(),
            'updated_at' => time(),
            'admin' => session('nama')
        ];


        if ($db->insert($data)) {
            sukses(base_url(menu()['controller']), 'Data saved.');
        } else {
            gagal(base_url(menu()['controller']), 'Save failed!.');
        }
    }
    public function update()
    {
        $id = clear($this->request->getVar('id'));
        $paket = upper_first(clear($this->request->getVar('paket')));
        $harga = rp_to_int(clear($this->request->getVar('harga')));
        $db = db(menu()['tabel']);

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal(base_url(menu()['controller']), 'Id not found.');
        }

        $exist = $db->whereNotIn('id', [$id])->where('paket', $paket)->get()->getRowArray();

        if ($exist) {
            gagal(base_url(menu()['controller']), 'Data already exist!.');
        }

        $q['paket'] = $paket;
        $q['harga'] = $harga;
        $q['updated_at'] = time();
        $q['admin'] = session('nama');


        $db->where('id', $id);
        if ($db->update($q)) {
            sukses(base_url(menu()['controller']), 'Data updated.');
        } else {
            gagal(base_url(menu()['controller']), 'Update failed!.');
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
}
