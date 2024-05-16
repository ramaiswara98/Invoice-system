<?php
namespace App\Models;
use CodeIgniter\Model;

class ClassModel extends Model{
    protected $table = 'class';
    protected $allowedFields = ['class_name','branch_id','price','currency_id'];

    function getAll(){
        return $this->findAll();
    }

    function create($data){        
        return $this->insert($data);
    }

    function deleteClass($id){
        return $this->delete($id);
    }
}
 