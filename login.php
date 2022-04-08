<?php
session_start();
session_regenerate_id(true);

require_once "include/include_db.php";

if(isset( $_POST["senden"])){
    if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) !==false){
			$sql = "SELECT * FROM users
			WHERE userEmail = :email";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":email",$_POST["email"]);
			$stmt->execute();
			$row = $stmt->fetch();
			//Falls Email vorhanden ist
			if($row !== false){
				//Wenn user erkannt, Passwort abgleichen
                if(password_verify($_POST["password"],$row["userPassword"])){
                    //User erkannt, Passwort OK
                    //Session befüllt
                    $_SESSION["userID"] = $row["userID"];
                    $_SESSION["userName"] = $row["userName"];
                    $_SESSION["userRole"] = $row["userRole"];
                    //weiterleiten, nur wenn noch kein html-Output
                    header("location:mainpage_zeit&extras.php");
                }
				
			}	
		}
}

?>
<!DOCTYPE html>
<html lang="de">
	<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>php-Kurs</title>
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
		<div class="center">
                <div class="a">
        <form method="post">
            Email: <br>
            <input type="email" name="email" id="email" > <br>
            Password: <br>
            <input type="password" name="password" id="password" >
            <br>
            <p>
            <input type="submit" name="senden" id="senden" >
            <br>
            <p>
                Noch kein Mitglied?
                <br>
                <button type="submit" formaction="registrierung.php">Registrieren</button>


        </form>
        </div>
        </div>
        </main>
    </body>
</html>