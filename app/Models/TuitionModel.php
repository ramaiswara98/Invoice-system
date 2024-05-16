<?php
namespace App\Models;
use CodeIgniter\Model;

class TuitionModel extends Model{
    protected $table = 'tuition_type';
    protected $allowedFields = ['tuition_type'];

    function getAll(){
        return $this->findAll();
    }

    function create($data){        
        return $this->insert($data);
    }
}
 