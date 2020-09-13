<?php
	session_start();
	include('server.php');
	
    if (!isset($_SESSION['email'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header('location: login.php');
    }


	if(isset($_POST["add_to_cart"]))
{
	if(isset($_SESSION["shopping_cart"]))
	{
		$item_array_id = array_column($_SESSION["shopping_cart"], "id");
		if(!in_array($_GET["id"], $item_array_id))
		{
		$count = count($_SESSION["shopping_cart"]);
		$item_array = array(
		'item_id'		=>	$_GET["id"],
		'item_name'		=>	$_POST["hidden_name"],
		'item_price'		=>	$_POST["hidden_price"],
		'item_quantity'		=>	$_POST["quantity"],
		'item_size'         => $_POST["size"]
	 	);
		$_SESSION["shopping_cart"][$count] = $item_array;
		}
		
		else
		{
		echo '<script>alert("Item Already Added")</script>';
		}
	}
	else
	{
		$item_array = array(
		'item_id'		=>	$_GET["id"],
		'item_name'		=>	$_POST["hidden_name"],
		'item_price'		=>	$_POST["hidden_price"],
		'item_quantity'		=>	$_POST["quantity"],
		'item_size'         => $_POST["size"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
	}
}
 
if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
		if($values["item_id"] == $_GET["id"])
		{
		unset($_SESSION["shopping_cart"][$keys]);
		echo '<script>alert("Item Removed")</script>';
		echo '<script>window.location="test.php"</script>';
		}
		}
	}
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <title>TWELVE</title>
    <link rel="stylesheet" href="shop.css">

    <!-- Bootstrap core CSS -->
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- Favicons -->


    <!-- Custom styles for this template -->
  </head>
  <body>
    <header>
    <div class="navbar navbar-dark bg-dark shadow-sm">
      <a href="#" class="navbar-brand d-flex align-items-center">
        <h1><strong>TWELVE</strong></h1>
      </a>
      <a href="main.php" class="navbar-brand d-flex align-items-center" >
        <h3><strong>Logout</strong></h3>
	  </a>
	  <a href="cart.php" class="navbar-brand d-flex align-items-center" >
		  <img src="cart.png" width="15%" hight="15%">
      </a>
  </div>
    </header>
<main role="main">
  <section class="jumbotron text-center">
    <div class="container">
        <div class="bg-text">
      <h1>TWELVE</h1>
      <p class="lead text-muted">Our shop has a lots styles of cloth for men and women,</br> also stay update new fashion clothes never out of trend.</p>
    </div>
</div>
  </section>
  <div class="container">
  <?php
		$query = "SELECT * FROM items ORDER BY item_id ASC";
		$result = mysqli_query($con, $query);
	 if(mysqli_num_rows($result) > 0)
		{
		while($row = mysqli_fetch_array($result))
		{
		?>
		<div class="col-md-3">
		<form method="post" action="test.php?action=add&id=<?php echo $row["item_id"]; ?>">
		<div style="   padding:16px;" align="center">
		<img src="product_img/<?php echo $row["item_img"]; ?>" class="img-responsive" /><br />
 
		<h4 class="text-info"><?php echo $row["item_name"]; ?></h4>
 
		<h4 class="text-danger">Price: <?php echo number_format ($row["item_price"],2); ?>THB</h4>
 
		<input type="text" name="quantity" value="1" class="form-control" />
		<input type ="text" name="size" placeholder="size" class="form-control"  />
		<input type="hidden" name="hidden_name" value="<?php echo $row["item_name"]; ?>" />
		<input type="hidden" name="hidden_price" value="<?php echo $row["item_price"]; ?>" />
		<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />
 
		</div>
		</form>
		</div>
		<?php
		}
		}
		?>
		<div style="clear:both"></div>
		<br />
</main>

<footer class="text-muted">
  <div class="container">
    <p class="float-right">
      <h1><a href="#">Back to top</a></h1>
    </p>
  </div>
</footer>
<script src="bootstrap/js/jquery.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
	  </body>
</html>