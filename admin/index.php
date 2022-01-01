<?php
    @session_start();
    function checkLoggedIn($loc){
        if(!isset($_SESSION["BEYOND_ADMIN_LIVE"])){ 
        @header("location:$loc");
        }
        $admin_email =$_SESSION["BEYOND_ADMIN_LIVE"];
        if(isset($_SESSION["BEYOND_ADMIN_LIVE"])){
        if(isset($_GET['u']) && $_GET['u']=="logout"){ 
            unset($_SESSION["BEYOND_ADMIN_LIVE"]);
            session_destroy(); 
            @header("location:$loc");
        }
      }
    }
 checkLoggedIn("../login.html");
 require_once('../api/common.php');
 $sh     = new Shows(); 
 $admin_email = $_SESSION["BEYOND_ADMIN_LIVE"];
 $admin  = $sh->getAdmin($admin_email); 
 $name   = $admin['name'];
 $phone  = $admin['phone'];
 $desi   = $admin['desgination'];
 $level  = $admin['blevel'];
 $showAdminMenu =  ($level==='Level 1') ? '<li><a href="?pg=admins" class ="pages"><i class="fa fa-users"></i>Admins</a> </li> ' : '';
 require_once('header.php'); 
 ?>
<div id="wrapper" class="wrapper-content">
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="my-3 border-bottom"> 
               <a href="./"> <label style ="color:#007bff; font-weight:900;">
                   <label><img src="../images/beyond1.png" height ="30" width ="30" alt="Beyond" />  BEYOND  </label> 
              </a> 
          </li> 
            <li>   <a href="?pg=home"  class ="pages"><i class="fa fa-home"></i>        Home             </a> </li> 
            <li>   <a href="?pg=inv"   class ="pages"><i class="fa fa-pie-chart"></i>   Investments      </a> </li> 
            <li>   <a href="?pg=with"  class ="pages"><i class="fa fa-bar-chart"></i>   Withdrawals      </a> </li> 
            <li>   <a href="?pg=users" class ="pages"><i class="fa fa-users"></i>       Users            </a> </li> 
            <?php  echo $showAdminMenu ;  ?>
            <li>   <a href="?pg=msg"   class ="pages"><i class="fa fa-send"></i>        Messages         </a> </li> 
        </ul>
    </div>

    <div id="page-content-wrapper">
        <nav class="navbar navbar-default">
            <div class="container-fluid d-flex justify-content-between">
                <div class="navbar-header">
                    <button class="btn-menu btn btn-primary btn-toggle-menu" type="button">
                        <i class="fa fa-bars"></i>
                    </button>
                </div> 

                <div class="btn-group">
                    <a href ="?pg=profile" class="btn btn-primary float-md-right"> <i class="fa fa-user"></i> Profile</a>
                       &nbsp;
                     <a href ="?u=logout" class="btn btn-danger float-md-right"> <i class="fa fa-lock"></i> Logout  </a>
                </div>

            </div>
        </nav>
   
        <div class="container-fluid">
           <div class="row">
             <div class="col-md-12 border-bottom my-2">  
                    <h4 class="mb-2">
                    <img src="../images/beyond1.png" height ="30" width ="30" alt="Beyond" /> 
                    <?php echo $_SESSION["BEYOND_ADMIN_LIVE"]; ?>
                  </h4> 
              </div>
           </div>
        </div>
       
        <?php 
          if(isset($_GET["pg"]) && !empty($_GET["pg"])){
            $pagePart = $_GET["pg"];
            $pageUrl  = "temp/".$pagePart.".php";
              if(file_exists($pageUrl)){
                  require_once($pageUrl);
              }else{
                require_once("temp/home.php");
              }              
            }else{
              require_once("temp/home.php");
            }
        ?>


  <!-- Footer-->
  <div class="card">
      <div class="card-header">
            Beyond. All right reserved. &copy; <?php echo date('Y'); ?>
      </div>
  </div>


</div>



<script src="https://checkout.flutterwave.com/v3.js"></script>
<script>
    $(document).ready(function(){
        $(".btn-toggle-menu").click(function() {
            $("#wrapper").toggleClass("toggled");
        });


    /* -- Table - Datatable -- */    
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        responsive: true,
        buttons: ['excel', 'pdf', 'print']
        //buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
    var table2 = $('#datatable-buttons-two').DataTable({
        lengthChange: false,
        responsive: true,
        buttons: ['excel', 'pdf', 'print']
        //buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
    table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    // table2.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');



        // Smooth scrolling topage sections fa-eye
        let pages     = document.querySelectorAll(".pages");
        let togleView = document.querySelectorAll(".togleView");

        togleView.forEach((el)=>{
          el.addEventListener("click",function(e){
                $(this).toggleClass("fa-eye fa-eye-slash");
                let atr = $(this).closest('div.input-group').find('input');
                (atr.attr('type')==='text') ? atr.attr('type','password') : atr.attr('type','text');
            },false);
        });
        
        for(var i=0;i<pages.length;i++){
            pages[i].addEventListener("click",function(e){
                //e.preventDefault();
                let href = $(this).attr("href");
                $('html, body').animate({ scrollTop: $(href).offset().top }, 2000);
            },false);
        } 


    }); 
</script>
</body>
</html>