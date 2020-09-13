<?php 
    session_start();
    include('server.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up - Twelve</title>

    <link rel="stylesheet" href="style.css">
    <style>
        body{
            background-image: url('bg.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }
    </style>
</head>
<body>
    
    <div class = "header">
        <h2>Sign up</h2>
    </div>

    <form action= "register_db.php" method="post">
        <?php include('errors.php');?>
        <div class= "input-group">
            <label for="email">Email</label>
            <input type="email" name="email">
        </div>
        <div class= "input-group">
            <label for="password_1">Password</label>
            <input type="password" name="password_1">
        </div>
        <div class= "input-group">
            <label for="password_2">Confirm Password</label>
            <input type="password" name="password_2">
        </div>
        <div class= "input-group">
            <label for="firstname">Firstname</label>
            <input type="text" name="firstname">
        </div>
        <div class= "input-group">
            <label for="lastname">Lastname</label>
            <input type="text" name="lastname">
        </div>
        <div class= "input-group">
            <label for="address">Address</label>
            <input type="text" name="address">
        </div>
        <div class= "input-group">
            <label for="tel">Telephon number</label>
            <input type="text" name="tel">
        </div>
        <div class= "input-group">
            <button type="submit" name="reg_user" class="btn">Register</button>
        </div>
        <p>Already a member? <a href="login.php">Log in </a>here</p>
    </form>

</body>
</html>