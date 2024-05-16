<?php
namespace App\Models;
use CodeIgniter\Model;

class BranchModel extends Model{
    protected $table = 'branch';
    protected $allowedFields = ['branch_name', 'address','email','currency_id'];

    function getAll(){
        return $this->findAll();
    }

    function create($data){        
        return $this->insert($data);
    }

    function deleteBranch($id){
        return $this->delete($id);
    }
}
 