<?php

namespace App\Controllers;

use Agoenxz21\Datatables\Datatable;
use App\Controllers\BaseController;
use App\Models\PelangganModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PelangganController extends BaseController
{
    public function index()
    {
        return view('Pelanggan/table');
    }

    public function all()
    {
        $pm =new PelangganModel();
        $pm->select('id, nama, gender, alamat, email, sandi, nohp');

        return (new Datatable( $pm ))
                ->setFieldFilter(['nama', 'email', 'nohp'])
                ->draw();
    }

    public function show($id)
    {
        $r = (new PelangganModel())->where('id', $id)->first();
        if($r == null)throw PageNotFoundException::forPageNotFound();

        return $this->response->setJSON($r);
    }

    public function store()
    {
        $pm = new PelangganModel();
        $sandi  = $this->request->getVar('sandi');

        $id = $pm->insert([
            'nama'      => $this->request->getVar('nama'),
            'gender'    => $this->request->getVar('gender'),
            'alamat'      => $this->request->getVar('alamat'),
            'email'    => $this->request->getVar('email'),
            'sandi'    => password_hash($sandi, PASSWORD_BCRYPT),
            'nohp'    => $this->request->getVar('nohp'),
        ]);
        return $this->response->setJSON(['id' => $id])
                              ->setStatusCode( intval($id) > 0 ? 200 : 406 );
    }

    public function update()
    {
        $pm     = new PelangganModel();
        $id     = (int)$this->request->getVar('id');

        if( $pm->find($id) == null )
            throw PageNotFoundException::forPageNotFound();

        $hasil = $pm->update($id, [
            'nama'      => $this->request->getVar('nama'),
            'gender'    => $this->request->getVar('gender'),
            'alamat'      => $this->request->getVar('alamat'),
            'email'    => $this->request->getVar('email'),
            'nohp'    => $this->request->getVar('nohp'),
        ]);
        return $this->response->setJSON(['result'=>$hasil]);
    }

    public function delete()
    {
        $pm     = new PelangganModel();
        $id     = $this->request->getVar('id');
        $hasil  = $pm->delete($id);
        return $this->response->setJSON(['result' => $hasil]);
    }
}
