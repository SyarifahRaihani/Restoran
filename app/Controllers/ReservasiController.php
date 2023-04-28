<?php

namespace App\Controllers;

use Agoenxz21\Datatables\Datatable;
use App\Controllers\BaseController;
use App\Models\ReservasiModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ReservasiController extends BaseController
{
    public function index()
    {
        return view('Reservasi/table');
    }

    public function all()
    {
        $pm =new ReservasiModel();
        $pm->select('id, no_reservasi, pelanggan_id, tgl_booking, waktu_booking');

        return (new Datatable( $pm ))
                ->setFieldFilter(['no_reservasi'])
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

        $id = $pm->insert([
            'no_reservasi'     => $this->request->getVar('no_reservasi'),
            'pelanggan_id, '   => $this->request->getVar('pelanggan_id, '),
            'tgl_booking, '    => $this->request->getVar('tgl_booking, '),
            'waktu_booking, '  => $this->request->getVar('waktu_booking, '),
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

        $hasil = $pm->update($id, [
            'no_reservasi'     => $this->request->getVar('no_reservasi'),
            'pelanggan_id, '         => $this->request->getVar('pelanggan_id, '),
            'tgl_booking, '         => $this->request->getVar('tgl_booking, '),
            'waktu_booking, '         => $this->request->getVar('waktu_booking, '),
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
