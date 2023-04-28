<?php

namespace App\Controllers;

use Agoenxz21\Datatables\Datatable;
use App\Controllers\BaseController;
use App\Models\RuanganModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class RuanganController extends BaseController
{
    public function index()
    {
        return view('Ruangan/table');
    }

    public function all()
    {
        $pm =new RuanganModel();
        $pm->select('id, nama_ruangan, deskripsi');

        return (new Datatable( $pm ))
                ->setFieldFilter(['nama_ruangan'])
                ->draw();
    }

    public function show($id)
    {
        $r = (new RuanganModel())->where('id', $id)->first();
        if($r == null)throw PageNotFoundException::forPageNotFound();

        return $this->response->setJSON($r);
    }

    public function store()
    {
        $pm = new RuanganModel();

        $id = $pm->insert([
            'nama_ruangan'     => $this->request->getVar('nama_ruangan'),
            'deskripsi'         => $this->request->getVar('deskripsi'),
        ]);
        return $this->response->setJSON(['id' => $id])
                              ->setStatusCode( intval($id) > 0 ? 200 : 406 );
    }

    public function update()
    {
        $pm     = new RuanganModel();
        $id     = (int)$this->request->getVar('id');

        if( $pm->find($id) == null )
            throw PageNotFoundException::forPageNotFound();

        $hasil = $pm->update($id, [
            'nama_ruangan'     => $this->request->getVar('nama_ruangan'),
            'deskripsi'         => $this->request->getVar('deskripsi'),
        ]);
        return $this->response->setJSON(['result'=>$hasil]);
    }

    public function delete()
    {
        $pm     = new RuanganModel();
        $id     = $this->request->getVar('id');
        $hasil  = $pm->delete($id);
        return $this->response->setJSON(['result' => $hasil]);
    }
}
