<?php
require_once "include/include_db.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Projekt</title>
	<meta charset="UTF-8">
</head>
<body>
    <style> 
        body { background: #F99C40 ;} 
        .center {
        margin: auto;
        width: 20%;
        border: 5px solid #e5ff00;
        padding: 10px;
        } 
        div.a {
        text-align: center;
        }



    </style>
	<main>
    <div class="a">
	<?php
	//Hilfsvariablen
	$userName="";
	$email="";
	$password1="";
	$password2="";
	$zustimmung="";

	$ok=true;
	$bericht="";

	if(isset($_POST["absenden"]))
	{
		//Zuweisung an die Variablen
		$userName=strip_tags(  $_POST["userName"]  );//bereinigen
		$email=$_POST["email"];//wird ohnehin auf Email gechecked
		$password1=$_POST["password1"];//kommt später ohnehin in den "Fleischwolf"
		$password2=$_POST["password2"];
		
		//Prüfung ob AGB angehakt
		if(isset($_POST["zustimmung"]))
		{
			$zustimmung=$_POST["zustimmung"];
		}
		else
		{
			$ok=false;
			$bericht .= "Sie müssen den AGB zustimmen!<br>";
		}

		//Prüfung ob Email
		if(filter_var($email, FILTER_VALIDATE_EMAIL)===false)
		{
			$ok=false;
			$bericht .= "Keine gültige email!<br>";
		}
		else{
			//Prüfung ob Email existiert

			$sql = "SELECT * FROM users
			WHERE userEmail = :email";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":email",$email);
			$stmt->execute();
			$row = $stmt->fetch();
			//Falls Email vorhanden ist
			if($row !== false){
				$ok=false;
				$bericht .= "Email bereits vorhanden!<br>";
			}

		}

		//Prüfung PW Mind. 8 Zeichen hat
		if(strlen($password1) < 8)
		{
			$ok=false;
			$bericht .= "Das Passwort muss mind 8 Zeichen haben!<br>";
		}
		
		//Prüfung ob PW übereinstimmt
		if($password1<>$password2)
		{
			$ok=false;
			$bericht .= "Das Passwort stimmt nicht!<br>";
		}

		// Passwort-Check
		$muster1="/[A-Z]/";
		$muster2="/[a-z]/";
		$muster3="/[0-9]/";

		if(
		preg_match($muster1,$password1) && 
		preg_match($muster2,$password1) && 
		preg_match($muster3,$password1) 
		)
		{
			
		}
		else
		{
			$ok=false;
			$bericht .= "Das Passwort braucht Großbuchstabe, Kleinbuchstabe, Zahl<br>";		
		}

		//Wenn immer noch ok
		if($ok===true)
		{
			$bericht = "GRATULATION! Alles bestens!<br><a href='login.php'>zum Login</a>";
			//hier kommt dann der DB-Eintrag
			$options = ['cost' => 10];
			$password1 = password_hash($password1, PASSWORD_BCRYPT, $options);

			$sql = "INSERT INTO users
			(userName,userEmail,userPassword,userRole)
			VALUES
			(:userName,:userEmail,:userPassword,1)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":userName",$userName);
			$stmt->bindParam(":userEmail",$email);
			$stmt->bindParam(":userPassword",$password1);
			$stmt->execute();


			
			$userName="";
			$userVorname="";
			$email="";
			$password1="";
			$password2="";
			$zustimmung="";
			
		}

	}

	echo $bericht;
	?>
    </div>
    <hr>
    <p>
    <div class="center">
    <div class="a">
	<form action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]);   ?>" method="post">
	Ihr Username:<br>
	<input type="text" name="userName" value="<?php echo $userName; ?>"><br>
	email:<br>
	<input type="text" name="email" value="<?php echo $email; ?>"><br>
	<br>
	Passwort:<br>
	<input type="password" name="password1" value="<?php echo $password1; ?>"><br>
	<br>
	Passwort wiederholen:<br>
	<input type="password" name="password2" value="<?php echo $password2; ?>"><br>
	<br>

	<input type="checkbox" name="zustimmung" value="ok"<?php if($zustimmung=="ok") { echo "checked"; } ?>>ich stimme zu<br>

	<br>
	<input type="submit" name="absenden" value="absenden"><br>

	</form>
    </div>
    </div>
	</main>
</body>
</html>