<?php

namespace App\Controllers;

use Agoenxz21\Datatables\Datatable;
use App\Controllers\BaseController;
use App\Models\PesananModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PesananController extends BaseController
{
    public function index()
    {
        return view('Pesanan/table');
    }

    public function all()
    {
        $pm = new PesananModel();
        $pm->select('id, no_pesan, pelanggan_id, alamat');

        return (new Datatable($pm))
            ->setFieldFilter(['no_pesan'])
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

        $id = $pm->insert([
            'no_pesan'     => $this->request->getVar('no_pesan'),
            'pelanggan_id'         => $this->request->getVar('pelanggan_id'),
            'alamat'         => $this->request->getVar('alamat'),
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

        $hasil = $pm->update($id, [
            'no_pesan'     => $this->request->getVar('no_pesan'),
            'pelanggan_id'         => $this->request->getVar('pelanggan_id'),
            'alamat'         => $this->request->getVar('alamat'),
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
