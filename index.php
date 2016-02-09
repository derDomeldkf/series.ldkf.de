<?php
	include "config.php";
 	include "db_connect.php";
 	if(isset($_POST['user'])) {
 		$user_in=$_POST['user'];
 		setcookie('user_series', $user_in, time()+(3600*24*365));  
 	}
 	if(isset($_COOKIE['user_series']) and $_COOKIE['user_series']!="") {
		$user=$_COOKIE['user_series'];
		if(isset($_POST['name'])) {	
			$name=$_POST['name'];
			$s=$_POST['staf'];
			$e=$_POST['epi'];
			$insert = $db->query("INSERT INTO serien (smax, emax, s, e, name, user) VALUES ('$s', '$e', '0', '0', '$name', '$user')"); 
			header('Location: ./');
		}
		$getid = $db->query("SELECT `id` FROM `serien` WHERE user LIKE '$user'"); 
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
				<h3>Registrierung/Anmeldung</h3>
				<form class="form-signin" method="post" action="">
					<input class="form-control" style="width:160px; margin-right:20px; float:left" name="user" type="text" placeholder="Benutzername" autocomplete="off" required="yes">
					<input class="form-control" style="width:100px; margin-right:20px; float:left" name="pw" type="password" placeholder="Passwort" autocomplete="off" required="yes">
				<button class="btn btn-primary">Senden</button>					
				</form>';
			}
			echo '<form class="form-signin" method="post" action="">';
				if(isset($_COOKIE['user_series']) and $_COOKIE['user_series']!="") {
					foreach($getids as $id){
						if(isset($_POST['e_'.$id])) {			
							$e=$_POST['e_'.$id];
							$s=$_POST['s_'.$id];
							$update = $db->query("UPDATE serien SET e = '$e', s ='$s' where id = '$id' and user LIKE '$user' ");  
							header('Location: ./');
						}
						$getinfo = $db->query("SELECT smax , emax , s , e , name FROM `serien` WHERE id LIKE '$id' and user LIKE '$user'"); 
						while($row = mysqli_fetch_assoc($getinfo)) {
       					$smax=$row['smax'];
       					$emax=$row['emax'];
							$s=$row['s'];
							$e=$row['e'];
							$name=$row['name'];
       				}
										
						echo '<div class="col-md-3 col-sd-4" style="padding-left:0"><h3>'.$name.'</h3>';
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
						echo '</select><select name="e_'.$id.'" class="form-control" style="width:80px;" autocomplete="off">';
						while($i<=$emax) {
							if($i==$e) {
								echo '<option selected>'. $i ."</option>";
							}
							else {
								echo '<option>'. $i ."</option>";	
							}						
							$i++;	
						}
						echo '</select>
						<hr ALIGN="LEFT" style="background: red; height: 2px; width:180px"></div>';
					}
					echo '<br>
						<button class="btn btn-primary">Senden</button>					
						</form>';		
				}
			?>
		</div>
      <script type="text/javascript" src="https://msn.ldkf.de/js/jquery-1.11.2.min.js"></script>
   	<script type="text/javascript" src="https://msn.ldkf.de/js/bootstrap.min.js"></script>
	</body>
</html> 