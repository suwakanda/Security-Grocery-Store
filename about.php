<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>
    
<div class="about-bg">

   <section class="home">

      <div class="content">
         <span>About <span1>TheGrocer</span1></span>
         <h3>Want the perfect and fresh item for your family and kids? Get them at TheGrocer for the cheapest price possible ~</h3>
         <p>TheGrocer is one of the country's biggest committed online grocery retailer with more than 100 ,000 dynamic clients shopping with us today.

Our goal is to give our clients the best shopping background as far as service, range, and value, which assembles a solid business and conveys long haul an incentive for our investors.

The world is evolving quickly, determined by various shopping propensities and always cutting-edge innovation for the customer. Grocery is the biggest of all retail portions and is moving on the web.

In addition, the quick development of shopping utilizing cell phones opens new chances. We are all around situated to exploit these long-haul basic patterns to assist our clients, accomplices, and investors.
             
      </div>

   </section>
<a href="https://www.freepik.com/free-photo/hand-painted-watercolor-background-with-sky-clouds-shape_9728603.htm#query=background&position=0&from_view=keyword">Image by denamorado</a> on Freepik
</div>    

<section class="about">

   <div class="row">

      <div class="box">
         <img src="images/about-img-1.png" alt="">
         <h3>Any Questions?</h3>
         <a href="contact.php" class="btn">contact us</a>
      </div>

      <div class="box">
         <img src="images/about-img-2.png" alt="">
         <h3>what we provide?</h3>
         <a href="shop.php" class="btn">our shop</a>
      </div>

   </div>

</section>











<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>