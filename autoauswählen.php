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

<?php
$arrayautoGruppen=["Limousine","Kombi","Kleinbus"];

//Neuen Artikel anlegen
if( isset( $_POST["senden"] ) ){

    $autoBild = "Noimage.jpg";
    //Wenn ein Bild mitgeladen wurde
    if($_FILES["autoBild"]["name"] !== ""){
        $dateiname = $_FILES["autoBild"]["name"];
        $endung = end( explode(".",$dateiname) );
        $autoBild = time() . "." . strtolower($endung);

        $pfad = __DIR__;
        $ordner = "img";
        move_uploaded_file($_FILES["autoBild"]["tmp_name"],
        "$pfad/$ordner/$autoBild");
    }
    $autoName = strip_tags($_POST["autoName"]);
    $autoGruppe = strip_tags($_POST["autoGruppe"]);

    $autoPreis = strip_tags($_POST["autoPreis"]);
    //Komma durch Punkt ersetzen
    $autoPreis = str_replace("," , ".", $autoPreis);
    $autoPreis = (float)$autoPreis;

    $autoBeschreibung = strip_tags($_POST["autoBeschreibung"]);
    $autoStatus = (isset( $_POST["autoStatus"]))? 1 : 0;

    $sql = "
    INSERT INTO autos
    (autoName,autoGruppe,autoPreis,autoBeschreibung,autoStatus,autoBild)
    VALUES
    (:autoName,:autoGruppe,:autoPreis,:autoBeschreibung,:autoStatus,:autoBild)
    ";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":autoName",$autoName);
    $stmt->bindParam(":autoBild",$autoBild);
    $stmt->bindParam(":autoGruppe",$autoGruppe);
    $stmt->bindParam(":autoPreis",$autoPreis);
    $stmt->bindParam(":autoBeschreibung",$autoBeschreibung);
    $stmt->bindParam(":autoStatus",$autoStatus);
    $stmt->execute();

    header("location:$_SERVER[PHP_SELF]");

}//anlegen ENDE



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
        <div class="left">
        <div id="test">
        Preis:
        </div>
        <?php
        echo $_POST["summe"];
        ?>
        </div>
        <p>
        <div class="left">
		<?php
		$sql="SELECT * FROM autos ORDER BY autoID DESC";

		$abfrage=$db->query($sql);

		while( $row = $abfrage->fetch() ){
            echo "<img src='img/$row[autoBild]' width='100'>";
            echo $row["autoName"]." ";
            echo "<br>";
            echo $row["autoGruppe"]." ";
            echo "<br>";
            echo $row["autoBeschreibung"]." ";
            echo "<br>";
            echo $row["autoPreis"]." ";
            echo "<br>";
            echo "<a href='rechnung.php?autoID=$row[autoID]'>Wählen</a>";
            echo "<br>";
            echo "<br>";
		}		
		?>
    
        <a href="mainpage_zeit&extras.php">zurück</a>
        </div>
    </body>
</html>