<?php
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
        <main>
		<?php
		echo $row["autoName"]." ";
        echo "<h1>$row['autoName']</h1>\n";
		?>
        </main>
    </body>
</html>