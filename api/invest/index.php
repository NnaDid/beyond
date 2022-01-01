<?php 
   require_once('../common.php');

   class Invest{

    use BeyondCommon;
    private $data = [];
    public function __construct(){
        // Getting the received JSON into $json variable.
        $jsonInput = file_get_contents('php://input');
        $this->invest($jsonInput);
    }
       
    private function invest($input){
        //`invId`,`userId`,`amount`,`tx_token`,`pmtChannel`,`issuerResponse`,`createdAt`
        $con    = $this->con();
        // decoding the received JSON and store into $obj variable.
        $obj     = json_decode($input,true); 
        $amount  = $obj['amount']; 
        $email   = $obj['email'];   
        $txId    = $obj['txId'];
        $txToken = $obj['txRef'];

        if($amount<500000){
            if($this->checkUserExist($email,"users","email")){	
                $userId           = $this->getMemberDetails($email)['userId'];

                $confirm_pmt_object = $this->verifyPMT($txToken);
                // This way we affirm the user has actually made payment
                if ($confirm_pmt_object['status']==='success' && $confirm_pmt_object['amount']>=$amount){                                 
                    $sql       = "INSERT INTO `investments`(`userId`,`amount`,`tx_token`,`pmtChannel`,`issuerResponse`,`createdAt`) VALUES(?,?,?,?,?,NOW())";
                    $stmt      = $con->prepare($sql);
                    $stmt->bind_param("iisss",$userId,$amount,$txToken,$pmtChannel,$issuerResponse);
                    if($stmt->execute()){
                        $this->data['message'] = 'success';
                        $this->updateMyBalance($userId,$amount);
                    }else{
                        $this->data['message'] = "Error Registering ".$stmt->error;
                    }
                    $stmt->close();

                }

            }                 
    }
     $con->close();    
     echo json_encode($this->data); 
  }


  private function updateMyBalance($userId,$amount){
     // `accId`, `userId`, `myBalance`, `mySavings`, `myInterests`, `createdAt`, `updatedAt`
     $con    = $this->con();
     $sql    = $con->query("SELECT * FROM `account` WHERE `userId`='$userId'");
     if($sql->num_rows >0){
        $con->query("UPDATE `account` SET `mySavings` =`mySavings`+$amount,`updatedAt`=NOW() WHERE `userId`='$userId'");
        $con->query("UPDATE `account` SET `myBalance` =`mySavings`+`myInterests`,`updatedAt`=NOW() WHERE `userId`='$userId'");
     }else{
       $con->query("INSERT INTO `account`(`userId`,`myBalance`,`mySavings`,`createdAt`) 
                    VALUES('$userId','$amount','$amount',NOW())");
     }


  }



  private function verifyPMT($ref){
    $curl = curl_init();
  
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.paystack.co/transaction/verify/:{$ref}",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer sk_test_3c5a4b6ef47a9a7a0cda042092adf7dee8ceb949",
        "Cache-Control: no-cache",
      ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    
    if ($err) {
        $this->data['message']  = "cURL Error #:" . $err;
    } else {
      $res = json_decode($response,true);
      if($res['status']==true){
        return $res['data'];
      }
    }

}



}

new Invest();
?>