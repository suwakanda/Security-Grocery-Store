<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_users->execute([$delete_id]);
   header('location:admin_users.php');

}


if(isset($_GET['active'])){

   $status_id = $_GET['active'];
   $update_status = $conn->prepare("UPDATE `users` SET status = ? WHERE id = ?");
   $update_status->execute([1, $status_id]);
   header('location:admin_users.php');
}

if(isset($_GET['deactive'])){

   $status_id = $_GET['deactive'];
   $update_status = $conn->prepare("UPDATE `users` SET status = ? WHERE id = ?");
   $update_status->execute([0, $status_id]);
   
   header('location:admin_users.php');
}


if(isset($_POST['update'])){
   $user_id = $_POST['uid'];
   $update_status = $conn->prepare("UPDATE `users` SET user_type = ? WHERE id = ?");
   $update_status->execute([$_POST['usertype'], $user_id]);
   header('location:admin_users.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

   <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" href="css/bootstrap.min.css">

</head>
<body style="background:url(images/admin-bg.jpg); background-repeat: no-repeat; background-size: cover;">
   
<?php include 'admin_header.php'; ?>




<section class="table-product" >
<h1 class="title">user accounts</h1>

<div class="card " style="width: 100%;">

        <div class="card-header">
        <div class="card-body pr-2 pl-2">

          <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th class="text-center">NO</th>
                      <th  class="text-center">Name</th>
                      <th  class="text-center">Email</th>
                      <th  class="text-center">Status</th> 
                      <th  width='25%' class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $i=1;
                     $select_accounts = $conn->prepare("SELECT * FROM `users`");
                     $select_accounts->execute();
                     if($select_accounts->rowCount() > 0){
                        while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
                  ?>
                  
                  <tr class="text-center">

                    <td><?php echo $i++;?></td>
                    <td><?php echo $fetch_accounts['name'];?><br>
                          <?php if ($fetch_accounts['user_type']  == 'admin'){
                          echo "<span class='badge badge-lg badge-info text-white'>Admin</span>";
                        } elseif ($fetch_accounts['user_type'] == 'seller') {
                          echo "<span class='badge badge-lg badge-warning text-white'>Seller </span>";
                        }elseif ($fetch_accounts['user_type'] == 'user') {
                          echo "<span class='badge badge-lg badge-dark text-white'>User </span>";
                        } ?>
                  
                  
                  </td>
                    
                    <td><?php echo $fetch_accounts['email']; ?></td>
                    <td>   <?php if ($fetch_accounts['status'] == '1') { ?>
                          <span class="badge badge-lg badge-success text-white">Active</span>
                        <?php }else{ ?>
                       <span class="badge badge-lg badge-danger text-white">Deactive</span>
                        <?php } ?></td>
                   
                    <td>
                     <a class="btn btn-info btn-sm" href="?view=<?php echo $fetch_accounts['id'];?>">View</a>

                     <?php if ($fetch_accounts['status'] == '0') {  ?>
                        <a onclick="return confirm('Are you sure To Active ?')" class="btn btn-success
                                 btn-sm " href="?active=<?php echo $fetch_accounts['id'];?>">Active</a>
                               
                             <?php } elseif($fetch_accounts['status'] == '1'){?>
                              <a onclick="return confirm('Are you sure To Deactive ?')" class="btn btn-warning
                                 btn-sm " href="?deactive=<?php echo $fetch_accounts['id'];?>">Disable</a>
                             <?php } ?>  
                             <a onclick="return confirm('Are you sure To Delete ? The user related information will also be delete!')" class="btn btn-danger btn-sm " href="?delete=<?= $fetch_accounts['id']; ?>">Remove</a>     

                  </td>
                     
                  
                  <?php }?>





                  
                  <?php }else{
                     echo '<p class="empty">no accounts available!</p>';
                  }?>
                  
                  
                  </tr>
                  </tbody>

                  
          </table>
        </div>
        </div>
</div>
</section>

<?php
   if(isset($_GET['view'])){
      $user_id = $_GET['view'];
      $select_users = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
      $select_users->execute([$user_id]);
      if($select_users->rowCount() > 0){
         $fetch_user = $select_users->fetch(PDO::FETCH_ASSOC);
         $address ='';
         $address = ' '. $fetch_user['address']  .' '. $fetch_user['city'] .' '.  $fetch_user['pin'].' ';
   ?>

<section class="messages">

<h1 class="heading">User</h1>

<div class="box-container">


   <div class="box">
   <p> Name : <span><?= $fetch_user['name']; ?></span></p>
   <p> Email : <span><?= $fetch_user['email']; ?></span></p>
   <p> Phone : <span><?= $fetch_user['number']; ?></span></p>
   <p> Address : <span><?= $address; ?></span></p>


   
   <form method=post>
   <input type="hidden" name="uid" value="<?= $fetch_user['id']; ?>">


   <select name="usertype" class="box" required>
         <option selected><?= $fetch_user['user_type']; ?></option>
         <option value="admin">Admin</option>
         <option value="user">User</option>
         <option value="seller">Seller</option>
         </select>
         <input type="submit" class="btn btn-info btn-lg" value="update" name="update">
   </form>
   
   </div>
   <?php
         }
      }
   
      ?>










<script src="js/script.js"></script>


 <!-- Jquery script -->
 <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/dataTables.bootstrap4.min.js"></script>
  <script>
      $(document).ready(function () {
          $("#flash-msg").delay(7000).fadeOut("slow");
      });

      $(document).ready(function() {
          $('#example').DataTable();
          
      } );
      
      
  </script>


</body>
</html>