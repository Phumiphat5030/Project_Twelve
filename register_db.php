<?php 
    session_start();
    include('server.php');
    
    $errors = array();

    if (isset($_POST['reg_user'])) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password_1 = mysqli_real_escape_string($con, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($con, $_POST['password_2']);
        $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
        $address = mysqli_real_escape_string($con, $_POST['address']);
        $tel = mysqli_real_escape_string($con, $_POST['tel']);


        if (empty($email)) {
            array_push($errors, "Email is required");
            $_SESSION['error'] = "Email is required";
        }
        if (empty($firstname)) {
            array_push($errors, "Firstname is required");
            $_SESSION['error'] = "Firstname is required";
        }
        if (empty($password_1)) {
            array_push($errors, "Password is required");
            $_SESSION['error'] = "Password is required";
        }
        if ($password_1 != $password_2) {
            array_push($errors, "The two passwords do not match");
            $_SESSION['error'] = "The two passwords do not match";
        }

        $user_check_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $query = mysqli_query($con, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        if ($result) { // if user exists
            if ($result['email'] === $email) {
                array_push($errors, "Email already exists");
            }
        }

        if (count($errors) == 0) {
            $password = md5($password_1);

            $sql = "INSERT INTO users (email, password, firstname, lastname, address, tel) VALUES ('$email', '$password', '$firstname', '$lastname', '$address', '$tel')";
            mysqli_query($con, $sql);

            $_SESSION['email'] = $email;
            $_SESSION['success'] = "You are now logged in";
            header('location: TwelveShop.php');
        } else {
            header("location: signup.php");
        }
    }

?>