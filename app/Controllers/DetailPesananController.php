<?php

namespace App\Controllers;

use Agoenxz21\Datatables\Datatable;
use App\Controllers\BaseController;
use App\Models\DetailPesananModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DetailPesananController extends BaseController
{
    public function index()
    {
        return view('DetailPesanan/table');
    }

    public function all()
    {
        $pm =new DetailPesananModel();
        $pm->select('id, produk_id, harga_jual, jumlah');

        return (new Datatable( $pm ))
                ->setFieldFilter(['produk_id'])
                ->draw();
    }

    public function show($id)
    {
        $r = (new DetailPesananModel())->where('id', $id)->first();
        if($r == null)throw PageNotFoundException::forPageNotFound();

        return $this->response->setJSON($r);
    }

    public function store()
    {
        $pm = new DetailPesananModel();

        $id = $pm->insert([
            'produk_id'     => $this->request->getVar('produk_id'),
            'harga_jual'         => $this->request->getVar('harga_jual'),
            'jumlah'         => $this->request->getVar('jumlah'),
        ]);
        return $this->response->setJSON(['id' => $id])
                              ->setStatusCode( intval($id) > 0 ? 200 : 406 );
    }

    public function update()
    {
        $pm     = new DetailPesananModel();
        $id     = (int)$this->request->getVar('id');

        if( $pm->find($id) == null )
            throw PageNotFoundException::forPageNotFound();

        $hasil = $pm->update($id, [
            'produk_id'     => $this->request->getVar('produk_id'),
            'harga_jual'         => $this->request->getVar('harga_jual'),
            'jumlah'         => $this->request->getVar('jumlah'),
        ]);
        return $this->response->setJSON(['result'=>$hasil]);
    }

    public function delete()
    {
        $pm     = new DetailPesananModel();
        $id     = $this->request->getVar('id');
        $hasil  = $pm->delete($id);
        return $this->response->setJSON(['result' => $hasil]);
    }
}
