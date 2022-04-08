<?php
session_start();
session_regenerate_id(true);
//wenn user nicht angemeldet-Rauswurf
if( empty( $_SESSION["userID"] )  )
{
	header("location:logout.php");
}
require_once "include/include_db.php";
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
		<?php
        
		?>
        <a href="mainpage_zeit&extras.php">zurück</a>
        </main>
    </body>
</html>