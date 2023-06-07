<?php

namespace App\Controllers;

use Agoenxz21\Datatables\Datatable;
use App\Controllers\BaseController;
use App\Models\MejaModel;
use App\Models\ReservasiModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ReservasiController extends BaseController
{
    public function index()
    {
        return view('Admin/Reservasi/table', [
            'user' => (new UserModel())->findAll(),
            'meja' => (new MejaModel())->findAll()
        ]);
    }

    public function all()
    {
        
        return (new Datatable( ReservasiModel::view() ))
                ->setFieldFilter(['user_id, tgl_booking'])
                ->draw();
    }

    public function show($id)
    {
        $r = (new ReservasiModel())->where('id', $id)->first();
        if($r == null)throw PageNotFoundException::forPageNotFound();

        return $this->response->setJSON($r);
    }

    public function store()
    {
        $pm = new ReservasiModel();
      
        $user = session('user');
        $id = $pm->insert([
            'user_id'         => $user['id'],
            'tgl_booking '    => $this->request->getVar('tgl_booking'),
            'waktu_booking '  => $this->request->getVar('waktu_booking'),
            'meja_id'         => $this->request->getVar('meja_id'),
            'status'          => $this->request->getVar('status'),
        ]);
        return $this->response->setJSON(['id' => $id])
                              ->setStatusCode( intval($id) > 0 ? 200 : 406 );
    }

    public function update()
    {
        $pm     = new ReservasiModel();
        $id     = (int)$this->request->getVar('id');

        if( $pm->find($id) == null )
            throw PageNotFoundException::forPageNotFound();

        $user = session('user');
        $hasil = $pm->update($id, [
            'user_id'         => $user['id'],
            'tgl_booking '    => $this->request->getVar('tgl_booking '),
            'waktu_booking '  => $this->request->getVar('waktu_booking '),
            'meja_id'         => $this->request->getVar('meja_id'),
            'status'         => $this->request->getVar('status'),
        ]);
        return $this->response->setJSON(['result'=>$hasil]);
    }

    public function delete()
    {
        $pm     = new ReservasiModel();
        $id     = $this->request->getVar('id');
        $hasil  = $pm->delete($id);
        return $this->response->setJSON(['result' => $hasil]);
    }
}
