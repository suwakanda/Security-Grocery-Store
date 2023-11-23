<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['submit'])){
$order_id = $_POST['order_id'];
   $notification='no';
        $update_notif = $conn->prepare("UPDATE `orders` SET notification = ? WHERE id = ?");
        $update_notif->execute([$notification, $order_id]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="placed-orders">

   <h1 class="title">notification</h1>

   <div class="box-container">

   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
      $select_orders->execute([$user_id]);
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
             if($fetch_orders['notification']=='yes'){
   ?>
   <form action="" method="POST">
   <div class="box">
       <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
       <p>One of your orders have arrived!</p>
       <input type="submit" name="submit" class="btn"  value="dismiss">
   </div>
       </form>
   <?php
      }
         }
   }else{
      echo '<p class="empty">no orders placed yet!</p>';
   }
   ?>
       
       

   </div>

</section>









<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>