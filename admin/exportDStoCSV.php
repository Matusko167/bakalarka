<?php

$sname= "sql102.epizy.com";

$unmae= "epiz_30548035";

$password = "jNdZ73D4XOMEj";

$db_name = "epiz_30548035_bakalarka";

$con = mysqli_connect($sname, $unmae, $password, $db_name);


// Check connection
if($con === false){
    die("ERROR: Could not connect. "
        . mysqli_connect_error());
}

// get users list
$query = "SELECT * FROM info";
if (!$result = mysqli_query($con, $query)) {
    exit(mysqli_error($con));
}

$info = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $info[] = $row;
    }
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=info.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('id','fingerprint',	'browser',	'flash',	'canvas',	'connection',	'cookie'	,'display',	'fontsmoothing'	,
'fonts',	'formfields',	'java',	'language',	'silverlight',	'os'	,'timezone'	,'touch'	,'truebrowser',	'plugins',	'useragent',	'ip',	'provider'	,
'navsteva',	'latitude',	'longitude',	'city',	'country'));

if (count($info) > 0) {
    foreach ($info as $row) {
        fputcsv($output, $row);
    }
}
?>