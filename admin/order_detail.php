<?php


session_start();
require '../config/config.php';
require '../config/common.php';




 ?>







<?php include 'header.php'; ?>

<?php
if(empty($_POST['search'])) {
  if(!empty($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
  } else {
    $pageno = 1;
  }
  $numOfrecs = 2;
  $offset = ($pageno-1) * $numOfrecs;
  $stmt = $pdo->prepare("SELECT * from sale_order_details WHERE sale_order_id=".$_GET['id']);
  $stmt->execute();
  $rawResult = $stmt->fetchALL();
  $total_pages = ceil(count($rawResult)/ $numOfrecs);

  $stmt = $pdo->prepare("SELECT * from sale_order_details WHERE sale_order_id=".$_GET['id']." LIMIT $offset,$numOfrecs");
  $stmt->execute();
  $result = $stmt->fetchALL();
}
?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Order Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <br>
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th style="width: 150px">Customer Name</th>
                      <th>Product</th>
                      <th>Product's Image</th>
                      <th>Quantity</th>
                      <th>Order Date</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php if($result) {
                      $i = 1;
                      foreach($result as $value) {
                    ?>

                    <?php
                      $rawStmt = $pdo->prepare("SELECT * FROM products WHERE id=".$value['product_id']);
                      $rawStmt->execute();
                      $productResult = $rawStmt->fetchAll();
                    ?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo escape($_GET['name']);?></td>
                      <td><?php echo escape($productResult[0]['name']);?></td>
                      <td><img src="images/<?php echo escape($productResult[0]['image'])?>" width="150px" height="150px"></td>
                      <td><?php echo escape($value['quantity']);?></td>
                      <td><?php echo escape( date('Y-m-d', strtotime($value['order_date'])));?></td>
                    </tr>
                    <?php
                      $i++; }}
                    ?>


                  </tbody>
                </table><br />
                <nav aria-label="Page navigation example" style="float:left">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?name=<?php echo $_GET['name'];?>&id=<?php echo $_GET['id'];?>&pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno <=1){ echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno <=1){echo '#';}else{echo "?name=".$_GET['name']."&id=".$_GET['id']."&pageno=".($pageno-1);}?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled';}?>">
                      <a class="page-link" href="<?php if($pageno >= $total_pages){echo '#';}else{echo "?name=".$_GET['name']."&id=".$_GET['id']."&pageno=".($pageno+1);}?>">Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?name=<?php echo $_GET['name'];?>&id=<?php echo $_GET['id'];?>&pageno=<?php echo $total_pages?>">Last</a></li>
                  </ul>
                </nav>
                <div style="float:right;">
                  <a href="order_list.php" type="button" class="btn btn-warning">Back</a>
                </div>
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
