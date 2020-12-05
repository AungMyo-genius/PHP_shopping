<?php
session_start();
require '../config/config.php';
require '../config/common.php';




if($_POST) {
  if(empty($_POST['name']) || empty($_POST['description']) || empty($_POST['category'])
    || empty($_POST['price']) || empty($_POST['quantity']) || empty($_FILES['image'])
  ||($_POST['price'] && (is_numeric( $_POST['price']) != 1)) || ($_POST['quantity'] && (is_numeric( $_POST['quantity']) != 1)) ) {
    if(empty($_POST['name'])) {
      $nameErr = "name is required";
    }
    if(empty($_POST['description'])) {
      $descErr = "description is required";
    }
    if(empty($_POST['category'])) {
      $catErr = "category is required";
    }
    if(empty($_POST['price'])) {
      $prcErr = "price is required";
    } elseif( $_POST['price'] && (is_numeric( $_POST['price']) != 1) ) {
        $prcErr = "Price should be integer value";
    }
    if(empty($_POST['quantity'])) {
      $qtyErr = "quantity is required";
    } elseif( $_POST['quantity'] && (is_numeric( $_POST['quantity']) != 1)) {
        $qtyErr = "Quantity should be integer value";
    }
    if(empty($_FILES['image'])) {
      $imgErr = "image is required";
    }
  } else {//valiation success
    $file = "images/".($_FILES['image']['name']);
    $imageExt = pathinfo($file,PATHINFO_EXTENSION);

    if($imageExt != 'png' && $imageExt != 'jpg' && $imageExt != 'jpeg') {
      echo "<script>alert('Image must be png, jpg or jpeg')</script>";
    } else {
      $name = $_POST['name'];
      $description = $_POST['description'];
      $category = $_POST['category'];
      $quantity = $_POST['quantity'];
      $price = $_POST['price'];
      $image = $_FILES['image']['name'];

      move_uploaded_file($_FILES['image']['tmp_name'], $file);

      $stmt = $pdo->prepare("INSERT INTO products(name, description, category_id, quantity, price, image)
      VALUES (:name, :description, :category, :quantity, :price, :image)");
      $result = $stmt->execute(
        array(":name"=>$name,":description"=>$description,":category"=>$category,":quantity"=>$quantity,":price"=>$price,":image"=>$image)
      );

      if($result) {
        echo "<script>alert('Product is added');window.location.href='index.php';</script>";
      }
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
              <form role="form" action="product_add.php" method="POST" enctype="multipart/form-data">
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
                <div class="form-group">
                  <?php $catStmt = $pdo->prepare("SELECT * from categories");
                        $catStmt->execute();
                        $catResult = $catStmt->fetchAll();
                  ?>
                  <label for="category">Category</label><p style="color:red;"><?php echo empty($catErr) ? '': '*'.$catErr;?></p>
                    <select class="form-control" name="category">
                      <option value="">SELECT CATEGORY</option>
                      <?php foreach($catResult as $value) { ?>
                      <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                    <?php }?>
                    </select>
                </div>
                <div class="form-group">
                  <label for="quantity">Quantity</label><p style="color:red;"><?php echo empty($qtyErr) ? '': '*'.$qtyErr;?></p>
                  <input type="number" class="form-control" name="quantity" id="quantity">
                </div>
                <div class="form-group">
                  <label for="price">Price</label><p style="color:red;"><?php echo empty($prcErr) ? '': '*'.$prcErr;?></p>
                  <input type="number" class="form-control" name="price" id="price">
                </div>
                <div class="form-group">
                  <label for="price">Image</label><p style="color:red;"><?php echo empty($imgErr) ? '': '*'.$imgErr;?></p>
                  <input type="file" class="form-control-file" name="image" id="price">
                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="index.php" class="btn btn-warning" type="button">Back</a>
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
