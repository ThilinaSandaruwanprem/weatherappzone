<?php require_once('config.php'); ?>
<?php 

	session_start();
	if(!isset($_SESSION['userlogin'])){
		header("location: index.php");
	}

	if(isset($_GET['logout'])){
		session_destroy();
		unset($_SESSION);
		header("location: login.php");
	}
?>



<?php
  $status="";
  $msg="";
  $city="";

  $city= 'colombo';
  $url="http://api.openweathermap.org/data/2.5/weather?q=$city&appid=49c0bad2c7458f1c76bec9654081a661";
  $ch=curl_init();
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  $result=curl_exec($ch);
  curl_close($ch);
  $result=json_decode($result,true);
  if($result['cod']==200){
      $status="yes";
  }else{
      $msg=$result['message'];
  }

?>

<html lang="en" class=" -webkit-">
   <head>
      <meta charset="UTF-8">
      <title>Weather Card</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="css/index.css">
      
   </head>
   <body >

    <nav class="navbar navbar-dark bg-dark">
        <ul class="navbar-nav">
          <li class="nav-brand"><a href="SearchWeather.php" class="navbar-brand">Search Weather using town or Country Name </a></li>
          <li class="nav-brand"><a href="latnlon.php" class="navbar-brand">Search Weather using Latitude and Longitude</a>
          <li class="nav-item"><a href="index.php?logout=true" class="nav-link">Logout </a></li>
        </ul>
    </nav>





    
      <div class="row container">       
         <form method="post">
            <label  class="label1"  name="city">Colombo </label>       
         </div>
      </div>
      
      <?php if($status=="yes"){?>
        <article class="widget">
         <div class="weatherIcon">
            <img src="http://openweathermap.org/img/wn/<?php echo $result['weather'][0]['icon']?>@4x.png"/>
         </div>
            <div class="weatherInfo">
              <div class="temperature">
                 <span><?php echo round($result['main']['temp']-273.15)?>°</span>
              </div>
              <div class="description mr45">
                 <div class="weatherCondition"><?php echo $result['weather'][0]['main']?></div>
                 <div class="place"><?php echo $result['name']?></div>
              </div>
              <div class="description">
                 <div class="weatherCondition">Wind</div>
                 <div class="place"><?php echo $result['wind']['speed']?> M/H</div>
              </div>
         </div>
           <div class="date">
              <?php echo date('d M',$result['dt'])?> 
               
           </div>
        </article>
      <?php } ?>
   </body>
</html>