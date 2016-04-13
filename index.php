<?php
	session_start();
	include "config.php";
 	include "db_connect.php";
 	
	$rand=rand(10000,99999);
	if(!isset($_SESSION['telegramaccount'])) {
		$_SESSION['telegramaccount']=$rand;
	}
	else {
		$rand=$_SESSION['telegramaccount'];
		if(!isset($_COOKIE['user_series']) or $_COOKIE['user_series']=="") {	
			$getid = $db->query("SELECT username FROM `serien_user` WHERE rand LIKE '$rand'"); 
			$user_in=$getid->fetch_assoc()['username'];
			$getinfo_u = $db->query("SELECT id FROM `serien` WHERE name LIKE '$name'"); 
			$id = mysqli_fetch_assoc($getinfo_u)['id'];
			$insert = $db->query("INSERT INTO usersserie (id, user, e, s) VALUES ('$id', '$user', '0', '0')"); 
		 	setcookie('user_series', $user_in, time()+(3600*24*365));  
		}
	}

 	
 	if(isset($_POST['user']) and $_POST['pw'] == $pw) {
 		$user_in=$_POST['user'];
 		setcookie('user_series', $user_in, time()+(3600*24*365));  
 		header('Location: ./');
 	}
 	if(isset($_COOKIE['user_series']) and $_COOKIE['user_series']!="") {
		$user=$_COOKIE['user_series'];
		if(isset($_POST['name'])) {	
			$name=$_POST['name'];
			$s=$_POST['staf'];
			$e=$_POST['epi'];
			$insert = $db->query("INSERT INTO serien (smax, emax, name) VALUES ('$s', '$e', '$name')"); 
			header('Location: ./');
		}
		$getid = $db->query("SELECT `id` FROM `serien`"); 
		while($ids= mysqli_fetch_assoc($getid)) {
      	$getids[]=$ids['id'];
   	}
   }
?>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="icon" href="favicon.png">
		<link href="https://msn.ldkf.de/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://msn.ldkf.de/css/bootstrap-theme.min.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet">
		<title>Startseite</title>
	</head>
	<body style="font-family: ubuntu-m;">
		<div class="main" style="margin-left:0; padding-left:70px;">
		<?php
		
			if(isset($_COOKIE['user_series']) and $_COOKIE['user_series']!="") {
				echo'
			<h3>Neue Serie hinzufügen</h3>

			<form class="form-signin" method="post" action="">
				<input class="form-control" style="width:160px; margin-right:20px; float:left" name="name" placeholder="Serienname" autocomplete="off" required="yes">
				<input class="form-control" style="width:100px; margin-right:20px; float:left" name="staf" placeholder="Staffel" autocomplete="off" required="yes">
				<input class="form-control" style="width:100px; margin-right:20px; float:left" name="epi" placeholder="Episode" autocomplete="off" required="yes">
				<button class="btn btn-primary">Senden</button>					
			</form>';
			}
			else {
				echo'
				<h3>Login mit Telegram:</h3>
				<a href="https://telegram.me/ldkf_login_bot?start='. $rand .'" target="_blank">ldkf_login_bot</a>
				';
			}
			echo '<form class="form-signin" method="post" action="">';
				if(isset($_COOKIE['user_series']) and $_COOKIE['user_series']!="") {
					foreach($getids as $id){
						if(isset($_POST['e_'.$id])) {			
							$e=$_POST['e_'.$id];
							$s=$_POST['s_'.$id];
							
							$update = $db->query("UPDATE usersserie SET e = '$e', s ='$s' where id = '$id' and user LIKE '$user'");  
							header('Location: ./');
						}
						$getinfo = $db->query("SELECT smax , emax , name FROM `serien` WHERE id LIKE '$id'"); 
						$getinfo_u = $db->query("SELECT s , e FROM `usersserie` WHERE id LIKE '$id' and user LIKE '$user'");
						while($rows = mysqli_fetch_assoc($getinfo_u)) {
       					$s=$rows['s'];
       					$e=$rows['e'];
       				} 
						while($row = mysqli_fetch_assoc($getinfo)) {
       					$smax=$row['smax'];
       					$emax=$row['emax'];
							$name=$row['name'];
       				}
						if (strlen($name) < 17) {			
							echo '<div class="col-md-3 col-sd-4"';
						}
						else {
							echo '<div class="col-md-6 col-sd-8"';
						}
						echo' style="padding-left:0"><h3>'.$name.'</h3>';
						echo '
								<select name="s_'.$id.'" class="form-control" style="width:80px; margin-right:20px; float:left" autocomplete="off">';
						$i=1;
						while($i<=$smax) {
							if($i==$s) {
								echo '<option selected>'. $i ."</option>";
							}
							else {
								echo '<option>'. $i ."</option>";	
							}				
							$i++;	
						}
						$i=1;
						echo '</select><select name="e_'.$id.'" class="form-control" onchange="this.form.submit()" style="width:80px;" autocomplete="off">';
						while($i<=$emax) {
							if($i==$e) {
								echo '<option selected>'. $i ."</option>";
							}
							else {
								echo '<option>'. $i ."</option>";	
							}						
							$i++;	
						}
						echo '</select>';
						if (strlen($name) < 17) {			
							echo'	<hr ALIGN="LEFT" style="background: red; height: 2px; width:180px"></div>';
						}
						else{
							echo'	<hr ALIGN="LEFT" style="background: red; height: 2px; width:435px"></div>';
						}
					}
					echo '<br>
						<button class="btn btn-primary">Updaten</button>					
						</form>';		
				}
			?>
		</div>
      <script type="text/javascript" src="https://msn.ldkf.de/js/jquery-1.11.2.min.js"></script>
   	<script type="text/javascript" src="https://msn.ldkf.de/js/bootstrap.min.js"></script>
	</body>
</html> 