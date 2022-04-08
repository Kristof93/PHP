<?php
require_once "include/include_db.php";

if( isset($_REQUEST["userID"])){
    $userID = (int)$_REQUEST["userID"];

}else{
    exit("Kein User gewählt");
}
if( isset( $_POST["senden"] ) ){
    $userName = strip_tags($_POST["userName"]);
    $userEmail = strip_tags($_POST["userEmail"]);
    $userPassword = strip_tags($_POST["userPassword"]);
    $userRole = strip_tags($_POST["userRole"]);

    $sql = "
    UPDATE users SET
    userName = :userName,
    userEmail = :userEmail,
    userPassword = :userPassword,
    userRole = :userRole
    WHERE userID = :userID
    ";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(":userID",$userID);
    $stmt->bindParam(":userName",$userName);
    $stmt->bindParam(":userEmail",$userEmail);
    $stmt->bindParam(":userPassword",$userPassword);
    $stmt->bindParam(":userRole",$userRole);
    $stmt->execute();
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
        <main>
		<?php
		$sql = "SELECT * FROM users
        WHERE userID = :userID";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":userID",$userID);
        $stmt->execute();
        $row = $stmt->fetch();

        echo "<h2>$row[userName]</h2>";

		?>
        <form method="post">
            userID:<br>
            <input type="text" name="userID" 
            value="<?php echo $row["userID"]; ?>" readonly><br>
            userName:<br>
            <input type="text" name="UserName"
            value="<?php echo $row["userName"]; ?>"><br>
            userEmail:<br>
            <input type="text" name="userEmail"
            value="<?php echo $row["userEmail"]; ?>"><br>
            userPasswod:<br>
            <input type="text" name="userPassword"
            value="<?php echo $row["userPassword"]; ?>"><br>
            userRole:<br>
            <input type="text" name="userRole"
            value="<?php echo $row["userRole"]; ?>"><br>
            <input type="submit" name="senden">
        </form>
        <a href="userwartung2.php">zurück</a>
        </main>
    </body>
</html>