<?php

trait BeyondCommon{
     
    public $server = "localhost";
    public $user   = "root";
    public $pass   = "";
    public $db     = "beyond";

public function con(){
    $con = new Mysqli($this->server,$this->user,$this->pass,$this->db);
    return $con;
}

// Return User Details as Associative array
public function getMemberDetails($email){
    $con        = $this->con();
    $queryRow   = $con->query("SELECT * FROM `users` WHERE `email` ='$email'")->fetch_assoc();
    return  $queryRow;
}

// Get User/member details by ID
public function getUserById($uid){
    $con        = $this->con();
    $queryRow   = $con->query("SELECT * FROM `users` WHERE `userId` ='$uid'")->fetch_assoc();
    return  $queryRow;
}

    // Get User/member details by UserName
public function getMemberByUserName($uName){
    $con        = $this->con();
    $queryRow   = $con->query("SELECT * FROM `users` WHERE `userName` ='$uName'")->fetch_assoc();
    return  $queryRow;
}

    // Return Admin  Details as Associative array
public function getAdmin($email){
    $con        = $this->con();
    $queryRow   = $con->query("SELECT * FROM `admins` WHERE `email` ='$email'")->fetch_assoc();
    return  $queryRow;
}
    

public function checkUserExist($val,$table,$col){
    $con     = $this->con();
    if(!empty($val)){
    $sql       = "SELECT * FROM `".$table."` WHERE `".$col."`=?";
    $stmt      = $con->prepare($sql);
    $stmt->bind_param("s",$val);
    $exec      = $stmt->execute();
    if($exec){
    $result   = $stmt->get_result();
    $num_rows = $result->num_rows;
    if($num_rows>0){
        return true;
    }else{
        return false;
    }
    $stmt->close();
    }
    }
}

public function showAdmins(){ 
    $con     =  $this->con();
    $cols    =  "`name`,`phone`,`email`,`desgination`,`blevel`,`createdAt`";
    $query   =  $con->query("SELECT * FROM `admins`");
    $output = "";
    if($query){
        $counter =0;
        while($row = $query->fetch_assoc()){
            $output.='<tr class="text-align-center">
                    <td># '.(++$counter).'</td>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['desgination'].'</td>
                    <td>'.$row['phone'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['blevel'].'</td>
                    <td>'.date("d-m-Y",strtotime($row['createdAt'])).'</td>
                    <td>
                    <button class ="btn btn-outline-primary btn-xs admin_edit" id="'.$row['bAID'].'" data-toggle="modal" data-target="#editAdminModal"><i class="fa fa-pencil"></i></button>
                    <button class ="btn btn-outline-danger btn-xs admin_delete" id="'.$row['bAID'].'"><i class="fa fa-trash"></i></button>
                    </td>
        </tr> ';
        }
     
    }else{
        $output.='<tr class="text-align-center"> <td colspan ="7"> No Record Found! </td></tr>';
    }
   echo $output;   
}

public function showUsers(){ 
    $con     =  $this->con();
    $cols    =  "`fullName`,`email`,`phone`,`phone_status`,`email_status`,`createdAt`";
    $query   =  $con->query("SELECT * FROM `users` ORDER BY `createdAt` DESC");
    $output = "";
    if($query){
        $counter =0;
        while($row = $query->fetch_assoc()){
            $output.='<tr class="text-align-center">
                        <td>'.(++$counter).'</td>
                        <td>'.$row['fullName'].'</td>
                        <td>'.$row['email'].'</td>
                        <td>'.$row['phone'].'</td>
                        <td>'.date("d-m-Y",strtotime($row['createdAt'])).'</td>';
            $output.=' <td>
                    <button class ="btn btn-outline-primary btn-md user_view" id="'.$row['userId'].'" data-toggle="modal" data-target="#viewUserModal"><i class="fa fa-eye"></i></button>
                    </td>
                 </tr> ';
        }
     
    }else{
        $output.='<tr class="text-align-center"> <td colspan ="7"> No Record Found! </td></tr>';
    }
   echo $output;   
}

public function showInvestment(){ 
    $con     =  $this->con(); 
    $query   =  $con->query("SELECT * FROM `investments` ORDER BY `createdAt` DESC");
    $output = "";
    //`invId`, `userId`, `amount`, `tx_token`, `pmtChannel`, `issuerResponse`, `createdAt`
    if($query){
        $counter =0;
        while($row = $query->fetch_assoc()){
            $output.='<tr class="text-align-center">
                        <td>'.$this->getUserById($row['userId'])['fullName'].'</td>
                        <td>'.number_format($row['amount'],0,".",",").'</td>
                        <td>'.$row['tx_token'].'</td>
                        <td>'.$row['pmtChannel'].'</td>
                        <td>'.$row['issuerResponse'].'</td>
                        <td>'.date("d-m-Y",strtotime($row['createdAt'])).'</td>';
        }
     
    }else{
        $output.='<tr class="text-align-center"> <td colspan ="7"> No Record Found! </td></tr>';
    }
   echo $output;   
}

public function showWithdrawals(){ 
    $con     =  $this->con(); 
    //`wd_id`, `userId`, `wid_token`, `wid_amount`, `wid_status`, `createdAt`, `updatedAt`
    $query   =  $con->query("SELECT * FROM `withdrawals` ORDER BY `createdAt` DESC");
    $output = "";
    if($query){
        $counter =0;
        while($row = $query->fetch_assoc()){
            $output.='<tr class="text-align-center">
                        <td>'.$this->getUserById($row['userId'])['fullName'].'</td>
                        <td>'.number_format($row['wid_amount'],0,".",",").'</td>
                        <td>'.$row['wid_token'].'</td>
                        <td>'.$row['wid_status'].'</td>
                        <td>'.date("d-m-Y",strtotime($row['createdAt'])).'</td>';
            $output.=' <td>
                        <button class ="btn btn-outline-primary btn-md user_with_view" 
                               id="'.$row['userId'].'" data-toggle="modal" 
                               data-target="#viewUserModal"><i class="fa fa-eye"></i>
                        </button>
                    </td>
                 </tr> ';
        }
     
    }else{
        $output.='<tr class="text-align-center"> <td colspan ="7"> No Record Found! </td></tr>';
    }
   echo $output;   
}





// Beyond  users' and Requests Metrics 
public function investmentCount(){
    $con        = self::con(); 
    $query      = $con->query("SELECT * FROM `investments`");
    $totalCount = $query->num_rows;
    return ($totalCount>1000) ? number_format(($totalCount/1000),0,".",',').'K' : number_format($totalCount,0);
}

public function investmentSum(){
    $con        = self::con();        
    $query      = $con->query("SELECT SUM(`amount`) AS totalPending FROM `investments` WHERE `issuerResponse`='Success'");
    $totalCount = $query->fetch_assoc()['totalPending'];
    return ($totalCount>1000) ? number_format(($totalCount/1000),2,".",',').'K' : number_format($totalCount,1);
}

public function pendingWithrawals(){
    $con        = self::con();        
    $query      = $con->query("SELECT SUM(`wid_amount`) AS totalPending FROM `withdrawals` WHERE `wid_status`='pending'");
    $totalCount = $query->fetch_assoc()['totalPending'];
    return ($totalCount>1000) ? number_format(($totalCount/1000),2,".",',').'K' : number_format($totalCount,1);
}

public function successfullWithdrawals(){
    $con        = self::con();        
    $query      = $con->query("SELECT SUM(`wid_amount`) AS totalPending FROM `withdrawals` WHERE `wid_status`='settled'");
    $totalCount = $query->fetch_assoc()['totalPending'];
    return ($totalCount>1000) ? number_format(($totalCount/1000),2,".",',').'K' : number_format($totalCount,3);
}


public function totalUsers(){
    $con        = self::con();       
    $query      = $con->query("SELECT * FROM `users`");
    $totalCount = $query->num_rows;
    return ($totalCount>1000) ? number_format(($totalCount/1000),2,".",',').'K' : number_format($totalCount,0);
}

}


// Used to Initilize this the Common
class Shows {
    use BeyondCommon;
}

?>