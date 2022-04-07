<?php
session_start();
if ($_SESSION["login"] == NULL){

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

$fingerprint =  $_REQUEST['fingerprint'];
$browser = $_REQUEST['browser'];
$flash =  $_REQUEST['flash'];
$canvas = $_REQUEST['canvas'];
$connection = $_REQUEST['connection'];
$cookie =  $_REQUEST['cookie'];
$display = $_REQUEST['display'];
$fontsmoothing =  $_REQUEST['fontsmoothing'];
$fonts = $_REQUEST['fonts'];
$formfields = $_REQUEST['formfields'];
$java =  $_REQUEST['java'];
$language = $_REQUEST['language'];
$silverlight =  $_REQUEST['silverlight'];
$os = $_REQUEST['os'];
$timezone = $_REQUEST['timezone'];
$touch = $_REQUEST['touch'];
$truebrowser = $_REQUEST['truebrowser'];
$plugins = $_REQUEST['plugins'];
$useragent = $_REQUEST['useragent'];
$ip = $_REQUEST['ip'];
$provider = $_REQUEST['provider'];
$latitude = $_REQUEST['latitude'];
$longitude = $_REQUEST['longitude'];
$city = $_REQUEST['city'];
$country = $_REQUEST['country'];

// Performing insert query execution
// here our table name is college
$sql = "INSERT INTO info (fingerprint,
            browser,flash,canvas,connection,cookie,display,fontsmoothing,fonts
            ,formfields,java,language,silverlight,os,timezone,touch
            ,truebrowser,plugins,useragent,ip,provider,latitude,longitude,city,country)
        VALUES ('$fingerprint', 
            '$browser','$flash','$canvas','$connection','$cookie','$display','$fontsmoothing','$fonts'
            ,'$formfields','$java','$language','$silverlight','$os','$timezone','$touch'
            ,'$truebrowser','$plugins','$useragent','$ip','$provider','$latitude','$longitude','$city','$country')";

if(mysqli_query($con, $sql)){
} else{
    echo "ERROR: Hush! Sorry $sql. "
        . mysqli_error($con);
}

// Close connection
mysqli_close($con);
}
?>