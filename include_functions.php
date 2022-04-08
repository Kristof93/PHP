<?php
function displaySelectArray($name,$array)
{
	$output="<select name='$name'>\n";
	$output.="<option>Treffen Sie eine Auswahl</option>\n";
	foreach($array as $element)
	{
		$output.="<option>$element</option>\n";
	}
	$output.="</select>\n";
	return $output;
}

function displaySelectArrayAssoziativ($name,$array)
{
	$output="<select name='$name'>\n";
	$output.="<option value=''>Treffen Sie eine Auswahl</option>\n";
	foreach($array as $key => $value)
	{
		$output.="<option value='$key'>$value</option>\n";
	}
	$output.="</select>\n";
	return $output;
}

function displayArtikel($name,$beschreibung,$preis)
{
	$output="<div style='border:3px solid red;border-radius:7px;margin:5px;padding:5px;'>";
	$output.="<h2>$name</h2>";
	$output.="<p>$beschreibung</p>";	
	$output.="<em>$preis</em>";	
	$output.="</div>";
	return $output;	
}


?>