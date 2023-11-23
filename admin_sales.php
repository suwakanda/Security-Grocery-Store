<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}


date_default_timezone_set('Asia/Kuala_Lumpur');

$today = date('Y-m-d');
$year = date('Y');
if(isset($_GET['year'])){
  $year = $_GET['year'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sales Report</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<!--body style="background:url(images/admin-bg.jpg); background-repeat: no-repeat; background-size: cover;"-->
<body>
<?php include 'admin_header.php'; ?>

<section class="heading">
   
   <h1 class="heading">Sales Report</h1>
<br>
                  <label>Select Year: </label>
                    <select class="form-control input-sm" id="select_year">
                      <?php
                        for($i=2015; $i<=2065; $i++){
                          $selected = ($i==$year)?'selected':'';
                          echo "
                            <option value='".$i."' ".$selected.">".$i."</option>
                          ";
                        }
                      ?>
                    </select>
   <div style="width:auto;">
  <canvas id="myChart" ></canvas>
</div>

<!-- Chart Data -->
<?php



  $months = array();
  $sales = array();
    $date='';
    
  for( $m = 1; $m <= 12; $m++ ) {
      $x=0;
    try{
      /*$stmt = $conn->prepare("SELECT * FROM orders  WHERE MONTH(placed_on)=:month AND YEAR(placed_on)=:year");
      $stmt->execute(['month'=>$m, 'year'=>$year]);
      $total = 0;
      foreach($stmt as $srow){
        $subtotal = $srow['total_price'];
        $total += $subtotal;    
      }*/
        $select_orders = $conn->prepare("SELECT * FROM `sales`");
         $select_orders->execute();
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
        
        
      //$date = DateTime::createFromFormat("d-M-Y",  $fetch_orders['placed_on']);

                /*if($date->format("m")==$m){
                    $x=$fetch_orders['total_price'];
                    
                }*/
                
            if($fetch_orders['year']==$year){
                
                if($fetch_orders['month']==$m){
                $x+=$fetch_orders['total'];
                }
            }
            }
         }
        array_push($sales, $x);
    }
    catch(PDOException $e){
      echo $e->getMessage();
    }

    $num = str_pad( $m, 2, 0, STR_PAD_LEFT );
    $month =  date('M', mktime(0, 0, 0, $m, 1));
    array_push($months, $month);
  }

  $months = json_encode($months);
  $sales = json_encode($sales);

?>
<!-- End Chart Data -->


 
<script>
  // === include 'setup' then 'config' above ===
  
  const data = {
    labels: <?php echo $months; ?>,
    datasets: [{
      label: 'Sales per month (RM)',
      data: <?php echo $sales; ?>,
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 99, 132, 0.2)'
      ],
      borderColor: [
        'rgb(255, 99, 132)',
        'rgb(255, 99, 132)',
        'rgb(255, 99, 132)',
        'rgb(255, 99, 132)',
        'rgb(255, 99, 132)',
        'rgb(255, 99, 132)',
        'rgb(255, 99, 132)',
        'rgb(255, 99, 132)',
        'rgb(255, 99, 132)',
        'rgb(255, 99, 132)',
        'rgb(255, 99, 132)',
        'rgb(255, 99, 132)'
      ],
      borderWidth: 1
    }]
  };

  const config = {
    type: 'bar',
    data: data,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  };

  var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>

   



</section>


<script>
$(function(){
  $('#select_year').change(function(){
    window.location.href = 'admin_sales.php?year='+$(this).val();
  });
});
</script>


<script src="../js/admin_script.js"></script>
   
</body>
</html>