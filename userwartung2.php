<?php
session_start();
session_regenerate_id(true);
//wenn user nicht angemeldet-Rauswurf
if( empty( $_SESSION["userID"] )  )
{
	header("location:logout.php");
}

require_once "include/include_db.php";

if( isset( $_POST["senden"] ) ){
    $userName = strip_tags($_POST["userName"]);
    $userEmail = strip_tags($_POST["userEmail"]);
    $userPassword = strip_tags($_POST["userPassword"]);
    $userRole = strip_tags($_POST["userRole"]);

    $sql = "
    INSERT INTO users
    (userName,userEmail,userPassword,UserRole,)
    VALUES
    (:userName,:userEmail,:userPassword,:UserRole)
    ";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":userName",$userName);
    $stmt->bindParam(":userEmail",$userEmail);
    $stmt->bindParam(":userPassword",$userPassword);
    $stmt->bindParam(":userRole",$userRole);
    $stmt->execute();

    header("location:$_SERVER[PHP_SELF]");

}

if(isset($_GET["delete"])){
    $userID = (int)$_GET["delete"];
    $sql="DELETE FROM users
    WHERE userID = :userID";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":userID",$userID);
    $stmt->execute();

    header("location:$_SERVER[PHP_SELF]");
}

?>
<!DOCTYPE html>
<html lang="de">
	<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>php-Kurs</title>
    </head>
    <body><style> 
        body { background: #F99C40 ;} 
        .left {
        margin: auto;
        width: 20%;
        border: 5px solid #e5ff00;
        padding: 10px;
        }
        div.a {
        text-align: center;
        }
        div.b {
        text-align: right;
        }
        </style>
        <main>
        <a href="mainpage_zeit&extras.php">Mieten</a>
        <div class="a">
        <?php
        echo "Hallo ".$_SESSION["userName"];
        echo "<br>";
		//Admins bekommen zusatzlink
		if($_SESSION["userRole"]==2)
		{
			echo "<a href='autowartung.php'>Auto Admin Dashboard </a>";
            echo "<a href='userwartung2.php'> User Admin Dashboard</a>";
		}
        
		?>
        </div>
        <div class="b">
        <a href="logout.php">abmelden</a>
        </div>
        
        <hr>
        <form method="post">
            userName:<br>
            <input type="text" name="UserName"><br>
            userEmail:<br>
            <input type="text" name="userEmail"><br>
            userPasswod:<br>
            <input type="text" name="userPassword"><br>
            userRole:<br>
            <input type="text" name="userRole"><br>

            <input type="submit" name="senden">
        </form>
        <hr>
		<?php
		$sql="SELECT * FROM users";

		$abfrage=$db->query($sql);

		while( $row = $abfrage->fetch() ){
            echo $row["userID"]." ".$row["userName"]." ";
            echo $row["userEmail"]." ".$row["userPassword"];
            echo $row["userRole"];
            echo "<a href='?delete=$row[userID]'>löschen</a> ";
            echo "<a href='userwartung_update.php?userID=$row[userID]'>ändern</a>";
            echo "<br>";
		}		
		?>
        </main>
    </body>
</html>