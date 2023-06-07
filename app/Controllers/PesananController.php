<?php

namespace App\Controllers;

use Agoenxz21\Datatables\Datatable;
use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\PesananModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PesananController extends BaseController
{
    public function index()
    {
        return view('Admin/Pesanan/table', [
            'user' => (new UserModel())->findAll(),
            'menu' => (new MenuModel())->findAll()            
        ]);
    }

    public function all()
    {

        return (new Datatable(PesananModel::view()))
            ->setFieldFilter(['user, tgl_pesan'])
            ->draw();
    }

    public function show($id)
    {
        $r = (new PesananModel())->where('id', $id)->first();
        if ($r == null) throw PageNotFoundException::forPageNotFound();

        return $this->response->setJSON($r);
    }

    public function store()
    {
        $pm = new PesananModel();

        $user = session('user');
        $tanggal=date('Y-m-d');
        $id = $pm->insert([
            'user_id'         => $user['id'],
            'tgl_pesan'       => $this->request->getVar('tgl_pesan'),
            'menu_id'         => $this->request->getVar('menu_id'),
            'tgl_pesan'       => $tanggal,
            'total'           => $this->request->getVar('total'),
            'alamat'          => $this->request->getVar('alamat'),
            'status'          => $this->request->getVar('status'),
        ]);
        return $this->response->setJSON(['id' => $id])
            ->setStatusCode(intval($id) > 0 ? 200 : 406);
    }

    public function update()
    {
        $pm     = new PesananModel();
        $id     = (int)$this->request->getVar('id');

        if ($pm->find($id) == null)
            throw PageNotFoundException::forPageNotFound();

        $user = session('user');
        $tanggal=date('Y-m-d');
        $hasil = $pm->update($id, [
            'user_id'           => $user['id'],
            'tgl_pesan'         => $tanggal,
            'menu_id'           => $this->request->getVar('menu_id'),
            'total'             => $this->request->getVar('total'),
            'alamat'            => $this->request->getVar('alamat'),
            'status'          => $this->request->getVar('status'),
        ]);
        return $this->response->setJSON(['result' => $hasil]);
    }

    public function delete()
    {
        $pm     = new PesananModel();
        $id     = $this->request->getVar('id');
        $hasil  = $pm->delete($id);
        return $this->response->setJSON(['result' => $hasil]);
    }
}
