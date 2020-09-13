<?php 
    session_start();
    include ("server.php");
    if (!isset($_SESSION['email'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header('location: main.php');
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
		'item_quantity'		=>	$_POST["quantity"]
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
		'item_quantity'		=>	$_POST["quantity"]
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
		echo '<script>window.location="TwelveShop.php"</script>';
		}
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="topbar.css">
    <title>Home Page</title>


</head>
<body>
<header>
<div class="topnav">	
	<a href="TwelveShop.php" >
        <h1><strong>TWELVE</strong></h1>
      </a>
      <a href="cart.php"  >
	  <h1><strong>CART</strong></h1>
	</a>
      <?php if (isset($_SESSION['email'])) : ?>
            <h1><strong><a style="float:right" href="index.php?logout='1'" >Logout</a></strong></h1>
        <?php endif ?>
	  
  </div>
    </header>
    <div class="content">
        <!--  notification message -->
        <?php if (isset($_SESSION['success'])):
            $query = "SELECT * FROM items ORDER BY item_id ASC";
            $result = mysqli_query($con, $query);
            if(mysqli_num_rows($result) > 0)
		{
		while($row = mysqli_fetch_array($result))
		{
		?>
		<div class="col-md-2">
		<form method="post" action="TwelveShop.php?action=add&id=<?php echo $row["item_id"]; ?>">
		<div style="   padding:16px;" align="center">
		<img src="product_img/<?php echo $row["item_img"]; ?>" class="img-responsive" /><br />
 
		<h4 class="text-info"><?php echo $row["item_name"]; ?></h4>
 
		<h4 class="text-danger">Price: <?php echo number_format ($row["item_price"],2); ?>THB</h4>
 
		<input type="text" name="quantity" value="1" class="form-control" />
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
        <?php endif ?>     
        <!-- logged in user information -->
		<?php if (isset($_SESSION['email'])) : ?>
            <p>Welcome <strong><?php echo $_SESSION['email']; ?></strong></p>
           
        <?php endif ?>
    </div>

</body>
</html>