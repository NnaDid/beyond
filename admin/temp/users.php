
 <!--  Users -->
 <div class="row my-4" id ="LatestTxn">
       <div class="col-md-12">
          <div class="card">
              <div class="card-body">
                <div class="container">
                  <h1 class="display-6 text-muted">Users</h1>
                  <div class="table-responsive"  style ="font-size:smaller;font-weight:600;">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>CreatedAt</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php   $sh->showUsers();  ?>
                                        </tbody>
                                    </table>
                                </div>
                           
                </div>
              </div>
          </div>
    </div>
</div>
<!--  Latest transactions ENDS -->


<!-- View User Modal -->


<div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog" aria-labelledby="viewUserModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewUserModalCenterTitle"> 
              <img src="../images/beyond1.png" height ="30" width ="30" alt="Beyond" />- Viewing User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
      </div>
 
      <div class="modal-body viewUser">
            <p class ="text-center"> <i class="fa fa-spinner fa-spin fa-3x"></i> </p>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function(){
    const adminUrl = '../api/admin/';
    $(document).on('click',".user_view", function(evt){
            evt.preventDefault();
            let userId  = $(this).attr('id');
            console.log(userId);
            $.ajax({  
              url:adminUrl,  method:"post",
              data:{uid:userId,action:'viewUser'},
              success: (res)=>{ $(".viewUser").html(res);  }
            });
        });


  });
</script>