<?php

namespace App\Controllers;

use Agoenxz21\Datatables\Datatable;
use App\Controllers\BaseController;
use App\Models\MejaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class MejaController extends BaseController
{
    public function index()
    {
        return view('Meja/table');
    }

    public function all()
    {
        $pm =new MejaModel();
        $pm->select('id, nama_meja, no_meja, kapasitas, status, ruangan_id');

        return (new Datatable( $pm ))
                ->setFieldFilter(['nama_meja'])
                ->draw();
    }

    public function show($id)
    {
        $r = (new MejaModel())->where('id', $id)->first();
        if($r == null)throw PageNotFoundException::forPageNotFound();

        return $this->response->setJSON($r);
    }

    public function store()
    {
        $pm = new MejaModel();

        $id = $pm->insert([
            'nama_meja'         => $this->request->getVar('nama_meja'),
            'no_meja'           => $this->request->getVar('no_meja'),
            'kapasitas'         => $this->request->getVar('kapasitas'),
            'status'            => $this->request->getVar('status'),
            'ruangan_id'        => $this->request->getVar('ruangan_id'),
        ]);
        return $this->response->setJSON(['id' => $id])
                              ->setStatusCode( intval($id) > 0 ? 200 : 406 );
    }

    public function update()
    {
        $pm     = new MejaModel();
        $id     = (int)$this->request->getVar('id');

        if( $pm->find($id) == null )
            throw PageNotFoundException::forPageNotFound();

        $hasil = $pm->update($id, [
            'nama_meja'     => $this->request->getVar('nama_meja'),
            'no_meja'       => $this->request->getVar('no_meja'),
            'kapasitas'     => $this->request->getVar('kapasitas'),
            'status'        => $this->request->getVar('status'),
            'ruangan_id'    => $this->request->getVar('ruangan_id'),
        ]);
        return $this->response->setJSON(['result'=>$hasil]);
    }

    public function delete()
    {
        $pm     = new MejaModel();
        $id     = $this->request->getVar('id');
        $hasil  = $pm->delete($id);
        return $this->response->setJSON(['result' => $hasil]);
    }
}
