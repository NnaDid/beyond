<?php
//header('Content-type: application/json');
   require_once('../common.php');

   class Profile{

    use BeyondCommon;
    private $data = [];
    public function __construct(){
        // Getting the received JSON into $json variable.
        $jsonInput = file_get_contents('php://input');
        $this->update($jsonInput);
    }
       
    private function update($input){
        // `userId`, `fullName`, `email`, `phone`, `bvn`, `paswd`, `phone_status`, `email_status`, `createdAt`, `updateedAt`, `profilePix`
        $con    = $this->con();
        // decoding the received JSON and store into $obj variable.
        $obj    = json_decode($input,true); 
        $fname  = $obj['fName']; 
        $email  = $obj['email'];
        $phone  = $obj['phone'];     
        $bvn    = $obj['bvn'];  
    if($this->checkUserExist($email,"users","email")){	
        $userId    = $this->getMemberDetails($email)['userId'];
        $sql       = "UPDATE `users` SET `fullName`=?,`email`=?,`phone`=?,`bvn`=?,`updateedAt`=NOW() WHERE `userId`=?";
        $stmt      = $con->prepare($sql);
        $stmt->bind_param("ssssi",$fname,$email,$phone,$bvn,$userId);
        if($stmt->execute()){
            $this->data['message'] = 'success';
            $this->data['newData'] = [$fname,$email,$phone,$bvn,$userId];
        }else{
            $this->data['message'] = "Error Registering ".$stmt->error;
        }
        $stmt->close();
    }else{
        $this->data['message'] = 'Account does not exists for '.$email;
    }
     $con->close();    
     echo json_encode($this->data); 
  }

   }

new Profile();
?>