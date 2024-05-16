<?php
namespace App\Models;
use CodeIgniter\Model;

class InvoiceModel extends Model{
    protected $table = 'invoice';
    protected $allowedFields = ['student_id', 'status','date'];


    function getAll(){
        return $this->findAll();
    }

    function create($data){        
        return $this->insert($data);
    }

    function getInvoiceById($id){
        return $this->where('id',$id)->first();
    }
    
    function deleteInvoice($id){
        return $this->delete($id);
    }
}
 