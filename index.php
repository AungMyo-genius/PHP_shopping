<?php
if(!empty($_POST['search'])) {
  setcookie('search',$_POST['search'], time() + (86400 * 30), "/");
}else{
  if (empty($_GET['pageno'])) {
    unset($_COOKIE['search']);
    setcookie('search', null, -1, '/');
  }
}

if(!empty($_GET['category_id'])) {
  setcookie('category_id',$_GET['category_id'], time() + (86400 * 30), "/");
}else{
  if (empty($_GET['pageno'])) {
    unset($_COOKIE['category_id']);
    setcookie('category_id', null, -1, '/');
  }
}

?>
<?php include('header.php') ?>



<?php

if (!empty($_GET['pageno'])) {
  $pageno = $_GET['pageno'];
}else{
  $pageno = 1;
}

$numOfrecs = 3;
$offset = ($pageno - 1) * $numOfrecs;

if (empty($_POST['search']) && empty($_COOKIE['search'])) {
  if (!empty($_GET['category_id']) || !empty($_COOKIE['category_id'])) {
    $categoryId = !empty($_GET['category_id']) ? $_GET['category_id'] : $_COOKIE['category_id'] ;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=$categoryId AND quantity > 0 ORDER BY id DESC");
    $stmt->execute();
    $rawResult = $stmt->fetchAll();

    $total_pages = ceil(count($rawResult) / $numOfrecs);

    $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=$categoryId AND quantity > 0 ORDER BY id DESC LIMIT $offset,$numOfrecs");
    $stmt->execute();
    $result = $stmt->fetchAll();
  }else{
    $stmt = $pdo->prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC");
    $stmt->execute();
    $rawResult = $stmt->fetchAll();

    $total_pages = ceil(count($rawResult) / $numOfrecs);

    $stmt = $pdo->prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC LIMIT $offset,$numOfrecs");
    $stmt->execute();
    $result = $stmt->fetchAll();
  }
}else{
  $searchKey = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
  $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity > 0 ORDER BY id DESC");
  $stmt->execute();
  $rawResult = $stmt->fetchAll();

  $total_pages = ceil(count($rawResult) / $numOfrecs);

  $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity > 0 ORDER BY id DESC LIMIT $offset,$numOfrecs");
  $stmt->execute();
  $result = $stmt->fetchAll();
}

?>
				<!-- End Filter Bar -->
        <div class="container">
      		<div class="row">
      			<div class="col-xl-3 col-lg-4 col-md-5">
      				<div class="sidebar-categories">
      					<div class="head">Browse Categories</div>
      					<ul class="main-categories">
      						<li class="main-nav-list">
                    <?php
                    $catStmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
                    $catStmt->execute();
                    $catResult = $catStmt->fetchALL();
                    foreach($catResult as $value) {
                    ?>
                    <a href="?category_id=<?php echo escape($value['id'])?>">
                      <span class="lnr lnr-arrow-right"></span><?php echo escape($value['name']);?><span class="number"></span>
                    </a>
                  <?php } ?>
      						</li>
      					</ul>
      				</div>
      			</div>
				<!-- Start Best Seller -->
        <div class="col-xl-9 col-lg-8 col-md-7">
  				<!-- Start Filter Bar -->
  				<div class="filter-bar d-flex flex-wrap align-items-center">
  					<div class="pagination">
              <a href="?pageno=1" class="active">First</a>
  						<a <?php if($pageno <=1){echo 'disabled';}?>
              href="<?php if($pageno <=1){echo '#';}else{echo "?pageno=".($pageno-1);}?>" class="prev-arrow">
              <i class="fa fa-long-arrow-left" aria-hidden="true" style="margin-top:15px;">
              </i>
              </a>
  						<a href="#" class="active"><?php echo $pageno;?></a>
  						<a <?php if($pageno >= $total_pages){echo 'disabled';}?>
              href="<?php if($pageno >= $total_pages) {echo '#';}else{echo "?pageno=".($pageno+1);}?>" class="next-arrow">
              <i class="fa fa-long-arrow-right" aria-hidden="true" style="margin-top:15px;">
              </i>
              </a>
              <a href="?pageno=<?php echo $total_pages;?>" class="active">Last</a>
  					</div>
  				</div>
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
					<?php if($result) {
          foreach($result as $value) {?>
						<div class="col-lg-4 col-md-6">
							<div class="single-product">
								<a href="product_detail.php?id=<?php echo escape($value['id'])?>"><img class="img-fluid" src="admin/images/<?php echo escape($value['image'])?>" style="height:250px;"></a>
								<div class="product-details">
									<h6> <?php echo escape($value['name'])?></h6>
									<div class="price">
										<h6> <?php echo escape($value['price'])?></h6>
									</div>
									<div class="prd-bottom">
                    <form class="" action="addtocart.php" method="post">
                      <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                      <input type="hidden" name="id" value="<?php echo escape($value['id'])?>">
                      <input type="hidden" name="qty" value="1">
                      <div class="social-info">
                        <button type="submit" class="social-info" style="display:contents">
                        <span class="ti-bag"></span><p class="hover-text" style="left:20px">add to bag</p>
                        </button>
                      </div>
  										<a href="product_detail.php?id=<?php echo escape($value['id'])?>" class="social-info" >
  											<span class="lnr lnr-move"></span>
  											<p class="hover-text">view more</p>
  										</a>
                    </form>
									</div>
								</div>
							</div>
						</div>
          <?php  } } ?>
					</div>
				</section>
				<!-- End Best Seller -->
<?php include('footer.php');?>
