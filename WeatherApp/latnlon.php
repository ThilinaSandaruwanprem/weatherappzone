<?php require_once('config.php'); ?>

<?php 

   session_start();
   if(!isset($_SESSION['userlogin'])){
      header("location: latnlon.php");
   }

   if(isset($_GET['logout'])){
      session_destroy();
      unset($_SESSION);
      header("location: login.php");
   }
 ?>


<?php
$lat="";
$lon="";

if (isset($_POST['submit'])) {
  $lat=$_POST['lat'];
  $lon=$_POST['lon'];
  $cache_file = 'data.json';

  $api_url = "https://api.openweathermap.org/data/2.5/onecall?&lat=$lat&lon=$lon&appid=49c0bad2c7458f1c76bec9654081a661&exclude=minutely,hourly,alerts";
  $data = file_get_contents($api_url);
  file_put_contents($cache_file, $data);
  $data = json_decode($data);

  $current = $data;
  $forecast = $data->daily;
}

?>


  

<html lang="en" class=" -webkit-">
   <head>
      <meta charset="UTF-8">
      <title>Weather Card</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="css/latnlon.css">
      
   </head>
   <body>

      <nav class="navbar navbar-dark bg-dark">
        <ul class="navbar-nav">
          <li class="nav-brand"><a href="index.php" class="navbar-brand">Colombo Weather</a></li>
          <li class="nav-brand"><a href="SearchWeather.php" class="navbar-brand">Search Weather using town or Country Name </a></li>
          <li class="nav-item"><a href="index.php?logout=true" class="nav-link">Logout </a></li>
        </ul>
      </nav>
      <br>
      <div class="container-fluid">
        <div class="container">
          <div class="row justify-content-md-center">
            <div class="form">
               <form style="width:100%;" method="post">
                  <div class="row justify-content-md-center">
                    <input type="text" class="text" placeholder="Enter latitude" name="lat" value="<?php echo $lat?>"/>
                    <input type="text" class="text" placeholder="Enter longitude" name="lon" value="<?php echo $lon?>"/>
                  </div>
                  <br><br>
                  <div class="row justify-content-md-center">
                    <input type="submit" value="Search" class="submit" name="submit"/>  
                  </div>    
               </form>
            </div>
          </div>
        </div>

        <?php if (isset($_POST['submit'])) { ?>
          <h3 class="title text-center bordered mb-5">
            Weather Report for <?php echo "Latitude : " .$current->lat."  ". "Latitude : ".$current->lon;?>    
          </h3>

          <div class="row justify-content-md-center">
            <div class="col-md-6">
              <div class="card border-dark mb-3">
                <div class="card-header">
                  <div class="row">
                      <div class="col-md-3">
                        <img src='<?php echo "http://openweathermap.org/img/wn/".$current->current->weather[0]->icon."@2x.png" ?>'>
                      </div>
                      <div class="col-md-9">
                        <h4><?php echo date('M-d', $current->current->dt); ?></h4>
                      </div>
                    </div>
                </div>
                <div class="card-body">
                  <p> 
                    <strong>Tempreture : </strong>
                    <?php echo $current->current->temp;?> °F
                  </p>
                  <p> 
                    <strong>Description : </strong>
                    <?php echo $current->current->weather[0]->description;?> 
                  </p>        
                  <div class="weather-icon">
                    <p>
                      <strong>Wind Speed : </strong>
                      <?php echo $current->current->wind_speed;?> 
                    </p>
                    <p>
                      <strong>Pressue : </strong>
                      <?php echo $current->current->pressure;?> 
                    </p>
                    <p>
                      <strong>Visibility : </strong>
                      <?php echo $current->current->visibility;?>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <h3 class="title text-center bordered mb-5">
            7 Days Weather Forecast for 
            <?php echo "Latitude : " . $current->lat."  "."Langitude : ".$current->lon;?>
          </h3>

          <div class="row">
            <?php 
              for($i=1; $i<8; $i++){
                $f=$forecast[$i];
            ?>

              <div class="col-md-3">
                <div class="card border-dark mb-3">
                  <div class="card-header">
                    <div class="row">
                      <div class="col-md-3">
                        <img src='<?php echo "http://openweathermap.org/img/wn/".$f->weather[0]->icon."@2x.png" ?>'>
                      </div>
                      <div class="col-md-9">
                        <h4><?php echo date('M-d', $f->dt); ?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div>
                      <strong>Tempreture (°F): </strong>
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">mrng</th>
                            <th scope="col">day</th>
                            <th scope="col">evng</th>
                            <th scope="col">nigt</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><?php echo $f->temp->morn ?></td>
                            <td><?php echo $f->temp->day ?></td>
                            <td><?php echo $f->temp->eve ?></td>
                            <td><?php echo $f->temp->night ?></td>
                          </tr>
                        </tbody>
                      </table> 
                    </div>
                    <div>
                      <strong>Feels Like (°F): </strong>
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">mrng</th>
                            <th scope="col">day</th>
                            <th scope="col">evng</th>
                            <th scope="col">nigt</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><?php echo $f->feels_like->morn ?></td>
                            <td><?php echo $f->feels_like->day ?></td>
                            <td><?php echo $f->feels_like->eve ?></td>
                            <td><?php echo $f->feels_like->night ?></td>
                          </tr>
                        </tbody>
                      </table> 
                    </div>                  
                    <p>
                      <strong>Min: </strong>
                      <?php echo $f->temp->min;?> °F - 
                      <strong>Max: </strong>
                      <?php echo $f->temp->max;?> °F
                    </p> 
                    <p>
                      <strong>Pressure: </strong>
                      <?php echo $f->pressure;?> 
                    </p> 
                    <p>
                      <strong>Description: </strong>
                      <?php echo $f->weather[0]->description;?> 
                    </p>
                    <p>
                      <strong>wind speed: </strong>
                      <?php echo $f->wind_speed;?> 
                    </p>
                  </div>
                </div> 
              </div>
            <?php } ?>                     
          </div>
        <?php } ?>
      </div>
  </body>
</html>
