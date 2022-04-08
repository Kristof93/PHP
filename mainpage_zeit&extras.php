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
        <title>javascript</title>
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
            <div class="center">
                <div class="a">
            <h2>AV Autovermietung</h2>
            <form action="" method="post" name="buchung">
                <input type="date" name="start" id="startDate" value="2022-03-28"> <!-- Date -->
                <input type="date" name="ende" id="endDate" value="2022-03-29"> <!-- Date -->
                <hr>
                <input type="time" name="tstart" id="startTime" value="12:00"> <!-- Time -->
                <input type="time" name="tende" id="endTime" value="12:00"> <!-- Time -->
                <hr>
                <select name="location" id="location">
                    <option value="leer">Ort suchen</option>
                    <option value="wienmitte">Wien Mitte</option>
                    <option value="hauptbahnhof">Wien Hauptbahnhof</option>
                    <option value="westbahnhof">Wien Westbahnhof</option>
                </select>
            </div> <!-- ende: <div class="a"> (Text Center) -->
                <hr>
                <input type="checkbox" name="kette" id="kette">Schneekette 15 Euro/Tag
                <hr>
                <input type="checkbox" name="gps" id="gps">GPS 10 Euro/Tag
                <hr>
                <input type="checkbox" name="fahrer" id="fahrer">Zusatzfahrer 12 Euro/Tag
                <hr>
                <input type="checkbox" name="sitz" id="sitz">Kindersitz 13 Euro/Tag
                <hr>

            </form>
            <form action="autoauswählen.php" method="post">
                <input type="text" name="summe" id="summe"> <br>
                <input type="submit" name="" value="">
            </form>
            <div id="test">
                Tage: <span id="tage"></span>
                <br>
                Preis: <span id="gesamt"></span>
            </div>
        </div> <!-- ende: <div class="center"> (Border Center) -->
    
        </main>
		<script>
		"use strict"
            const kette = document.getElementById("kette");//checkbox
            const gps = document.getElementById("gps");//checkbox
            const fahrer = document.getElementById("fahrer");//checkbox
            const sitz = document.getElementById("sitz");//checkbox
            const start = document.getElementById("startDate");//checkbox date
            const end = document.getElementById("endDate");//checkbox date
            const tstart = document.getElementById("startTime");//checkbox time
            const tend = document.getElementById("endTime");//checkbox time
            
            
            function differenceInDays(){
                let startDate = new Date(start.value);
                let endDate = new Date(end.value);
                //math.abs() -> gibt den absuluten Wert einer Zahl zurück
                let timeDiff = Math.abs(endDate - startDate);
                let diffDays = Math.round(timeDiff/(1000*3600*24));

                if(startDate >= endDate){
                    diffDays = 0;
                }

                return diffDays;
            }

            function getKettenPreis(){
                let kettenpreis = 0;
                if(kette.checked === true){
                    kettenpreis =  15;
                }
                kettenpreis *= differenceInDays();
                return kettenpreis;
            }

            function getgpsnPreis(){
                let gpsnpreis = 0;
                if(gps.checked === true){
                    gpsnpreis =  10;
                }
                gpsnpreis *= differenceInDays();
                return gpsnpreis;
            }

            function getfahrernPreis(){
                let fahrernpreis = 0;
                if(fahrer.checked === true){
                    fahrernpreis =  12;
                }
                fahrernpreis *= differenceInDays();
                return fahrernpreis;
            }

            function getsitznPreis(){
                let sitznpreis = 0;
                if(sitz.checked === true){
                    sitznpreis =  13;
                }
                sitznpreis *= differenceInDays();
                return sitznpreis;
            }

            function gesamt(){
                let gesamtpreis = 0;
                //Wird über "Hilfsfunktionen" berechnet
                gesamtpreis = getKettenPreis() + getgpsnPreis() + getsitznPreis() + getfahrernPreis();
                //Ausgabe
                document.getElementById("tage").textContent = differenceInDays();
                document.getElementById("gesamt").textContent = gesamtpreis;
                document.getElementById("summe").value = gesamtpreis;
                document.getElementById("tage").value = gesamtpreis;
            }
            

            //allen Elementen des Formulars wird ein Eventlistener mitgegeben
            for(let i = 0; i < document.buchung.length; i++){
                document.buchung.elements[i].onchange = gesamt;
            }
            

            //Heutiger Tag als Wert
            start.valueAsDate = new Date();
            //Zukünftiges Datum
            let date = new Date();
            date.setDate(date.getDate() + 1);
            let futuredate = date.toISOString();
            let result = futuredate.substring(0,10);
            end.value = result;
		</script>
        <p>
        <div class="a">
        <a href="autoauswählen.php">Auto auswählen</a><br>
        </div>
    </body>
</html>