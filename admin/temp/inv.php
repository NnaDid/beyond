
 <!--  Latest transactions -->
 <div class="row my-4" id ="LatestTxn">
       <div class="col-md-12">
          <div class="card">
              <div class="card-body">
                <div class="container">
                  <h1 class="display-6 text-muted">User(s) Investments</h1>
                  <div class="table-responsive" style ="font-size:smaller;font-weight:600;">
                        <table id="datatable-buttons" class="table table-striped table-bordered text-sm">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Invested(₦)</th>
                                            <th>Tx Token</th>
                                            <th>Pmt Channel</th>
                                            <th>issuerResponse</th>
                                            <th>Tx Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php    $sh->showInvestment();    ?>
                                        </tbody>
                                    </table>
                                </div>
                           
                </div>
              </div>
          </div>
    </div>
</div>
<!--  Investments ENDS -->