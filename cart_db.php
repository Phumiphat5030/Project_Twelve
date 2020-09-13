<?php
       session_start();
       include('server.php');  
       $errors = array();
       $order_date = date("Y-m-d H:i:s") ;
       $_SESSION['date'] = $order_date;
       
       $user_email = $_SESSION['email'];
       $sql = "SELECT id FROM users WHERE email = '$user_email'";
        if($res = mysqli_query($con, $sql)) {
            if(mysqli_num_rows($res) > 0 ){
                while($row = mysqli_fetch_array($res)){
                    $user_id = mysqli_escape_string($con, $row['id']);
                }
            }
        }
        $_SESSION['user_id'] = $user_id;

        
        

       if (isset($_POST['order'])) {
        

        // สร้าง ข้อมูลใหม่ใน TABLE orders
        $sql = "INSERT INTO orders (order_date,user_id) VALUES ('$order_date', '$user_id')";
        mysqli_query($con, $sql);
        
        
        // เลือก order_id จาก user_id ที่log in อยู่
        $sql = "SELECT order_id FROM orders WHERE user_id = '$user_id'";
            if($result = mysqli_query($con, $sql)) {
                if(mysqli_num_rows($result) > 0 ){
                    while($row = mysqli_fetch_array($result)){
                    $order_id =   mysqli_escape_string($con, $row['order_id']);            
                    }
                }
            }$_SESSION['order_id'] = $order_id;   

        //เอา order_id ไปใส่ใน TABLE orderdetail ใส่ตามจำนวนสินค้าใน array "shopping cart"
        foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
        $count = count($_SESSION["shopping_cart"]);
        $item_id = mysqli_escape_string($con, $values['item_id']);
        $item_quantity = mysqli_escape_string($con, $values['item_quantity']);
        $item_price = mysqli_escape_string($con, $values['item_price']);
        $sql = "INSERT INTO orderdetail (order_id, item_id, detail_quantity, price_each) VALUES ('$order_id', '$item_id', '$item_quantity', '$item_price')";
            mysqli_query($con, $sql);

       }
    header('location: orderdetail.php');
    }
      

?>
