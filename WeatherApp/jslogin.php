<?php 
session_start();
require_once('config.php'); 

$email = $_POST['email'];
$password = $_POST['password'];
$hash_password = sha1($password);


$sql = "SELECT * from users WHERE email = ? AND password = ? LIMIT 1";
$stmtselect = $db->prepare($sql);
$result = $stmtselect->execute([$email, $hash_password]);

if($result) {
	$user = $stmtselect->fetch(PDO::FETCH_ASSOC);
	if($stmtselect->rowCount() > 0){
		$_SESSION['userlogin'] = $user;
		echo '1';	
		}else {
			echo 'There no user for the combo';
	}

}else {
	echo 'There were errors while connecting to database.';
}

?>
