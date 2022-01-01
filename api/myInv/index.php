<?php 
   require_once('../common.php');

   class MyInvest{

    use BeyondCommon;
    private $data = [];
    public function __construct(){
        // Getting the received JSON into $json variable.
        $jsonInput = file_get_contents('php://input');
        $this->myInvestments($jsonInput);
    }
       
    private function myInvestments($input){
        // `invId`, `userId`, `amount`, `tx_token`, `pmtChannel`, `issuerResponse`, `createdAt`
        $con    = $this->con();
        // decoding the received JSON and store into $obj variable.
        $obj      = json_decode($input,true); 
        $email    = $obj['email'];  
    if($this->checkUserExist($email,"users","email")){	
        $userId    = $this->getMemberDetails($email)['userId'];
        $sql       = "SELECT * FROM `investments` WHERE `userId`='$userId'";
        $query     = $con->query($sql); 
        if($query){
            $row = $query->fetch_all(MYSQLI_ASSOC);
            $this->data['message']  = 'success';
            $this->data['inv_data'] = $row;
        }else{
            $this->data['message'] = "Error Registering ".$stmt->error;
        } 
    }else{
        $this->data['message'] = 'Unverified Account.';
    }
     $con->close();    
     echo json_encode($this->data); 
  }

   }

new MyInvest();
?>