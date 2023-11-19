<?php

namespace App\Controllers;

class Tugas extends BaseController
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
        $q = $db->orderBy('updated_at', 'DESC')->orderBy('tugas', 'ASC')->get()->getResultArray();
        return view(menu()['controller'], ['judul' => menu()['menu'], 'data' => $q]);
    }

    public function add()
    {
        $tugas = upper_first(clear($this->request->getVar('tugas')));
        $fee = rp_to_int(clear($this->request->getVar('fee')));
        $db = db(menu()['tabel']);

        $exist = $db->where('tugas', $tugas)->get()->getRowArray();

        if ($exist) {
            gagal(base_url(menu()['controller']), 'Data already exist!.');
        }

        $data = [
            'tugas' => $tugas,
            'fee' => $fee,
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
        $tugas = upper_first(clear($this->request->getVar('tugas')));
        $fee = rp_to_int(clear($this->request->getVar('fee')));
        $db = db(menu()['tabel']);

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal(base_url(menu()['controller']), 'Id not found.');
        }

        $exist = $db->whereNotIn('id', [$id])->where('tugas', $tugas)->get()->getRowArray();

        if ($exist) {
            gagal(base_url(menu()['controller']), 'Data already exist!.');
        }

        $q['tugas'] = $tugas;
        $q['fee'] = $fee;
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
