<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link rel="stylesheet" href="design/css/base.css" type="text/css" />
<title>Quality control results</title>
</head>
<body>
<div id="maincontent">
<h1 class="color-primary-0">Sequence quality</h1>
<table>
<tr>
	<th>First pair</th>
	<th></th>
	<th>Second pair</th>
	<th></th>
</tr>
<?php

function fastqclink($filename) {
	$r =      '<a href="metagenomics/'.$filename.'_fastqc.html">';
	$r = $r . '<button>See</button>';
	$r = $r . '</a>';
	return($r);
}

$d = opendir("metagenomics");
$repstr = array("_R1_", "_R2_", "_fastqc.html");
$results = array();
while( ($f = readdir($d)) ==! false ){
	if(strrpos($f, "_fastqc.html") ==! false){
		$key = str_replace($repstr, "", $f);
		if(array_key_exists($key, $results) === false){
			$results[$key] = array("R1" => "", "R2" => "");
		}
		if(strrpos($f, "_R1_") ==! false){
			$results[$key]["R1"] = str_replace("_fastqc.html", "", $f);
		}
		else{
			$results[$key]["R2"] = str_replace("_fastqc.html", "", $f);
		}
	}
}
closedir($d);

foreach($results as $key => $value){
	echo "<tr>\n";
	echo "\t<td>" . $results[$key]["R1"]             . "</td>\n";
	echo "\t<td>" . fastqclink($results[$key]["R1"]) . "</td>\n";
	echo "\t<td>" . $results[$key]["R2"]             . "</td>\n";
	echo "\t<td>" . fastqclink($results[$key]["R2"]) . "</td>\n";
	echo "</tr>\n";
}
?>
</table>
</div>
</body>
</html>
