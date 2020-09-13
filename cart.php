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
        header('location: main.php');
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
		echo '<script>window.location="cart.php"</script>';
		}
		}
	}
}
		
$user_email = $_SESSION['email'];
        $sql = "SELECT firstname FROM users WHERE email = '$user_email'";
         if($res = mysqli_query($con, $sql)) {
             if(mysqli_num_rows($res) > 0 ){
                 while($row = mysqli_fetch_array($res)){
                     $user_name = mysqli_escape_string($con, $row['firstname']);
                 }
             }
         }
         $_SESSION['user_name'] = $user_name;
         $sql = "SELECT lastname FROM users WHERE email = '$user_email'";
        if($res = mysqli_query($con, $sql)) {
            if(mysqli_num_rows($res) > 0 ){
                while($row = mysqli_fetch_array($res)){
                    $user_lastname = mysqli_escape_string($con, $row['lastname']);
                }
            }
        }
        $_SESSION['user_lastname'] = $user_lastname;

        
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Order</title>
        <meta charset="utf-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="topbar.css">
		<link rel="stylesheet" href="style.css">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  </head>
    </head>
    <body>
    <header>
<div class="topnav">
	<a href="testindex.php" >
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
    <h1>Your cart</h1>
		<div class="table-responsive">
		<table class="table table-bordered">
		<tr>
		<th width="40%">Item Name</th>
		<th width="10%">Quantity</th>
		<th width="20%">Price</th>
		<th width="15%">Total</th>
		<th width="5%">Action</th>
		</tr>
		<?php
		if(!empty($_SESSION["shopping_cart"]))
		{
		$total = 0;
		
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
		?>
		<tr>
		<td><?php echo $values["item_name"]; ?></td>
		<td><?php echo $values["item_quantity"]; ?></td>
		<td> <?php echo number_format($values["item_price"],2); ?>THB</td>
		<td> <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?>THB</td>
		<td><a href="cart.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
		</tr>
		<?php
		$total = $total + ($values["item_quantity"] * $values["item_price"]);
		}
		?>
		<tr>
		<td colspan="3" align="right">Total</td>
		<td align="right"> <?php echo number_format($total, 2); ?>THB</td>
		<td></td>
		</tr>
		<?php
		}
		?>
		
		</table>
		</div>
		</div>
	<br />
  </div>
    </body>
    <footer class="text-muted">
	
	
  <div class="container">
		<p>Username <strong><?php echo $_SESSION['user_name']." ".$_SESSION['user_lastname'] ; ?></strong></p>
    <p class="float-right">
	<form action= "cart_db.php" method="post">
	<button type="submit" name="order" class="btn" href><strong>Confirm cart</strong></button>
	</p>
	</form>
  </div>
</footer>
</html>
