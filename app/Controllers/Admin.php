<?php

namespace App\Controllers;
use App\Models\AdminModel;
use App\Models\BranchModel;
use App\Models\ClassModel;
use App\Models\CurrencyModel;
use App\Models\InvoiceModel;
use App\Models\ItemsModel;
use App\Models\ReceiveModel;
use App\Models\SessionModel;
use App\Models\StudentModel;
use App\Models\TuitionModel;
use App\Models\UsersModel;
use GuzzleHttp\Psr7\MultipartStream;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Config\Services; // Import necessary services
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Controllers\Exception;


class Admin extends BaseController
{
    
    public function branch()
    {   
        $session = session();
        $data['session'] = $session;
        $model =  new BranchModel();
        $branch = $model->getAll();
        $data['branch'] = $branch;
        if($session->get('role') != '1'){
          return redirect()->to(base_url()."/admin/users");
        }
        return view('admin/branch',$data);
    }
    public function createBranch()
    {   
        $currency_model = new CurrencyModel();
        $data['currency'] = $currency_model->getAll();
        $session = session();
        $data['session'] = $session;
        return view('admin/createBranch',$data);
    }

    public function saveNewBranch(){
        $data = $this->request->getVar();

        $data_b['branch_name'] = $data["name"];
        $data_b['address'] = $data["address"];
        $data_b['email'] = $data["email"];
        $data_b['currency_id'] = $data["currency"];
        $data_b['bank_name'] = $data["bank_name"];
        $data_b['account_name'] = $data["account_name"];
        $data_b['account_number'] = $data["account_number"];
        $model =  new BranchModel();
        $newBranch = $model->create($data_b);
        $session = session();
        $data['session'] = $session;
        return redirect()->to(base_url()."/admin/branch");
    }

    public function deleteBranch($id){
        $model = new BranchModel();
        $model->deleteBranch($id);
        $session = session();
        $data['session'] = $session;
        return redirect()->to(base_url()."/admin/branch");
      }

      public function editBranch($id)
      {
          $db = db_connect();
          $branch_query = $db->query("SELECT * FROM branch 
                                      WHERE id = $id");
          $branch = $branch_query->getFirstRow();
          $currency_model = new CurrencyModel();
          $data['currency'] = $currency_model->getAll();
          $data['branch'] = $branch;
          $session = session();
        $data['session'] = $session;
          return view('/admin/editBranch',$data);
      }

      public function saveBranch(){
        $data = $this->request->getVar();
        $id = $data["branch_id"]; // Assuming branch_id is the primary key

        // Extracting relevant data from $data
        $branch_data = array(
            'branch_name' => $data["name"],
            'address' => $data["address"],
            'email' => $data["email"],
            'currency_id' => $data["currency"],
            'bank_name' => $data['bank_name'],
            'account_name' => $data['account_name'],
            'account_number' => $data['account_number']
        );
        $db = db_connect();
        $db->table('branch')->where('id', $id)->update($branch_data);
        $session = session();
        $data['session'] = $session;
        return redirect()->to(base_url()."/admin/branch");
    }

//Class

    public function class()
    {   
        $session = session();
        if($session->get('role') != '1'){
          $branch_id = $session->get('branch_id');
          $db = db_connect();
          $class_query = $db->query("SELECT class.id as class_id, class.*,currency.* FROM class 
          INNER JOIN currency ON currency.id = class.currency_id
          WHERE class.branch_id = $branch_id");
          $class = $class_query->getResult();
        }else{
          $db = db_connect();
          $class_query = $db->query("SELECT class.id as class_id, class.*,currency.* FROM class 
          INNER JOIN currency ON currency.id = class.currency_id");
          $class = $class_query->getResult();
        }
        // $model =  new ClassModel();
        // $class = $model->getAll();
        $data['class'] = $class;
        
        $data['session'] = $session;
        return view('admin/class',$data);
    }
    public function createClass()
    {
        $db = db_connect();
        $branch_query = $db->query('SELECT branch.id as branch_id, branch.*, currency.* FROM branch  
                                    INNER JOIN currency ON currency.id = branch.currency_id');
        $branch = $branch_query->getResult();
        $branch_model = new BranchModel();
        $currency_model = new CurrencyModel();
        $data['branch'] = $branch;
        $data['currency'] = $currency_model->getAll();
        $session = session();
        $data['session'] = $session;
        $email_smtp = \Config\Services::email();

        $email_smtp->setFrom("ramawari@acktechnologies.com", "Aedno No Reply");
        $email_smtp->setTo("ramaiswara098@gmail.com");

        $email_smtp->setSubject("Ini subjectnya");
        $email_smtp->setMessage("Ini isi/body email");


        $email_smtp->send();
                return view('admin/createClass', $data);
    }

    public function saveNewClass(){
        $data = $this->request->getVar();
        $data_b['class_name'] = $data["name"];
        $data_b['branch_id'] = $data["branch"];
        $data_b['price'] = $data["price"];
        $data_b['currency_id'] = $data["currency_id"];
         $model =  new ClassModel();
        $newClass = $model->create($data_b);
        $session = session();
        $data['session'] = $session;
         return redirect()->to(base_url()."/admin/class");
    }

    public function deleteClass($id){
        $model = new ClassModel();
        $model->deleteClass($id);
        $session = session();
        $data['session'] = $session;
        return redirect()->to(base_url()."/admin/class");
      }


      public function editClass($id)
      {
        $db = db_connect();
        $branch_query = $db->query('SELECT branch.id as branch_id, branch.*, currency.* FROM branch  
                                    INNER JOIN currency ON currency.id = branch.currency_id');
        $branch = $branch_query->getResult();
        $class_query = $db->query("SELECT * FROM class WHERE id = $id");
        $class = $class_query->getFirstRow();
        $branch_model = new BranchModel();
        $currency_model = new CurrencyModel();
        $data['branch'] = $branch;
        $data['class'] = $class;
        $data['currency'] = $currency_model->getAll();
        $session = session();
        $data['session'] = $session;
          return view('/admin/editClass',$data);
      }

      public function saveClass(){
        $data = $this->request->getVar();
        $id = $data["class_id"]; // Assuming branch_id is the primary key
        $class_data = array(
            'class_name' => $data["name"],
            'branch_id' => $data["branch"],
            'price' => $data["price"],
            'currency_id' => $data["currency_id"]
        );
        $db = db_connect();
        $db->table('class')->where('id', $id)->update($class_data);
        $session = session();
        $data['session'] = $session;
        return redirect()->to(base_url()."/admin/class");
    }

    //Tuition
    public function tuition()
    {   
        $model =  new TuitionModel();
        $tuition = $model->getAll();
        $data['tuition'] = $tuition;
        $session = session();
        $data['session'] = $session;
        return view('admin/tuition', $data);
    }
    public function createTuition()
    {   
        $session = session();
        $data['session'] = $session;
        return view('admin/createTuition');
    }

    public function saveNewTuition(){
        $data = $this->request->getVar();
        $data_b['tuition_type'] = $data["tuition_type"];
        $model =  new TuitionModel();
        $newBranch = $model->create($data_b);
        return redirect()->to(base_url()."/admin/tuition");
    }

    //Student
    public function student()
    {   
      $session = session();
        if($session->get('role') != '1'){
          $branch_id = $session->get('branch_id');
          $db = db_connect();
          $student_query = $db->query("SELECT student.id as student_id, student.*, branch.branch_name, branch.id FROM student
          INNER JOIN branch ON branch.id = student.branch_id 
          WHERE student.branch_id = $branch_id");
          $student = $student_query->getResult();
        }else{
          $db = db_connect();
          $student_query = $db->query("SELECT student.id as student_id, student.*,branch.branch_name, branch.id FROM student
          INNER JOIN branch ON branch.id = student.branch_id ");
          $student = $student_query->getResult();
        }
        // $model =  new StudentModel();
        // $student = $model->getAll();
        $data['student'] = $student;
        $data['session'] = $session;
        return view('admin/student', $data);
    }
    public function createStudent()
    {   
        $branch_model = new BranchModel();
        $class_model = new ClassModel();
        $tuition_model = new TuitionModel();
        $data['branch'] = $branch_model->getAll();
        $data['class'] = $class_model->getAll();
        $data['tuition'] = $tuition_model->getAll();
        $session = session();
        $data['session'] = $session;
        return view('admin/createStudent',$data);
    }

    public function importStudent(){
      $session = session();
      $data['session'] = $session;
      return view('admin/importStudent',$data);
    }

    public function saveNewStudent(){
        $data = $this->request->getVar();
        
        $data_b['name'] = $data["name"];
        $data_b['email'] = $data["email"];
        $data_b['address'] = $data["address"];
        $data_b['school'] = $data["school"];
        $data_b['grade'] = $data["grade"];
        $data_b['parent_name'] = $data["parent_name"];
        $data_b['parent_email'] = $data["parent_email"];
        $data_b['branch_id'] = $data["branch"];
        $data_b['student_no'] = $data["student_no"];
        // var_dump($data_b);
        $model =  new StudentModel();
        $newBranch = $model->create($data_b);
        $session = session();
        $data['session'] = $session;
        return redirect()->to(base_url()."/admin/student")->with("success","Successfully Create student");
    }
    public function editStudent($id)
    {   
        $db = $db = db_connect();
        $studentQuery = $db->query("SELECT * FROM student WHERE id = $id");
        $student = $studentQuery->getFirstRow();
        $branch_model = new BranchModel();
        $class_model = new ClassModel();
        $tuition_model = new TuitionModel();
        $data['branch'] = $branch_model->getAll();
        $data['class'] = $class_model->getAll();
        $data['tuition'] = $tuition_model->getAll();
        $data['student'] = $student;
        $session = session();
        $data['session'] = $session;
        return view('admin/editStudent',$data);
    }

    public function deleteStudent($id){
        $model = new StudentModel();
        $model->deleteStudent($id);
        return redirect()->to(base_url()."/admin/student")->with("success","Successfully Delete student");
      }

      public function saveStudent(){
        $data = $this->request->getVar();
        
        $data_b['name'] = $data["name"];
        $data_b['email'] = $data["email"];
        $data_b['address'] = $data["address"];
        $data_b['school'] = $data["school"];
        $data_b['grade'] = $data["grade"];
        $data_b['parent_name'] = $data["parent_name"];
        $data_b['parent_email'] = $data["parent_email"];
        $data_b['branch_id'] = $data["branch"];
        $data_b['student_no'] = $data["student_no"];
        
        $id = $data["student_id"]; // Assuming branch_id is the primary key
        $student_data = array(
            'name' => $data["name"],
            'email' => $data["email"],
            'address' => $data["address"],
            'school' => $data["school"],
            'grade' => $data["grade"],
            'parent_name' => $data["parent_name"],
            'parent_email' => $data["parent_email"],
            'branch_id' => $data["branch"],
            'student_no' => $data["student_no"]
            
        );
        $db = db_connect();
        $db->table('student')->where('id', $id)->update($student_data);
        return redirect()->to(base_url()."/admin/student")->with("success","Successfully Update student");
    }

    //Currency
     public function currency()
     {   
         $model =  new CurrencyModel();
         $currency = $model->getAll();
         $data['currency'] = $currency;
         $session = session();
        $data['session'] = $session;
         return view('admin/currency', $data);
     }
     public function createCurrency()
     {   
        $session = session();
        $data['session'] = $session;
         return view('admin/createCurrency',$data);
     }
 
     public function saveNewCurrency(){
         $data = $this->request->getVar();
         $data_b['name'] = $data["name"];
         $data_b['code'] = $data["code"];
         $model =  new CurrencyModel();
         $newCurrency = $model->create($data_b);
         return redirect()->to(base_url()."/admin/currency");
     }

     public function deleteCurrency($id){
        $model = new CurrencyModel();
        $model->deleteCurrency($id);
        return redirect()->to(base_url()."/admin/currency");
      }

      //Payment
      public function payment()
      {   
        $db = db_connect();
        $items_query = $db->query('SELECT * FROM items 
                                    INNER JOIN class ON class.id = items.class_id 
                                    INNER JOIN currency ON currency.id = class.currency_id 
                                    INNER JOIN invoice ON invoice.id = items.invoice_id
                                    INNER JOIN student ON student.id = invoice.student_id');
                $items = $items_query->getResult();
                //student
               
                usort($items, function($a, $b) {
                    return $a->invoice_id - $b->invoice_id;
                });
                // var_dump($items);
          $data['items'] = $items;
          $session = session();
        $data['session'] = $session;
          return view('admin/payment',$data);
      }
      public function createPayment()
      { 
        $session = session();
        if($session->get('role') != '1'){
          $branch_id = $session->get('branch_id');
          $db = db_connect();
          $student_query = $db->query("SELECT student.*, currency.code FROM student INNER JOIN branch ON branch.id = student.branch_id INNER JOIN currency ON currency.id = branch.currency_id WHERE student.branch_id = $branch_id");
          $student = $student_query->getResult();
        }else{
          $db = db_connect();
          $student_query = $db->query("SELECT student.*, currency.code FROM student INNER JOIN branch ON branch.id = student.branch_id INNER JOIN currency ON currency.id = branch.currency_id");
          $student = $student_query->getResult();
        }
        // $model =  new StudentModel();
        $modelClass =  new ClassModel();
        // $student = $model->getAll();
        $class = $modelClass->getAll();
        $db = db_connect();
        $class_query = $db->query('SELECT class.id as class_id,class.*,currency.* FROM class
        INNER JOIN currency ON currency.id = class.currency_id');

        $class = $class_query->getResult();
        $data['student'] = $student;
        $data['class'] = $class;
        $session = session();
        $data['session'] = $session;
        $s_id = NULL;
        if($this->request->getGet('student-id')!= NULL){
          $s_id = $this->request->getGet('student-id');
        }
        $data['s_id'] = $s_id;
          return view('admin/createPayment', $data);
      }

      public function deletePayment($id){
        $model = new InvoiceModel();
        $model->deleteInvoice($id);
        return redirect()->to(base_url()."/admin/payment");
      }
  
      public function saveNewPayment(){
          $data = $this->request->getVar();
          
          $data_b['student_id'] = $data["student_id"];
          $data_b['status'] = $data["status"];
          $data_b['date'] = date("d/m/Y");
          $model =  new InvoiceModel();
          $model_items =  new ItemsModel();
          $newInvoice = $model->create($data_b);
          $data_i['invoice_id'] = $newInvoice;
          $total_item = $data["class_sum"];
          for ($i=0;$i<$total_item;$i++){
            $data_i['class_id'] = $data["class".$i+1];
            $data_i['qty'] = $data["qty".$i+1];
            $data_i['discount'] = $data["discount".$i+1];
            $model_items->create($data_i);
          }
          if($data_b['status'] == "Paid"){
            $data_c['receive_no'] = $data['r_no'];
            $data_c['receive_date'] = $data['r_date'];
            $data_c['amount'] = $data['r_amount'];
            $data_c['method'] = $data['r_by'];
            $data_c['invoice_id'] = $newInvoice;
            $modelReceive = new ReceiveModel();
            $modelReceive->create($data_c);
          }
          
          return redirect()->to(base_url()."/admin/invoice/".$newInvoice);
      }

      public function editPayment($id)
      {   
        $model =  new StudentModel();
        $modelClass =  new ClassModel();
        $student = $model->getAll();
        $class = $modelClass->getAll();
        $db = db_connect();
        $class_query = $db->query('SELECT class.id as class_id, class.*,currency.* FROM class
        INNER JOIN currency ON currency.id = class.currency_id');

        $class = $class_query->getResult();

        $payment_query = $db->query("SELECT invoice.id as invoice_id, invoice.*, student.id AS student_id, student.branch_id as branch_id 
                             FROM invoice 
                             INNER JOIN student ON student.id = invoice.student_id 
                             WHERE invoice.id = $id");
        $payment = $payment_query->getFirstRow();
        $branch_query = $db->query("SELECT * FROM branch INNER JOIN currency ON currency.id = branch.currency_id WHERE branch.id = $payment->branch_id ");
        $branch = $branch_query->getFirstRow();
        $items_query = $db->query("SELECT items.id as items_id, items.*, class.id as class_id, class.*
        FROM items 
        INNER JOIN class ON class.id = items.class_id
        WHERE items.invoice_id = $id");
        $items = $items_query->getResult();
        $receive_query = $db->query("SELECT * FROM receive WHERE receive.invoice_id = $payment->invoice_id");
        $receive = $receive_query->getFirstRow();
        $data['student'] = $student;
        $data['class'] = $class;
        $data['payment'] = $payment;
        $data['items'] = $items;
        $data['branch'] = $branch;
        $data['receive'] = $receive;
        $session = session();
        $data['session'] = $session;
          return view('admin/editPayment', $data);
      }

      public function savePayment(){
        $data = $this->request->getVar();
        $status = $data['status'];
        $invoice_id= $data['invoice_id'];
        $db = db_connect();
          if($status == "Paid"){
            $receive['receive_no'] = $data['r_no'];
            $receive['receive_date'] = $data['r_date'];
            $receive['amount'] = $data['r_amount'];
            $receive['method'] = $data['r_by'];
            $receive['id'] = $data['receive_id'];
            $db->query("UPDATE invoice SET status = '$status' WHERE invoice.id = $invoice_id");
            if ($receive['id'] == 0) {
              // If $receive['id'] is 0, create a new row
              $db->query("INSERT INTO receive (receive_no, receive_date, amount, method, invoice_id) VALUES (
                      '{$receive['receive_no']}',
                      '{$receive['receive_date']}',
                      '{$receive['amount']}',
                      '{$receive['method']}',
                      $invoice_id
                      )");
          } else {
              // If $receive['id'] is not 0, update the existing row
              $db->query("UPDATE receive SET 
                      receive_no = '{$receive['receive_no']}',
                      receive_date = '{$receive['receive_date']}',
                      amount = '{$receive['amount']}',
                      method = '{$receive['method']}'
                      WHERE id = {$receive['id']}");
          }
            
            
          }else{
            $receive_id = $data['receive_id'];
            $db->query("UPDATE invoice SET status = '$status' WHERE invoice.id = $invoice_id");
            if($receive_id != 0){
              $db->query("DELETE FROM receive where id = $receive_id");
            }
            echo "Success";
          }

          
          
          // return redirect()->to(base_url()."/admin/invoice/".$newInvoice);
      }

      //Users
      public function users()
      {   
        $session = session();
        $data['session'] = $session;  
        if($session->get('role') !='1'){
            $branch_id = $session->get('branch_id');
            $db = db_connect();
            $user_query = $db->query("SELECT users.id as user_id,users.*,users.email as user_email, branch.id as branch_ids, branch.* FROM users 
            INNER JOIN branch ON branch.id = users.branch_id
            WHERE users.branch_id = $branch_id");
            $users = $user_query->getResult();
        }else{
            $db = db_connect();
            $user_query = $db->query("SELECT users.id as user_id,users.email as user_email, users.*, branch.id as branch_id, branch.* FROM users 
            LEFT JOIN branch ON branch.id = users.branch_id");
            $users = $user_query->getResult();
        }
        
          $data['users'] = $users;
          
          return view('admin/users', $data);
      }
      public function createUsers()
      {
        $branch_model = new BranchModel();
        $data['branch'] = $branch_model->getAll();
        $session = session();
        $data['session'] = $session;
        return view('admin/createUsers', $data);
      }
  
      public function saveNewUsers(){
          $data = $this->request->getVar();
          $password = $data["password"];
          $password = password_hash($password, PASSWORD_DEFAULT);
          $data_b['name'] = $data["name"];
          $data_b['username'] = $data["username"];
          $data_b['email'] = $data["email"];
          $data_b['password'] = $password;
          $data_b['role'] = $data["role"];
          if (isset($data["branch"])) {
            $data_b['branch_id'] = $data["branch"];
          }
          $model =  new UsersModel();
          $newUsers = $model->create($data_b);
          return redirect()->to(base_url()."/admin/users");
      }

      public function deleteUsers(){
            $data = $this->request->getVar();
            $id = $data['id'];
            $model =  new UsersModel();
            $deleteUsers = $model->deleteUsers($id);
            return redirect()->to(base_url()."/admin/users");
      }

      public function editUsers($id){
        $model = new UsersModel();
        $user = $model->getUserById($id);
        $branch_model = new BranchModel();
        $data['branch'] = $branch_model->getAll();
        $data["user"] = $user;
        $session = session();
        $data['session'] = $session;
        return view('admin/editUsers',$data);
      }

      public function saveUsers(){
        $data = $this->request->getVar();
        $id = $data["id"];
        $data_b['name'] = $data["name"];
        $data_b['username'] = $data["username"];
        $data_b['email'] = $data["email"];
        $data_b['role'] = $data["role"];
        if (isset($data["branch"])) {
          $data_b['branch_id'] = $data["branch"];
        }
        $model =  new UsersModel();
        $updatedUsers = $model->updateUser($id,$data_b);
        return redirect()->to(base_url()."/admin/users");
    }

    public function invoice($id){
        $invoice_model = new InvoiceModel();
        $invoice = $invoice_model->getInvoiceById($id);
        $data['invoice'] = $invoice;
        $db = db_connect();
$items_query = $db->query('SELECT * FROM items 
                            INNER JOIN class ON class.id = items.class_id 
                            INNER JOIN currency ON currency.id = class.currency_id
                            INNER JOIN branch ON branch.id = class.branch_id 
                            WHERE items.invoice_id = ' . $id);
        $items = $items_query->getResult();
        // var_dump($items);
        $receive_query = $db->query('SELECT * FROM receive 
                            WHERE receive.invoice_id = ' . $id);
        $receive = $receive_query->getResult();
        //student
        $student_id = $invoice['student_id'];
        $student_model = new StudentModel();
        $student = $student_model->getStudentById($student_id);
        $data['student'] = $student;
        $data['items'] = $items;
        $data['receive'] = $receive;
        $session = session();
        $data['session'] = $session;
        //items
        return view('admin/invoice', $data);
    }

    public function dashboard(){
      $session = session();
      $data['session'] = $session;
      if($session->get('role') != '1'){
        $branch_id = $session->get('branch_id');
        $db = db_connect();
        $paid_query = $db->query("SELECT * FROM invoice INNER JOIN student ON student.id = invoice.student_id where status = 'Paid' AND student.branch_id = $branch_id"); 
        $unpaid_query = $db->query("SELECT * FROM invoice INNER JOIN student ON student.id = invoice.student_id where status = 'Unpaid' AND student.branch_id = $branch_id"); 
        $paid = $paid_query->getResultArray();
        $unpaid = $unpaid_query->getResultArray();
        $last_invoice_query = $db->query("SELECT invoice.id as invoice_id, invoice.*, student.* FROM invoice INNER JOIN student ON student.id = invoice.student_id WHERE student.branch_id = $branch_id ORDER BY date DESC LIMIT 5");
        $last_invoice = $last_invoice_query->getResult();
        $top_class_query = $db->query("SELECT class_id, COUNT(*) AS class_count, class.class_name
        FROM items
        INNER JOIN class ON class.id = items.class_id
        WHERE class.branch_id = $branch_id
        GROUP BY class_id
        ORDER BY class_count DESC
        LIMIT 5");
        $top_class = $top_class_query->getResult();
        $last_login_query = $db->query("SELECT * FROM users WHERE users.branch_id = $branch_id ORDER BY last_login DESC LIMIT 5");
        $last_login = $last_login_query->getResult();
        $query_items = $db->query("
    SELECT 
        items.id AS items_id, 
        items.*, 
        invoice.*, 
        student.*, 
        class.id AS class_id,
        class.*, 
        branch.*, 
        COALESCE(att.attendance_total, 0) AS attendance_total
    FROM 
        items
    INNER JOIN 
        invoice ON items.invoice_id = invoice.id
    INNER JOIN 
        class ON items.class_id = class.id
    INNER JOIN 
        branch ON branch.id = class.branch_id
    INNER JOIN 
        student ON student.id = invoice.student_id
    LEFT JOIN (
        SELECT 
            items_id, 
            COUNT(*) AS attendance_total
        FROM 
            attendance
        GROUP BY 
            items_id
    ) AS att ON items.id = att.items_id
    WHERE 
        items.qty - COALESCE(att.attendance_total, 0) = 1 AND branch.id = $branch_id
");
      $items = $query_items->getResult();
       $data['items'] = $items;

      }else{
        $branch_id='0';
        $andTopClass = "";
        $andPaid = "";
        $andLastInvoice="";
        $andLastLogin="";
        $andAttendance = "";
        if($this->request->getGet('branch') != '0' && $this->request->getGet('branch') != NULL){
            $branch_id = $this->request->getGet('branch');
            $where = "WHERE branch.id = ".$branch_id;
            $andPaid = "AND student.branch_id = ".$branch_id;
            $andLastInvoice  = " WHERE student.branch_id = ".$branch_id;
            $andTopClass  = " WHERE class.branch_id = ".$branch_id;
            $andLastLogin = " WHERE users.branch_id = ".$branch_id;
            $andAttendance = " AND branch.id = ".$branch_id;
          }
        $db = db_connect();
        $paid_query = $db->query("SELECT invoice.* FROM invoice INNER JOIN student ON invoice.student_id = student.id where status = 'Paid' $andPaid"); 
        $unpaid_query = $db->query("SELECT invoice.* FROM invoice INNER JOIN student ON invoice.student_id = student.id where status = 'Unpaid' $andPaid"); 
        $paid = $paid_query->getResultArray();
        $unpaid = $unpaid_query->getResultArray();
        $last_invoice_query = $db->query("SELECT invoice.id as invoice_id, invoice.*, student.* FROM invoice INNER JOIN student ON student.id = invoice.student_id".$andLastInvoice. " ORDER BY date DESC LIMIT 5");
        $last_invoice = $last_invoice_query->getResult();
        $top_class_query = $db->query("SELECT class_id, COUNT(*) AS class_count, class.class_name
        FROM items
        INNER JOIN class ON class.id = items.class_id".$andTopClass.
        " GROUP BY class_id
        ORDER BY class_count DESC
        LIMIT 5");
        $top_class = $top_class_query->getResult();
        $last_login_query = $db->query("SELECT * FROM users".$andLastLogin." ORDER BY last_login DESC LIMIT 5");
        $last_login = $last_login_query->getResult();
        
        $query_items = $db->query("
    SELECT 
        items.id AS items_id, 
        items.*, 
        invoice.*, 
        student.*, 
        class.id AS class_id,
        class.*, 
        branch.*, 
        COALESCE(att.attendance_total, 0) AS attendance_total
    FROM 
        items
    INNER JOIN 
        invoice ON items.invoice_id = invoice.id
    INNER JOIN 
        class ON items.class_id = class.id
    INNER JOIN 
        branch ON branch.id = class.branch_id
    INNER JOIN 
        student ON student.id = invoice.student_id
    LEFT JOIN (
        SELECT 
            items_id, 
            COUNT(*) AS attendance_total
        FROM 
            attendance
        GROUP BY 
            items_id
    ) AS att ON items.id = att.items_id
    WHERE 
        items.qty - COALESCE(att.attendance_total, 0) = 1".$andAttendance);

      $items = $query_items->getResult();
       $data['items'] = $items;
      }

      $data['paid'] = $paid;
      $data['unpaid'] = $unpaid;
      $data['last_invoice'] = $last_invoice;
      $data['top_class'] = $top_class;
      $data['last_login'] = $last_login;
      $branch_model = new BranchModel();
      $data['branch'] = $branch_model->getAll();
      $data['pass_branch'] = $this->request->getGet('branch');
      return view('admin/dashboard',$data);
    }

    public function sendMail()
  {
    helper(['filesystem', 'move_uploaded_file']);

    $img = $this->request->getFile('makan');
    $data = $this->request->getVar();
    $id = $data['id'];
	$email = $data['email'];
	$student_name = $data['student_name'];
	$name = $data['name'];
    //var_dump($img->store());
    //dd($img);

        if (! $img->hasMoved()) {
            $filepath = WRITEPATH . 'uploads/'.$img->store('pdf/',$data['id'].".pdf");

            $data = ['uploaded_fileinfo' => new File($filepath)];
			$email_smtp = \Config\Services::email();

			$email_smtp->setFrom("aednonoreply@acktechnologies.com", "Aedo - No Reply");
			$email_smtp->setTo($email);

			$email_smtp->setSubject("Invoice Aedno $id - $student_name");
			$email_smtp->setMessage("Dear $name, \nThe attached file is Aedno invoice for $student_name with invoice number: $id");
			//$email_smtp->setMessage("Dear HELLO");
			//$email_smtp->attach('https://aedno.acktechnologies.com/aedno/public/aedno.png', 'application/pdf');
			//$email_smtp->attach(WRITEPATH.'uploads/pdf/2464.pdf', 'application/pdf');
			$email_smtp->attach($filepath, 'application/pdf');
			if ($email_smtp->send()) {
				return json_encode(['success' => "Success"]);
			} else {
				// Handle email sending error (e.g., return error message)
				// return json_encode(['error' => 'Error sending email: ' . $email_smtp->getLastError()]);
			}

            // return view('upload_success', $data);
            //echo($filepath);
        }

        $data = ['errors' => 'The file has already been moved.'];
    echo json_encode(['success' => 'Invoice uploaded successfully!']);
  }
    

public function attendance($id){
  $session = session();
  $data['session'] = $session;
  $db = db_connect();
  $query_items = $db->query("
  SELECT 
      items.id AS items_id, 
      items.*, 
      invoice.*, 
      student.*, 
      COALESCE(att.attendance_total, 0) AS attendance_total
  FROM 
      items
  INNER JOIN 
      invoice ON items.invoice_id = invoice.id
  INNER JOIN 
      student ON student.id = invoice.student_id
  LEFT JOIN (
      SELECT 
          items_id, 
          COUNT(*) AS attendance_total
      FROM 
          attendance
      GROUP BY 
          items_id
  ) AS att ON items.id = att.items_id
  WHERE 
      class_id = $id
");
$items = $query_items->getResult();
  $data['items'] = $items;
  $data['class_id'] = $id;
  return view('/admin/attendance',$data);
}

public function addAttendance(){
  $data = $this->request->getVar();
  $items_id = $data['items_id'];
  $items_date = $data['items_date'];
  $id = $data['class_id'];
  $user_id = $data['user_id'];
  $db = db_connect();
  $db->query("INSERT INTO attendance (items_id, items_date,user_id) VALUES ($items_id, '$items_date', '$user_id')");
  return redirect()->to(base_url()."/admin/attendance/".$id);
}

public function addAttendanceAPI(){
  $data = $this->request->getVar();
  $items_id = $data->items_id;
  $items_date = $data->items_date;
  $user_id = $data->user_id;
 
  $db = db_connect();
  $db->query("INSERT INTO attendance (items_id, items_date,user_id) VALUES ($items_id, '$items_date', '$user_id')");
  return json_encode("success");
  // return redirect()->to(base_url()."/admin/attendance/".$id);
}

public function getAttendance($id){
  $db = db_connect();
  $att_query = $db->query("SELECT attendance.*, users.name AS user_name FROM attendance INNER JOIN users ON users.id = attendance.user_id WHERE attendance.items_id = '$id' ORDER BY items_date DESC");
  $attendance = $att_query->getResult();
  return json_encode(['success' => true,'attendance' => $attendance]);
}


public function getImported(){
  $file = $this->request->getFile('student');
  $extension =  $file->getClientExtension();
  if( $extension == 'xlsx' || $extension == 'xls'){
    if($extension == 'xls'){
      $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
    }else{
      $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    }

    $spreadsheet = $reader->load($file);
    $student = $spreadsheet->getActiveSheet()->toArray();
    $branch_model = new BranchModel();
    $branch = $branch_model->getAll();
    $branches = [];
    $imported_student = 0;
    foreach($branch as $br){
      $branch_name = strtolower($br['branch_name']);
      $branch_name = str_replace(" ","",$branch_name);
      $branches[$branch_name] = $br['id'];
       
      
    }
    foreach($student as $key => $st){
      if($key == 0){
        continue;
      }else{
        $bra_name = $st[8];
        $bra_name = strtolower($bra_name);
        $bra_name = str_replace(" ","",$bra_name);
        $data_b['name'] = $st[1];
        $data_b['email'] = $st[2];
        $data_b['address'] = $st[3];
        $data_b['school'] = $st[4];
        $data_b['grade'] = str_replace(":",".",$st[5]);
        $data_b['parent_name'] = $st[6];
        $data_b['parent_email'] = $st[7];
        $data_b['branch_id'] =  $branches[$bra_name];
        $data_b['student_no'] = $st[1];
        $model =  new StudentModel();
        $newBranch = $model->create($data_b);
        if($newBranch){
          $imported_student++;
        }
      }
    }
    return redirect()->to(base_url('admin/student'))->with('success', 'Succesfully imported '.$imported_student.' students');
  }else{
    echo "Format file not acceptable";
  }
  
}

  public function listOfClass($id){
    $session = session();
    $data['session'] = $session;
    $db = db_connect();
    $query_items = $db->query("
    SELECT 
        items.id AS items_id, 
        items.qty as require_attendance,
        invoice.id as invoice_no, 
        class.id as class_id,
        class.class_name as class_name,
        student.id as student_id,
        student.name as student_name,
        COALESCE(att.attendance_total, 0) AS attendance_total
    FROM 
        items
    INNER JOIN 
        invoice ON items.invoice_id = invoice.id
    INNER JOIN 
        student ON student.id = invoice.student_id
    INNER JOIN 
        class ON class.id = items.class_id
    LEFT JOIN (
        SELECT 
            items_id, 
            COUNT(*) AS attendance_total
        FROM 
            attendance
        GROUP BY 
            items_id
    ) AS att ON items.id = att.items_id
    WHERE 
        invoice.student_id = $id
        ORDER BY invoice.date DESC
  ");
  $items = $query_items->getResult();
  return json_encode(['success' => true,'attendance' => $items]);
  }

}
