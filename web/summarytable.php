<?php
header("Content-Type: text/plain");
$matrix = array();
$level  = "G";

if(isset($_GET["level"])){
	$level = $_GET["level"];
}

// Read all the abundance files
echo("Taxon");
foreach( $_GET["table"] as $basename){
	echo("\t" . $basename);
	$file = fopen("metagenomics/" . $basename . "." . $level . ".abundance", "r");
	fgets($file);
	while( ($line = fgets($file)) !== false ){
		$line = rtrim($line);
		$fields = explode("\t", $line);
		$taxon  = $fields[0];
		$value  = $fields[6]; // maybe later we want another summary matrix. In this case I need to change only this index
		if( !array_key_exists($taxon, $matrix) ){
			$matrix[$taxon] = array();
		}
		$matrix[$taxon][$basename] = $value;
	}
	fclose($file);
}
echo("\n");

// Produce matrix
foreach( array_keys($matrix) as $taxon ){
	echo($taxon);
	foreach( $_GET["table"] as $sample ){
		echo("\t");
		if( array_key_exists($sample, $matrix[$taxon]) ){
			echo($matrix[$taxon][$sample]);
		}
		else {
			echo("0.0");
		}
	}
	echo("\n");
}

?>
