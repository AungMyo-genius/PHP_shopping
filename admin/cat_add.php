<?php
session_start();
require '../config/config.php';
require '../config/common.php';




if($_POST) {
  if(empty($_POST['name']) || empty($_POST['description'])) {
    if(empty($_POST['name'])) {
      $nameErr = "name is required";
    }
    if(empty($_POST['description'])) {
      $descErr = "description is required";
    }
  } else {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("INSERT INTO categories(name,description) VALUES(:name,:description)");
    $result = $stmt->execute(
      array(":name"=>$name,":description"=>$description)
    );

    if($result) {
      echo "<script>alert('category added');window.location.href='category.php';</script>";
    }
  }


}


 ?>







<?php include 'header.php'; ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <form role="form" action="cat_add.php" method="POST">
                <input name="_token" type="hidden" value="<?php echo escape($_SESSION['_token']); ?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label><p style="color:red;"><?php echo empty($nameErr) ? '': '*'.$nameErr;?></p>
                    <input type="text" class="form-control" name="name" id="name">
                  </div>
                  <div class="form-group">
                    <label>Description</label><p style="color:red;"><?php echo empty($descErr) ? '': '*'.$descErr;?></p>
                    <textarea name="description" rows="8" cols="70" class="form-control"></textarea>
                  </div>
                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="category.php" class="btn btn-warning" type="button">Back</a>
                </div>
              </form>

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
