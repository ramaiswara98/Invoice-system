<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\UsersModel;
use PDO;

class Auth extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
    public function login(): string
    {
        $status=NULL;
        if($this->request->getGet('status')!= NULL){
            $status = $this->request->getGet('status');
        }
        $data['status'] = $status;
        return view('auth/login', $data);
    }

    public function checkLogin(){
        $data = $this->request->getVar();
        
        $username = $data['username'];
        $password = $data['password'];
        $model =  new UsersModel();
        $getUser = $model->getUser($username);
        if($getUser == NULL){
            return redirect()->to(base_url()."/auth/login?status=usernotfound");
        }else{
            if(password_verify($password,$getUser['password'])){
                echo $getUser['name'];
                $session = session();
                $session->set($getUser);
                $id = $session->get('id');
                $db = db_connect();
                $db->query("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = $id");
                return redirect()->to(base_url()."/admin/dashboard");
            }else{
                return redirect()->to(base_url()."/auth/login?status=incorrectpassword");
            }
           
        }

    }

    public function logout(){
        $session = session();
        $session->remove('username');
        $session->remove('password');
        $session->remove('name');
        $session->remove('email');
        return redirect()->to(base_url()."/auth/login");
    }
}
