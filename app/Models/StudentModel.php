<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentModel extends Model{
    protected $table = 'student';
    protected $allowedFields = ['name', 'email','address','school','grade','parent_name','parent_email','branch_id','student_no'];

    function getAll(){
        return $this->findAll();
    }

    function create($data){        
        return $this->insert($data);
    }

    function getStudentById($id){
        return $this->where('id',$id)->first();
    }

    function deleteStudent($id){
        return $this->delete($id);
    }
}
 