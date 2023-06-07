<?php

namespace App\Controllers;

use Agoenxz21\Datatables\Datatable;
use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\MenuModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class MenuController extends BaseController
{
    public function index()
    {
        return view('Admin/Menu/table', [
            'kategori' => (new KategoriModel())->findAll()
        ]);
    }

    public function all()
    {
    

        return (new Datatable( MenuModel::view() ))
                ->setFieldFilter(['nama'])
                ->draw();
    }

    public function show($id)
    {
        $r = (new MenuModel())->where('id', $id)->first();
        if($r == null)throw PageNotFoundException::forPageNotFound();

        return $this->response->setJSON($r);
    }

    public function store()
    {
        $pm = new MenuModel();

        $id = $pm->insert([
            'nama'          => $this->request->getVar('nama'),
            'kategori_id'   => $this->request->getVar('kategori_id'),
            'harga'    => $this->request->getVar('harga'),
        ]);
        if($id > 0){
            $this->simpanFile($id);
        }
        return $this->response->setJSON(['id' => $id])
                              ->setStatusCode( intval($id) > 0 ? 200 : 406 );
    }

    public function update()
    {
        $pm     = new MenuModel();
        $id     = (int)$this->request->getVar('id');

        if( $pm->find($id) == null )
            throw PageNotFoundException::forPageNotFound();

        $hasil = $pm->update($id, [
            'nama'          => $this->request->getVar('nama'),
            'kategori_id'   => $this->request->getVar('kategori_id'),
            'harga'    => $this->request->getVar('harga'),
            'foto'          => $this->request->getVar('foto'),
        ]);
        if($hasil == true){
            $this->simpanFile($id);
        }
        return $this->response->setJSON(['result'=>$hasil]);
    }

    public function delete()
    {
        $pm     = new MenuModel();
        $id     = $this->request->getVar('id');
        $hasil  = $pm->delete($id);
        return $this->response->setJSON(['result' => $hasil]);
    }

    private function simpanFile($id){
        $file = $this->request->getFile('berkas');

        if($file->hasMoved() == false){
            $patch = './uploads/menu/';
 
            if(!file_exists($patch)){
                @mkdir($patch, recursive: true);
            }

            $patch = $file->store(
                            folderName: 'menu',
                            fileName: "$id.jpg"
                        );
            (new MenuModel())->update($id, [
                'foto'=>$patch
            ]);
            return $patch;
        }
        return null;
    }

    public function foto($id){
        $file = './uploads/menu/'.$id.'.jpg';

        if(!file_exists($file)){
            throw PageNotFoundException::forPageNotFound();
        }

        echo file_get_contents($file);
        return $this->response
                    ->setHeader('Content-type','image/jpeg')
                    ->sendBody();
    }
}
