
    <div class="row">       
        <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Basic Profile Info</h4>
                  <p class="card-description">  My profile info </p>
                  <form class="forms-profile" id ="basicInfoForm">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fname">Name</label>
                            <input type="text" class="form-control form-control-lg" name ="fname" id="fname" placeholder="Full Name" value ="<?php echo $name; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phoneNumber">Phone Number</label>
                            <input type="tel" class="form-control form-control-lg" id="phoneNumber" name ="phoneNumber" placeholder="Phone Number"  value ="<?php echo $phone; ?>">
                        </div> 
                    </div>


                    <div class="form-row">
                         <div class="form-group col-md-6">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control form-control-lg" name ="email" id="email" placeholder="Email"  value ="<?php echo $admin_email; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="designation">Designation</label>
                            <input type="text" class="form-control form-control-lg" id="designation" name ="designation" disabled  value ="<?php echo $desi; ?>">
                        </div> 
                        <div class="form-group col-md-2">
                            <label for="privilege">Admin Privilege</label>
                            <input type="tel" class="form-control form-control-lg" id="privilege" name ="privilege" disabled  value ="<?php echo $level; ?>">
                        </div> 

                    </div> 
				          	<input type="hidden" name="action" value ="basicInfo">
                    <button type="submit" class="btn btn-primary mr-2 basicInfoFormBtn">Submit Changes</button> 
                  </form>
                </div>
              </div>
    </div>
</div>





<!-- CHANGE PASSWORD  -->
<div class="row my-4">
     <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Reset Password</h4>
                  <form class="changePasswordForm" id="changePasswordForm"> 
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="password">Old Password</label>
                            <input type="password" class="form-control form-control-lg" id="old-password" name ="old-password" placeholder="Old Password">
                        </div>
                        <div class="form-group col-md-4">
                                <label for="newpassword">New Password</label>
                                <input type="password" class="form-control form-control-lg" name ="new-password" id="new-password" placeholder="New Password">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="confirmNewPassword"> Confirm New Password</label>
                            <input type="password" class="form-control form-control-lg" id="re-password" name ="re-password" placeholder="confirmNewPassword">
                        </div>
                    </div>
 
				            <input type="hidden" name="action" value ="update_password">
                    <button type="submit" class="btn btn-primary mr-2 changePasswordFormBtn">Save Changes</button> 
                  </form>
                </div>
              </div>
    </div>
</div>