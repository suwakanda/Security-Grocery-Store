+<?php

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>

<header class="header">

   <div class="flex">

      <a href="home.php" class="logo">The<span>Grocer</span>.</a>

      <nav class="navbar">
         <a href="home.php"><i class="fa fa-home"></i> HOME</a>
          <a href="about.php"><i class="fa fa-address-book"></i> ABOUT</a>
         <a href="shop.php"><i class="fa fa-shopping-basket"></i> PRODUCT</a>
         <a href="orders.php"><i class="fas fa-paperclip"></i> INVOICE</a>
         <a href="contact.php"><i class="fas fa-concierge-bell"></i> CONTACT</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user-circle"></div>
         <a href="search_page.php" class="fas fa-search"></a>
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
          
                    $notif=0;
      $count_notif = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
      $count_notif->execute([$user_id]);
      if($count_notif->rowCount() > 0){
         while($fetch_orders = $count_notif->fetch(PDO::FETCH_ASSOC)){
             if($fetch_orders['notification']=='yes'){
   $notif=$notif+1;
             }
         }
      }

         ?>
         <a href="notification.php"><i class="fa-sharp fa-solid fa-bell"></i><span>(<?= $notif; ?>)</span></a>
          
          
         
         <a href="wishlist.php"><i class="fas fa-star"></i><span>(<?= $count_wishlist_items->rowCount(); ?>)</span></a>
         <a href="cart.php"><i class="fas fa-cart-arrow-down"></i><span>(<?= $count_cart_items->rowCount(); ?>)</span></a>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>

         <p><?= $fetch_profile['name']; ?></p>
         <a href="user_profile_update.php" class="btn">update profile</a>
         <a href="logout.php" class="delete-btn">logout</a>
         <?php

if(!isset($user_id)){?>
   <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
      </div>
<?php }?>


      </div>

   </div>

</header>

<script>
let logoutTimer;

function startLogoutTimer() {
  // Define the inactivity timeout duration in milliseconds (e.g., 30 minutes)
  const inactivityTimeout = 15 * 60 * 1000; // 15 minutes

  // Reset the timer whenever there's activity on the page
  function resetTimer() {
    clearTimeout(logoutTimer);
    logoutTimer = setTimeout(logoutUser, inactivityTimeout);
  }

  // Function to logout the user
  function logoutUser() {
    // Perform logout actions (e.g., redirect to logout page)
    window.location.href = 'logout.php';
  }

  // Reset the timer on user activity events (e.g., mousemove, keypress, etc.)
  document.addEventListener('mousemove', resetTimer);
  document.addEventListener('keypress', resetTimer);

  // Start the initial timer
  resetTimer();
}

// Start the logout timer when the page loads
startLogoutTimer();
</script>