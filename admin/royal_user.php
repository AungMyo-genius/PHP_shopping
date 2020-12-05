<?php

session_start();
require '../config/config.php';
require '../config/common.php';


?>


<?php include 'header.php'; ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Weekly Report</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered" id="d-table">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Total Price</th>
                      <th>Order Time</th>
                    </tr>
                  </thead>
                  <?php
                  $price = 40000;
                  $stmt = $pdo->prepare("SELECT * from sale_orders WHERE total_price >= :price ORDER BY id DESC");
                  $stmt->execute([':price'=>$price]);
                  $result = $stmt->fetchALL();
                  ?>
                  <tbody>
                    <?php if($result) {
                      $i = 1;
                      foreach($result as $value) {
                      $rawStmt = $pdo->prepare("SELECT * FROM users WHERE id=".$value['user_id']);
                      $rawStmt->execute();
                      $userRes = $rawStmt->fetchAll();
                    ?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo escape($userRes[0]['name']);?></td>
                      <td><?php echo escape($value['total_price']);?></td>
                      <td><?php echo escape( date('Y-m-d', strtotime($value['order_date'])));?></td>
                    </tr>
                    <?php
                      $i++; }}
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->


            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include 'footer.php'?>
<script>
$(document).ready(function() {
  $('#d-table').DataTable();
} );
</script>
