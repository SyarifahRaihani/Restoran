<?php

namespace App\Controllers;

use Agoenxz21\Datatables\Datatable;
use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Email\Email;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Email as ConfigEmail;

class UserController extends BaseController
{
    public function login()
    {
        $email      = $this->request->getPost('email');
        $password   = $this->request->getPost('sandi');

        $user       = (new UserModel())->where('email', $email)->first();

        if($user == null){
            return $this->response->setJSON(['message'=>'Email tidak terdaftar'])
                        ->setStatusCode(404);
        }

        $cekPassword  = password_verify($password, $user['sandi']);
        if($cekPassword == false){
            return $this->response->setJSON(['message'=>'Email dan sandi tidak cocok'])
                        ->setStatusCode(403);
        }

        $this->session->set('user', $user);
        return $this->response->setJSON(['message'=>"Selamat datang {$user['nama']} "])
                    ->setStatusCode(200);
    }

    public function viewLogin()
    {
        return view('login');
    }

    public function lupaPassword(){
        $_email = $this->request->getPost('email');

        $user = (new UserModel())->where('email', $_email)->first();

        if($user == null){
            return $this->response->setJSON(['message'=>'Email tidak terdaftar'])
                                  ->setStatusCode(404);
        }

        $sandibaru = substr( md5( date('Y-m-dH:i:s')),5,5 );
        $user['sandi'] = password_hash($sandibaru, PASSWORD_BCRYPT);
        $r = (new UserModel())->update($user['id'], $user);

        if($r == false){
            return $this->response->setJSON(['message'=>'Gagal merubah sandi'])
                        ->setStatusCode(502);
        }

        $email = new Email(new ConfigEmail());
        $email->setFrom('dfusionxx@gmail.com', 'Resrtoran Aroma Pontianak' );
        $email->setTo($user['email']);
        $email->setSubject('Reset Sandi User');
        $email->setMessage("Hallo {$user['nama']} telah meminta reset baru. Reset baru kamu adalah <b>$sandibaru</b>" );
        $r = $email->send();

        if($r == true){
            return $this->response->setJSON(['message'=>"Sandi baru sudah dikirim ke alamat email $_email"])
                        ->setStatusCode(200);
        }else{
            return $this->response->setJSON(['message'=>"Maaf ada kesalahan pengiriman email ke $_email"])
                        ->setStatusCode(500);
        }
    }

        public function viewLupaPassword()
        {
            return view('lupa_password');
        }

        public function logout()
        {
            $this->session->destroy();
            return redirect()->to('login');
        }

        public function index()
        {
            return view('User/table');
        }

        public function all()
        {
            $pm =new UserModel();
            $pm->select('id, nama, gender, email, level');
    
            return (new Datatable( $pm))
                    ->setFieldFilter([])
                    ->draw();
        }

        public function show($id)
        {
            $r = (new UserModel())->where('id', $id)->first();
            if($r == null)throw PageNotFoundException::forPageNotFound();

            return $this->response->setJSON($r);
        }

        public function store()
        {
            $pm     = new UserModel();
            $sandi  = $this->request->getVar('sandi');

            $id = $pm->insert([
                'nama'      => $this->request->getVar('nama'),
                'gender'    => $this->request->getVar('gender'),
                'email'    => $this->request->getVar('email'),
                'sandi'    => password_hash($sandi, PASSWORD_BCRYPT),
                'level'    => $this->request->getVar('level'),
            ]);
            return $this->response->setJSON(['id' => $id])
                        ->setStatusCode( intval($id) > 0 ? 200 : 406 );
        }

        public function update()
        {
            $pm     = new UserModel();
            $id     = (int)$this->request->getVar('id');

            if( $pm->find($id) == null )
            throw PageNotFoundException::forPageNotFound();

            $hasil  = $pm->update($id, [
                'nama'      => $this->request->getVar('nama'),
                'gender'    => $this->request->getVar('gender'),
                'email'    => $this->request->getVar('email'),
                'level'    => $this->request->getVar('level'),
            ]);
            return $this->response->setJSON(['result'=>$hasil]);
        }

        public function delete()
        {
            $pm     = new UserModel();
            $id     = $this->request->getVar('id');
            $hasil  = $pm->delete($id);
            return $this->response->setJSON(['result' => $hasil ]);
        }
}
