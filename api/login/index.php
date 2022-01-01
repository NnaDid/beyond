<?php
   require_once('../common.php');

   class Login{

    use BeyondCommon;
    private $data = [];

    public function __construct(){
        // Getting the received JSON into $json variable.
        $jsonInput = file_get_contents('php://input');
        $this->login($jsonInput);
    }
    
           
    private function login($input){ 
        $con    = $this->con();
        $obj    = json_decode($input,true);  
        $email  = $obj['email'];   // User can login with either Phone|Email|BVN
        $pass   = $obj['paswd'];  
        if($this->checkUserExist($email,"users","email") || $this->checkUserExist($email,"users","bvn") || $this->checkUserExist($email,"users","phone")){	
            $sql  		= "SELECT * FROM `users` WHERE `email`= ? OR `bvn` = ? OR `phone`=?";
            $stmt 		= $con->prepare($sql);
            $stmt->bind_param("sss",$email,$email,$email);  
           if($stmt->execute()){
                $result	   = $stmt->get_result();
                $row       = $result->fetch_assoc();
                if(password_verify($pass,$row['paswd'])){
                    $this->data['message'] = 'success';
					$this->data['data']    = [
                                              "email"=>$row['email'],
                                              "phone"=>$row['phone'],
                                              "bvn"=>$row['bvn'],
                                              "name"=>$row['fullName']
                                            ];
                }else{
                    $this->data['message'] ="Incorrect Password";
               }
                
           }else{
              $this->data['message'] = "LOGIN FAILED  ".$stmt->error;
           }
           
        }else{
            $this->data['message'] = "User does not exist";
        }
        $con->close();  
        echo json_encode($this->data); 
     }
   


  
  
  
  
  
  
  
    }

new Login();
?>