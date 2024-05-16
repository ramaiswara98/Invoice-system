<?php
namespace App\Models;
use CodeIgniter\Model;

class ReceiveModel extends Model{
    protected $table = 'receive';
    protected $allowedFields = ['invoice_id', 'receive_no','receive_date','amount','method'];


    function getAll(){
        return $this->findAll();
    }

    function create($data){        
        return $this->insert($data);
    }

    function getReceiveByInvoiceId($invoice_id){
        return $this->where('invoice_id',$invoice_id)->all();
    }
}
 