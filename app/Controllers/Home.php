<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $session = session();
        if(isset($_SESSION['username'])){
            return redirect()->to(base_url()."/admin/branch");
        }else{
            return redirect()->to(base_url()."/auth/login");
        }
    }
}
