<?php

namespace App\Controllers;

use Agoenxz21\Datatables\Datatable;
use App\Controllers\BaseController;
use App\Database\Migrations\Meja;
use App\Models\MejaModel;
use App\Models\RuanganModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class MejaController extends BaseController
{
    public function index()
    {
        return view('Admin/Meja/table');
    }

    public function all()
    {
        

        $pm =new MejaModel();
        $pm->select('id, meja, kapasitas, status');

        return (new Datatable( $pm ))
                ->setFieldFilter(['meja'])
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
            'meja'         => $this->request->getVar('meja'),
            'kapasitas'         => $this->request->getVar('kapasitas'),
            'status'            => $this->request->getVar('status'),
            
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
            'meja'         => $this->request->getVar('meja'),
            'kapasitas'         => $this->request->getVar('kapasitas'),
            'status'            => $this->request->getVar('status'),
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
