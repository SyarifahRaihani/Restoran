<?php

namespace App\Controllers;

use Agoenxz21\Datatables\Datatable;
use App\Controllers\BaseController;
use App\Models\ProdukModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ProdukController extends BaseController
{
    public function index()
    {
        return view('Produk/table');
    }

    public function all()
    {
        $pm =new ProdukModel();
        $pm->select('id, kode, nama, deskripsi, kategori_id, status, harga_jual, diskon, harga_standar, foto, terjual');

        return (new Datatable( $pm ))
                ->setFieldFilter(['nama'])
                ->draw();
    }

    public function show($id)
    {
        $r = (new ProdukModel())->where('id', $id)->first();
        if($r == null)throw PageNotFoundException::forPageNotFound();

        return $this->response->setJSON($r);
    }

    public function store()
    {
        $pm = new ProdukModel();

        $id = $pm->insert([
            'kode'          => $this->request->getVar('kode'),
            'nama'          => $this->request->getVar('nama'),
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'kategori_id'   => $this->request->getVar('kategori_id'),
            'status'        => $this->request->getVar('status'),
            'harga_jual'    => $this->request->getVar('harga_jual'),
            'diskon'        => $this->request->getVar('diskon'),
            'harga_standar' => $this->request->getVar('harga_standar'),
            'foto'          => $this->request->getVar('foto'),
            'terjual'       => $this->request->getVar('nama'),
        ]);
        return $this->response->setJSON(['id' => $id])
                              ->setStatusCode( intval($id) > 0 ? 200 : 406 );
    }

    public function update()
    {
        $pm     = new ProdukModel();
        $id     = (int)$this->request->getVar('id');

        if( $pm->find($id) == null )
            throw PageNotFoundException::forPageNotFound();

        $hasil = $pm->update($id, [
            'kode'          => $this->request->getVar('kode'),
            'nama'          => $this->request->getVar('nama'),
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'kategori_id'   => $this->request->getVar('kategori_id'),
            'status'        => $this->request->getVar('status'),
            'harga_jual'    => $this->request->getVar('harga_jual'),
            'diskon'        => $this->request->getVar('diskon'),
            'harga_standar' => $this->request->getVar('harga_standar'),
            'foto'          => $this->request->getVar('foto'),
            'terjual'       => $this->request->getVar('nama'),
        ]);
        return $this->response->setJSON(['result'=>$hasil]);
    }

    public function delete()
    {
        $pm     = new ProdukModel();
        $id     = $this->request->getVar('id');
        $hasil  = $pm->delete($id);
        return $this->response->setJSON(['result' => $hasil]);
    }
}
