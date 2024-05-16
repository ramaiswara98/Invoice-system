<?php
namespace App\Models;
use CodeIgniter\Model;

class AdminModel extends Model{
    protected $table = 'admin';
    protected $allowedFields = ['username', 'password'];


    function getAll(){
        return $this->findAll();
    }

    function getUser($username){
        return $this->where('username',$username)->first();
    }
}
 