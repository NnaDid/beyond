<?php if($level !=='Level 1') die('Access Denied!');?>
 <!--  Users -->
 <div class="row my-4" id ="LatestTxn">
       <div class="col-md-12">
          <div class="card">
              <div class="card-body">
                <div class="container">
                   <div class="_thisResult"></div>
                  <h1 class="text-muted d-flex justify-content-between align-items-center">
                   <span>Admins</span>
                   <span class ="btn btn-primary btn-xs" data-toggle="modal" data-target="#addAdminModal" type="button"><i class="fa fa-plus npb-2"></i> Add Admin</span>
                  </h1>
                  <div class="table-responsive small">
                        <table id="datatable-buttons-admins small" class="table table-striped table-bordered">
                              <thead>
                              <tr>
                                  <th>S/N</th>
                                  <th>Name</th>
                                  <th>Designation</th>
                                  <th>Phone</th>
                                  <th>Email</th>
                                  <th>Privilege</th>
                                  <th>Created</th>
                                  <th>Action</th>
                              </tr>
                              </thead>
                              <tbody> 
                               <?php    $sh->showAdmins();   ?>
                              </tbody>
                          </table>
                      </div>
                           
                </div>
              </div>
          </div>
    </div>
</div>
<!--  Latest transactions ENDS -->

<!-- Add addAdminModal -->

<div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addAdminModalCenterTitle"> 
              <img src="../images/beyond1.png" height ="30" width ="30" alt="Beyond" />- New Admin Creation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
      </div>
 
      <div class="modal-body">
        <form class="createAdmin_form">
              <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-user"></i></span>
                   </div>
                    <input type="text" class="form-control form-control-lg name" name ="name"  Placeholder="Name of Admin" required/>
              </div> 

              <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                   </div>
                    <input type="email" class="form-control form-control-lg email" name ="email"  Placeholder="Admin Email" required/>
              </div> 

            <div class="input-group mb-3">
                 <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-mobile"></i></span>
                   </div>
                  <input type="tel" class="form-control form-control-lg phone" name ="phone"  Placeholder="Admin Phone Number" required/>
            </div> 

            <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-check"></i></span>
                   </div>
                  <input type="text" class="form-control form-control-lg designation" name ="designation"  Placeholder="Admin Designation Eg Sales Rep" required/>
            </div> 
            
              <div class="input-group mb-3">
                    <input type="password" class="form-control form-control-lg pwd" name ="pwd"  Placeholder="Choose Password" required />
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="fa fa-eye togleView"></i></span>
                   </div>
              </div> 
              <div class="input-group mb-3">
                    <input type="password" class="form-control form-control-lg pwd2" name ="pwd2"  Placeholder="Confirm Password" required />
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="fa fa-eye togleView"></i></span>
                   </div>
              </div> 
              <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-list"></i></span>
                   </div>
                    <select class="form-control form-control-lg" name ="category" required >
                      <option disabled selected>Select admin category</option>
                      <option name ="Level_1" id ="level1"><b>Level 1</b> </option>
                      <option name ="Level_2" id ="level2"><b>Level 2</b></option>
                    </select>
              </div> 
            <div class="addAdmin_result"></div>
            <input type="hidden" name="action" value ="create"> 
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create Admin</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>



<!-- editAdminModal -->

<div class="modal fade" id="editAdminModal" tabindex="-1" role="dialog" aria-labelledby="editAdminModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editAdminModalCenterTitle"> 
              <img src="../images/beyond1.png" height ="30" width ="30" alt="Beyond" />- Editing Admin</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
      </div>
 
      <div class="modal-body viewAdmin">
            <p class ="text-center"> <i class="fa fa-spinner fa-spin fa-3x"></i> </p>
      </div>
    </div>
  </div>
</div>

<script>
   $(document).ready(function(){
        const adminUrl = '../api/admin/';
        $(document).on('click',".admin_delete", function(evt){
           evt.preventDefault();
           if(confirm("Are you sure you want to delete this admin. This is an irreversible action ?")){
            let adminId  = $(this).attr('id');
            console.log(adminId);
            $.ajax({ url:adminUrl, method:"post",data:{aid:adminId,action:'delete'},
                    success: (res)=>{ 
                      if(res==1){
                        $("._thisResult").html('<div class ="alert alert-success">Deleted</div>');
                        $("._thisResult").slideUp(2000).delay(2000);
                        setTimeout(() => { location.reload(); }, 2000);
                      }else{
                        $("._thisResult").html('<div class ="alert alert-danger">'+res+'</div>');
                        $("._thisResult").slideUp(2000).delay(2000);
                      }
                    }
              });
           }
        });

        $(document).on('submit',".createAdmin_form", function(evt){
          evt.preventDefault();
          let data = $(this).serialize();
          $.ajax({
            url:adminUrl,
            data:data,
            method:"post",
            success: function(res){
              if(res==1){
                $("._thisResult, .addAdmin_result").html('<div class ="alert alert-success">Admin added successfully! </div>');
                setTimeout(() => { location.reload(); }, 2000);
              }else{
                $("._thisResult, .addAdmin_result").html('<div class ="alert alert-danger">'+res+'</div>');
              }
            }
          });
        });

      // Show Admin TO EDIT
      $(document).on('click',".admin_edit", function(evt){
            evt.preventDefault();
            let adminId  = $(this).attr('id');
            console.log(adminId);
            $.ajax({  
              url:adminUrl,  method:"post",
              data:{aid:adminId,action:'view'},
              success: (res)=>{ $(".viewAdmin").html(res);  }
            });
        });


       $(document).on('click',".View_toggle",function(){
            $(this).toggleClass("fa-eye fa-eye-slash");
            let atr = $(this).closest('div.input-group').find('input');
            (atr.attr('type')==='text') ? atr.attr('type','password') : atr.attr('type','text');
       });

        // Choose wether to change password aalong side or NOT
        $(document).on("change",'#myswitch',function() {
          ($(this).is(':checked')) ? $(".paswordSection").show(2000): $(".paswordSection").hide(2000);
        });

        $(document).on('submit',".editAdmin_form",function(evt){
            evt.preventDefault();
            let data = $(this).serialize();
            $.ajax({ 
               url:adminUrl, method:"post", data:data,
                  success: (res)=>{   
                    if(res==1){
                      $("._thisResult, .editAdmin_result").html('<div class ="alert alert-success"> Successfully Edited Admin! </div>');
                    }else{
                      $("._thisResult, .editAdmin_result").html('<div class ="alert alert-danger">'+res+'</div>');
                    }
                  }
              });
        });

   });
</script>