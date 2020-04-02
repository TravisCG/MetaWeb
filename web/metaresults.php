<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link rel="stylesheet" href="design/css/base.css" type="text/css" />
<title>Metagenomics results</title>
</head>
<body>
<div id="maincontent">
<h1 class="color-primary-0">Taxonomical categories</h1>
<form action="summarytable.php">
<table>
	<tr>
		<th>Select</th>
		<th>Name</th>
		<th>Abundance estimation (Genus level)</th>
		<th>Bracken report</th>
		<th>Kraken report</th>
	</tr>
<?php
$d = opendir("metagenomics");
while( ($f = readdir($d)) ==! false ){
	if(strrpos($f, "_bracken.report") !== false){
		$basename = str_replace("_bracken.report", "", $f);
		print("\t<tr>\n");

		print("\t\t<td>");
		print('<input type="checkbox" name="table[]" title="Select it to include into the matrix" value="' . $basename . '">');
		print("</td>\n");

		print("\t\t<td>");
		print($basename);
		print("</td>\n");

		print("\t\t<td>");
		print('<a href="metagenomics/' . $basename . ".G.abundance" . '">View</a>');
		print("</td>\n");

		print("\t\t<td>");
		print('<a href="metagenomics/' . $basename . "_bracken.report" . '">View</a>');
		print("</td>\n");

		print("\t\t<td>");
		print('<a href="metagenomics/' . $basename . ".report" . '">View</a>');
		print("</td>\n");

		print("\t</tr>\n");
	}
}
closedir($d);
?>
</table>
Please select the taxonomical level:
<select name="level" >
	<option value="G">Genus</option>
	<option value="F">Family</option>
	<option value="P">Phylum</option>
</select>
<input type="submit" value="Download matrix" />
</form>
</div>
</body>
</html>
