
<!--  TOPUPs -->
<div class="row my-4" id ="RECHARGE">
       <div class="col-md-12">
            <div class="card">
                <div class="card-body"> 
                <div class="container">
                    <h1 class="display-6 text-muted">Withrawal Requests</h1>
                    <div class="table-responsive" style ="font-size:smaller;font-weight:600;">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Amount (₦)</th>
                                        <th>W_token</th>
                                        <th>Status</th>
                                        <th>Date Requested</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                      <?php   $sh->showWithdrawals();    ?>
                                    </tbody>
                                </table>
                            </div>
                                
                        </div>
                    </div>

               </div>
        </div>
    </div>
</div>
<!-- TOPUPs ENDS -->


