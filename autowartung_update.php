<?php
session_start();
session_regenerate_id(true);
//wenn user nicht angemeldet-Rauswurf
if( empty( $_SESSION["userID"] )  )
{
	header("location:logout.php");
}

require_once "include/include_db.php";
$arrayautoGruppen=["Limousine","Kombi","Kleinbus"];
//$_REQUEST hat alles von $_GET und $_POST
if( isset($_REQUEST["autoID"])){
    $autoID = (int)$_REQUEST["autoID"];

}else{
    exit("Kein Auto gewählt");
}
if( isset( $_POST["senden"] ) ){
    $autoName = strip_tags($_POST["autoName"]);
    $autoBild = strip_tags($_POST["autoBild"]);

    if($_FILES["datei"]["name"] !== ""){
        $dateiname = $_FILES["datei"]["name"];
        $endung = @end( explode(".",$dateiname) );
        $autoBild = time() . "." . strtolower($endung);

        $pfad = __DIR__;
        $ordner = "img";
        move_uploaded_file($_FILES["datei"]["tmp_name"],
        "$pfad/$ordner/$autoBild");
    }


    $autoGruppe = strip_tags($_POST["autoGruppe"]);

    $autoPreis = strip_tags($_POST["autoPreis"]);
    //Komma durch Punkt ersetzen
    $autoPreis = str_replace("," , ".", $autoPreis);
    $autoPreis = (float)$autoPreis;

    $autoBeschreibung = strip_tags($_POST["autoBeschreibung"]);
    $autoStatus = (isset( $_POST["autoStatus"]))? 1 : 0;

    $sql = "
    UPDATE autos SET
    autoName = :autoName,
    autoBild = :autoBild,
    autoGruppe = :autoGruppe,
    autoPreis = :autoPreis,
    autoBeschreibung = :autoBeschreibung,
    autoStatus = :autoStatus
    WHERE autoID = :autoID
    
    ";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":autoID",$autoID);
    $stmt->bindParam(":autoName",$autoName);
    $stmt->bindParam(":autoBild",$autoBild);
    $stmt->bindParam(":autoGruppe",$autoGruppe);
    $stmt->bindParam(":autoPreis",$autoPreis);
    $stmt->bindParam(":autoBeschreibung",$autoBeschreibung);
    $stmt->bindParam(":autoStatus",$autoStatus);
    $stmt->execute();

    //header("location:$_SERVER[PHP_SELF]");
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
        width: 11%;
        border: 5px solid #e5ff00;
        padding: 15px;
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
        <div class="a">
		<?php
		$sql = "SELECT * FROM autos
        WHERE autoID = :autoID";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":autoID",$autoID);
        $stmt->execute();
        //Keine Schleife, weil nur 1 Zeile
        $row = $stmt->fetch();

        echo "<h2>$row[autoName]</h2>";
        echo "<img src='img/$row[autoBild]' width='100'>";
        // ist zuständig für sachen hochladen
		?>
        <form method="post"
        enctype="multipart/form-data">

            Datei: <input type="file" name="datei"><br>

            autoID:<br>
            <input type="text" name="autoID" 
            value="<?php echo $row["autoID"]; ?>" readonly><br>

            autoBild:<br>
            <input type="text" name="autoBild"
            value="<?php echo $row["autoBild"]; ?>" readonly><br>

            autoName:<br>
            <input type="text" name="autoName"
            value="<?php echo $row["autoName"]; ?>"><br>
            
            autoGruppe:<br>
            <select name='autoGruppe'>
            <?php
            foreach ($arrayautoGruppen as $gruppe){
                $selected = ($gruppe ==$row["autoGruppe"])? "selected" : "";
                echo "<option $selected>$gruppe</option>";
            }
            ?>
            </select>";
            <br>
            autoPreis:<br>
            <input type="text" name="autoPreis"
            value="<?php echo number_format($row["autoPreis"],2,",","."); ?>"><br>

            autoBeschreibung:<br>
            <textarea name="autoBeschreibung"><?php echo $row ["autoBeschreibung"]; ?></textarea><br>
            autoStatus:<br>
            <input type="checkbox" name="autoStatus" <?php if($row ["autoStatus"]==1){echo "checked";} ?> ><br>


            <input type="submit" name="senden">
        </form>
        <a href="autowartung.php">zurück</a>
        </main>
        </div>
    </body>
</html>