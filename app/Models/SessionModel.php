<?php
namespace App\Models;
use CodeIgniter\Model;

class SessionModel extends Model{
    protected $table = 'session';
    protected $allowedFields = ['session', 'price', 'currency_id','class_id'];

    function getAll(){
        return $this->findAll();
    }

    function create($data){        
        return $this->insert($data);
    }
}
 