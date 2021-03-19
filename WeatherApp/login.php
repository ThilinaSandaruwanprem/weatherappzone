<?php require_once('config.php'); ?>
<?php 
	session_start();
	if(isset($_SESSION['userlogin'])){
		header("location: index.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Weather Web Application</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="css/global.css">
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container-fluid bg">
		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-12"></div>
			<div class="col-md-4 col-sm-4 col-xs-12">	
			<!-- form start -->
			<form class="form-container bg-light" method="POST">
				<h1>Login Form</h1>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Email</label>
				    <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputPassword1">Password</label>
				    <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
				  </div>
				  <div class="checkbox">
				    <label>
				      <input type="checkbox"> Remember me
				    </label>
				  </div>
				  <button type="submit" class="btn btn-success btn-block" id="login">Login</button>
			</form>

			<!-- form end -->
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12"></div>
		</div>
	</div>

	<script
	  src="https://code.jquery.com/jquery-3.3.1.min.js"
	  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	  crossorigin="anonymous">
	</script>
	<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js">
	</script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10">
	</script>

	
	<script>
		$(function(){
			$('#login').click(function(e){
					var valid = this.form.checkValidity();

					if(valid){
						var email = $('#email').val();
						var password = $('#password').val();
					}

					e.preventDefault();

					$.ajax({
						type: 'POST',
						url: 'jslogin.php',
						data: {email: email, password: password},
						success: function(data){
													
							if($.trim(data) === "1"){

								Swal.fire({
							  position: 'middle',
							  icon: 'success',
							  title: 'Loging Successfully',
							  showConfirmButton: false,
							  timer: 5000
							})
								

								setTimeout(' window.location.href = "index.php"', 2000);
							}
						},
						error: function(data){
							alert('there were errors while doing the operation. ');
						}
					});
			});
		});
	</script>
</body>
</html>