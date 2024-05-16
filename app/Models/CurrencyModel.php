<?php
namespace App\Models;
use CodeIgniter\Model;

class CurrencyModel extends Model{
    protected $table = 'currency';
    protected $allowedFields = ['name', 'code'];

    function getAll(){
        return $this->findAll();
    }

    function create($data){        
        return $this->insert($data);
    }
    
    function deleteCurrency($id){
        return $this->delete($id);
    }
}
 