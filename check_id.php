<?php
    session_start();
    include("server.php");
    if (!isset($_SESSION['email'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header('location: main.php');
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
    <title>Document</title>
</head>
<body>
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
<?php if (isset($_SESSION['email'])) : ?>
            <p>Welcome <strong><?php echo $_SESSION['email']; ?></strong></p>      
<?php endif ?>

<?php
    $user_email = $_SESSION['email'];
    $sql = "SELECT id FROM users WHERE email = '$user_email'";
    if($res = mysqli_query($con, $sql)) {
        if(mysqli_num_rows($res) > 0 ){
            while($row = mysqli_fetch_array($res)){
                echo $row['id' ];
                $_SESSION['user_id'] = mysqli_escape_string($con, $row['id']);
            }
        }
    }
?>


</body>
</html>