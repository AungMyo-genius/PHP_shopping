<?php include('header.php') ?>
<!--================Single Product Area =================-->
<?php
$stmt = $pdo->prepare("SELECT * from products WHERE id=".$_GET['id']);
$stmt->execute();
$result = $stmt->fetchAll();
?>
  <div class="container">
    <div class="row s_product_inner">
      <div class="col-lg-6">
        <div class="s_Product_carousel">
          <div class="single-prd-item">
            <img class="img-fluid" src="admin/images/<?php echo escape($result[0]['image'])?>">
          </div>
          <div class="single-prd-item">
            <img class="img-fluid" src="admin/images/<?php echo escape($result[0]['image'])?>">
          </div>
          <div class="single-prd-item">
            <img class="img-fluid" src="admin/images/<?php echo escape($result[0]['image'])?>">
          </div>
        </div>
      </div>
      <div class="col-lg-5 offset-lg-1">
        <div class="s_product_text">
          <h3><?php echo escape($result[0]['name'])?></h3>
          <h2>Price: <?php echo escape($result[0]['price'])?></h2>
          <ul class="list">
          <?php
          $catStmt = $pdo->prepare("SELECT * from categories WHERE id=".$result[0]['category_id']);
          $catStmt->execute();
          $catResult = $catStmt->fetchAll();
          ?>
            <li><a class="active" href="#"><span>Category</span> :<?php echo escape($catResult[0]['name'])?></a></li>
            <li><a class="active" href="#"><span>In Stock</span> :<?php echo escape($result[0]['quantity'])?></a></li>
          </ul>
          <p>Description: <?php echo escape($result[0]['description'])?></p>
          <div class="product_count">
            <label for="qty">Quantity:</label>
            <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
             class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
             class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
          </div>
          <div class="card_area d-flex align-items-center">
            <a class="primary-btn" href="#">Add to Cart</a>
            <a class="primary-btn" href="index.php">Back</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<br>
<!--================End Single Product Area =================-->

<!--================End Product Description Area =================-->
<?php include('footer.php');?>
