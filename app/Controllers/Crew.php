<?php

namespace App\Controllers;

class Crew extends BaseController
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
        $q = $db->orderBy('updated_at', 'DESC')->orderBy('nama', 'ASC')->get()->getResultArray();
        return view(menu()['controller'], ['judul' => menu()['menu'], 'data' => $q]);
    }

    public function add()
    {
        $nama = upper_first(clear($this->request->getVar('nama')));
        $db = db(menu()['tabel']);

        $data = [
            'nama' => $nama,
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
        $nama = upper_first(clear($this->request->getVar('nama')));
        $db = db(menu()['tabel']);

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal(base_url(menu()['controller']), 'Id not found.');
        }

        $q['nama'] = $nama;
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
