<?php
namespace App\Models;
use CodeIgniter\Model;

class ItemsModel extends Model{
    protected $table = 'items';
    protected $allowedFields = ['invoice_id', 'class_id','qty','discount'];


    function getAll(){
        return $this->findAll();
    }

    function create($data){        
        return $this->insert($data);
    }

    function getInvoiceById($invoice_id){
        return $this->where('invoice_id',$invoice_id)->all();
    }
}
 