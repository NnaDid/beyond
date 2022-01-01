<?php

require_once("../common.php");

class Admin {
    use BeyondCommon;

    public function __construct(){
      @$action  = $_POST['action'];
      switch($action){
            case 'create': $this->createAdmin();   break;

            case 'edit':   $this->updateAdmin();   break;

            case 'view':   $this->viewAdmin();     break;

            case 'delete': $this->deleteAdmin();   break; 

            case 'viewUser': $this->viewUser();    break; 

            case 'login'   : $this->login();    break; 
      }
    }

private function login(){ 
    $con      = $this->con();
    $email    = trim($_POST["email"]);     
    $pass     = trim($_POST["pwd"]);

    if($this->checkUserExist($email,"admins","email")){	
        $sql  		= "SELECT * FROM `admins` WHERE `email`=?";
        $stmt 		= $con->prepare($sql);
        $stmt->bind_param("s",$email);  
        if($stmt->execute()){
            $result	 = $stmt->get_result();
            $row       = $result->fetch_assoc();
            if( (md5($pass)===$row['paswd']) || password_verify($pass,$row['paswd']) ){
                session_start();
                $user    =  $_SESSION["BEYOND_ADMIN_LIVE"] = $row['email'];
                if( isset($user) ){ echo true; }else{ echo "Sorry No Session Was set at this time";}
            }else{
            echo "Incorrect Password";
        }
            
        }else{
             echo "LOGIN FAILED  ".$stmt->error;
        }
        
    }else{
        echo "Wrong Email address";
    }


}


    // Admin Operation
    private function createAdmin(){
        $con         =  $this->con();
        $name        = trim($_POST['name']);  
        $email       = trim($_POST['email']); 
        $phone       = trim($_POST['phone']);  
        $designation = trim($_POST['designation']);   
        $pwd         = trim($_POST['pwd']); 
        $pwd2        = trim($_POST['pwd2']);  
        $category    = trim($_POST['category']);

        if($pwd===$pwd2){ $pass_hash = password_hash($pwd,PASSWORD_DEFAULT); }else{ die("Password Mismatch");}
       // `bAID`, `name`, `phone`, `email`, `desgination`, `blevel`, `paswd`, `createdAt`
        if($this->checkUserExist($email,"admins","email")==false){
         if($this->checkUserExist($phone,"admins","phone")==false){
            $sql  = "INSERT INTO `admins`(`name`,`phone`,`email`,`desgination`,`blevel`,`paswd`,`createdAt`) VALUES(?,?,?,?,?,?,NOW())";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssssss",$name,$phone,$email,$designation,$category,$pass_hash);
            if($stmt->execute()){
                echo true;
            }else{
                echo "Error Registering ".$stmt->error;
            }
            $stmt->close(); 
       }else{
        echo "User with this phone exists already";
       }
      }else{
        echo "User with this email exists already"; 
      }
    }

    private function updateAdmin(){
        $con          = self::con();
        // `bAID`, `name`, `phone`, `email`, `desgination`, `blevel`, `paswd`, `createdAt`
        $blevel   = trim($_POST['blevel']);
        if($blevel==='Level 1'){
            $aid         = $_POST['aid'];
            $name        = trim($_POST['name']);
            $email       = trim($_POST['email']);
            $phone       = trim($_POST['phone']);
            $desgination = trim($_POST['designation']);
            $sql ="" ;
            if(isset($_POST['myswitch'])){;
                $password    = trim($_POST['edit_pwd']);
                $pwd         = password_hash($password,PASSWORD_DEFAULT);
                $sql.="UPDATE `admins` SET `name`='$name',`email`='$email',`phone`='$phone',`blevel`='$blevel',`desgination`='$desgination',`paswd`='$pwd' WHERE `bAID` ='$aid'";
            }else{
                $sql.="UPDATE `admins` SET `name`='$name',`email`='$email',`phone`='$phone',`blevel`='$blevel',`desgination`='$desgination' WHERE `bAID` ='$aid'";
            }       
            $query    = $con->query($sql);
            if($query){
                echo true;
            }else{
                echo "Error Editing ".$con->error;
            }
        }else{
            echo "You have not the permission to perform this action >".$blevel;
        }
        
    }

    private function deleteAdmin(){
        $con  = $this->con();
        $id   = $_POST['aid'];
        $sql  = $con->query("DELETE FROM `admins` WHERE `bAID`='$id'");
        if($sql){
            echo true;
        }else{
            echo "Error Deleting admin";
        }
    }

    private function viewAdmin(){
        $con  = $this->con();
        $id   = $_POST['aid'];
        $sql  = $con->query("SELECT * FROM `admins` WHERE `bAID`='$id'");
        if($sql){
            $row = $sql->fetch_assoc();
            echo '<form class="editAdmin_form">
            <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                 </div>
                  <input type="text" class="form-control form-control-lg edit_name" name ="name" value ="'.$row['name'].'" Placeholder="Name of Admin" required/>
            </div> 

            <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                 </div>
                  <input type="email" class="form-control form-control-lg edit_email" name ="email" value ="'.$row['email'].'"  Placeholder="Admin Email" required/>
            </div> 

          <div class="input-group mb-3">
               <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-mobile"></i></span>
                 </div>
                <input type="tel" class="form-control form-control-lg edit_phone" name ="phone" value ="'.$row['phone'].'" Placeholder="Admin Phone Number" required/>
          </div> 

          <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-check"></i></span>
                 </div>
                <input type="text" class="form-control form-control-lg edit_designation" name ="designation" value ="'.$row['desgination'].'" Placeholder="Admin Designation Eg Sales Rep" required/>
          </div> 

          <p> Change Password as well: <input type="checkbox" class="switch" name="myswitch" id="myswitch" /></p>
          <div class="form-group paswordSection" style ="display:none;"> 
            <div class="input-group mb-3">
                  <input type="password" class="form-control form-control-lg edit_pwd" name ="edit_pwd"  Placeholder="Choose Password"/>
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-eye View_toggle"></i></span>
                 </div>
            </div> 
        </div>

            <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-list"></i></span>
                 </div>
                  <select class="form-control form-control-lg edit_category" name ="edit_category" required >
                    <option disabled selected>Select admin category</option>
                    <option name ="Level_1" id ="level1" selected><b>Level 1</b> </option>
                    <option name ="Level_2" id ="level2"><b>Level 2</b></option>
                  </select>
            </div> 
          <div class="editAdmin_result"></div>
          <input type="hidden" name="action" value ="edit"> 
          <input type="hidden" name="blevel" value ="'.$row['blevel'].'"> 
          <input type="hidden" name="aid"    value ="'.$row['bAID'].'"> 
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update Admin</button>
          </div>
      </form>';
        }
    }


    // `userId`, `fullName`, `email`, `phone`, `bvn`, `paswd`, `phone_status`, `email_status`, 
    // `createdAt`, `updateedAt`, `profilePix` 
    private function viewUser(){
        $con  = $this->con();
        $id   = $_POST['uid'];
        $sql  = $con->query("SELECT * FROM `users` WHERE `userId`='$id'");
        $output ='<ul class="list-group">';
        if($sql){
           $row     = $sql->fetch_assoc();
           $output .='<li class="list-group-item d-flex justify-content-between align-items-center">
                       Name:
                       <span class="badge badge-primary badge-pill">'. $row['fullName'].'</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                       Email:
                       <span class="badge badge-primary badge-pill">'. $row['email'].'</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                       Email:
                       <span class="badge badge-primary badge-pill">'. $row['phone'].'</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                       BVN:
                       <span class="badge badge-primary badge-pill">'. $row['bvn'].'</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                       Phone Status:
                       <span class="badge badge-primary badge-pill">'. $row['phone_status'].'</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                       Email Status:
                       <span class="badge badge-primary badge-pill">'. $row['email_status'].'</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                       Date Created:
                       <span class="badge badge-primary badge-pill">'. $row['createdAt'].'</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                       Date Last Updated:
                       <span class="badge badge-primary badge-pill">'. $row['updateedAt'].'</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                       Profile Pix:
                       <span class="badge badge-primary badge-pill">
                        <img src ="'.$row['profilePix'].'"/>
                       </span>
                      </li>
                      ';
        }
        $output .='</ul>';
        echo $output;
    }



}

$admin = new Admin();

?>