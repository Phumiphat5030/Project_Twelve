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

    $user_email = $_SESSION['email'];
    $sql = "SELECT id FROM users WHERE email = '$user_email'";
    if($res = mysqli_query($con, $sql)) {
        if(mysqli_num_rows($res) > 0 ){
            while($row = mysqli_fetch_array($res)){
                $user_id = mysqli_escape_string($con, $row['id']);
            }
        }
    } $_SESSION['user_id'] = $user_id;
    //Get user address
    $sql = "SELECT address FROM users WHERE email = '$user_email'";
    if($res = mysqli_query($con, $sql)) {
        if(mysqli_num_rows($res) > 0 ){
            while($row = mysqli_fetch_array($res)){
                $user_address = mysqli_escape_string($con, $row['address']);
            }
        }
    } $_SESSION['user_address'] = $user_address;

    // Check order_id from user_id
    $sql = "SELECT order_id FROM orders WHERE user_id = '$user_id'";
        if($result = mysqli_query($con, $sql)) {
            if(mysqli_num_rows($result) > 0 ){
                while($row = mysqli_fetch_array($result)){
                    $order_id =   mysqli_escape_string($con, $row['order_id']);            
            }
        }
    }$_SESSION['order_id'] = $order_id;   
        
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
    <h1>Orders</h1>
    <h2>Your order id: <?php echo $_SESSION['order_id']; ?></h2>
    <h3>Customer's name: <?php echo  $_SESSION['user_name']." ".$_SESSION['user_lastname'];?></h3>
    <h3>Address: <?php echo $_SESSION['user_address'];?></h3>
    <div class="table-responsive">
		<table class="table table-bordered">
		<tr>
        <th width="10%">Item id</th>
		<th width="70%">Item name</th>
		<th width="10%">Price</th>
		<th width="10%">Amount</th>
		</tr>
        <?php
		if(!empty($_SESSION["shopping_cart"]))
		{
		$total = 0;
		
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
		?>
		<tr>
		<td><?php echo $values["item_id"];
                ?>
        </td>
        <td><?php echo $values["item_name"];
                ?>
        </td>
		<td> <?php echo $values["item_price"]; ?></td>
        <?php
        $total = $total + ($values["item_quantity"] * $values["item_price"]);
        }
		?>
		<td> <?php echo number_format($total, 2); ?>THB</td>
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
    <p class="float-right">
	<form action= "orderdetail_db.php" method="post">
	<button type="submit" name="payment" class="btn">Confirm Payment</button>
	</p>
	</form>
	
  </div>
</footer>
</html>
