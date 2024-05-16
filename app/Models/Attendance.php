<?php
namespace App\Models;
use CodeIgniter\Model;

class AttendanceModel extends Model{
    protected $table = 'attendance';
    protected $allowedFields = ['items_id', 'date'];


    function getAll(){
        return $this->findAll();
    }

    function getUser($username){
        return $this->where('username',$username)->first();
    }
}
 