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
                <h3 class="card-title">Order Listing</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <br>
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Total Price</th>
                      <th>Order Time</th>

                      <th style="width: 150px">Actions</th>
                    </tr>
                  </thead>
                  <?php

                    if(!empty($_GET['pageno'])) {
                      $pageno = $_GET['pageno'];
                    } else {
                      $pageno = 1;
                    }
                    $numOfrecs = 5;
                    $offset = ($pageno-1) * $numOfrecs;
                    $stmt = $pdo->prepare("SELECT * from sale_orders ORDER BY id DESC");
                    $stmt->execute();
                    $rawResult = $stmt->fetchALL();
                    $total_pages = ceil(count($rawResult)/ $numOfrecs);

                    $stmt = $pdo->prepare("SELECT * from sale_orders ORDER BY id DESC LIMIT $offset,$numOfrecs");
                    $stmt->execute();
                    $result = $stmt->fetchALL();

                  ?>
                  <tbody>
                    <?php if($result) {
                      $i = 1;
                      foreach($result as $value) {
                    ?>

                    <?php
                      $rawStmt = $pdo->prepare("SELECT * FROM users WHERE id=".$value['user_id']);
                      $rawStmt->execute();
                      $userRes = $rawStmt->fetchAll();
                    ?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo escape($userRes[0]['name']);?></td>
                      <td><?php echo escape($value['total_price']);?></td>
                      <td><?php echo escape( date('Y-m-d', strtotime($value['order_date'])));?></td>

                      <td class="btn-group">
                      <div class="container"><a href="order_detail.php?id=<?php echo escape($value['id'])?>&name=<?php echo escape($userRes[0]['name']) ?>" type="submit" class="btn btn-default">Order Detail</a></div>

                      </td>
                    </tr>
                    <?php
                      $i++; }}
                    ?>


                  </tbody>
                </table><br />
                <nav aria-label="Page navigation example" style="float:left">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno <=1){ echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno <=1){echo '#';}else{echo "?pageno=".($pageno-1);}?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled';}?>">
                      <a class="page-link" href="<?php if($pageno >= $total_pages){echo '#';}else{echo "?pageno=".($pageno+1);}?>">Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages?>">Last</a></li>
                  </ul>
                </nav>
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
