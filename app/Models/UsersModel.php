<?php
namespace App\Models;
use CodeIgniter\Model;

class UsersModel extends Model{
    protected $table = 'users';
    protected $allowedFields = ['name','username','email','password','role','branch_id'];

    function getAll(){
        return $this->findAll();
    }

    function create($data){        
        return $this->insert($data);
    }

    function getUser($username){
        return $this->where('username',$username)->first();
    }

    function getUserById($id){
        return $this->where('id',$id)->first();
    }

    function deleteUsers($id){
        return $this->delete($id);
    }
    
    public function updateUser($id, $data) {
        return $this->update($id, $data);
    }


}
 