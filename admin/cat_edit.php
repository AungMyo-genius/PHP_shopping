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
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE categories SET name=:name, description=:description WHERE id=:id");
    $result = $stmt->execute(
      array(":name"=>$name,":description"=>$description,":id"=>$id)
    );

    if($result) {
      echo "<script>alert('category edited');window.location.href='category.php';</script>";
    }
  }


}
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id=".$_GET['id']);
$stmt->execute();
$result = $stmt->fetchAll();


 ?>







<?php include 'header.php'; ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <form role="form" action="cat_edit.php" method="POST">
                <input name="_token" type="hidden" value="<?php echo escape($_SESSION['_token']); ?>">
                <input name="id" type="hidden" value="<?php echo escape($result[0]['id']);?> "
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label><p style="color:red;"><?php echo empty($nameErr) ? '': '*'.$nameErr;?></p>
                    <input type="text" class="form-control" name="name" id="name" value="<?php echo escape($result[0]['name']);?>">
                  </div>
                  <div class="form-group">
                    <label>Description</label><p style="color:red;"><?php echo empty($descErr) ? '': '*'.$descErr;?></p>
                    <textarea name="description" rows="8" cols="70" class="form-control"><?php echo escape($result[0]['description']);?></textarea>
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
