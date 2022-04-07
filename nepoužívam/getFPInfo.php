<?php
$sname = "sql102.epizy.com";

$unmae = "epiz_30548035";

$password = "jNdZ73D4XOMEj";

$db_name = "epiz_30548035_bakalarka";


$con = mysqli_connect($sname, $unmae, $password, $db_name);

$sql = "SELECT id, fingerprint, browser, canvas, connection, java, language, os, timezone, touch, truebrowser, plugins, useragent 
FROM info WHERE id = ?";

$stmt = $con->prepare($sql);
$stmt->bind_param("s", $_GET['q']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $fingerprint, $browser, $canvas, $connection, $java, $language,$os,$timezone,$touch,$truebrowser,$plugins,$useragent);
$stmt->fetch();
$stmt->close();

$idk = mysqli_query($con, "select fingerprint from info where browser = $browser and canvas = $canvas and connection = $connection and java = $java
                                    and language = $language and os = $os and timezone = $timezone and touch = $touch and truebrowser = $truebrowser
                                    and plugins = $plugins and useragent = $useragent group by fingerprint");

$canvasC[0] = 0;
$pluginsC[0] = 0;
$useragentC[0] = 0;



echo "<table>";
echo "<tr>";
echo "<th class='bg-gray-500 p-2 text-xl border-black'>Fingerprint</th>";
echo "<td class='bg-gray-400 p-2 border-black'>" . $fingerprint . "</td>";
echo "</tr>";
echo "<tr>";
echo "<th class='bg-gray-500 p-2 text-xl border-black'>Všetko rovnaké len iný fingerprint</th>";
echo "<td class='bg-gray-400 p-2 border-black'>";

echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<th class='bg-gray-500 p-2 text-xl border-black'>Iné canvas</th>";
echo "<td class='bg-gray-400 p-2 border-black'>";

echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<th class='bg-gray-500 p-2 text-xl border-black'>Iný useragent</th>";
echo "<td class='bg-gray-400 p-2 border-black'>";

echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<th class='bg-gray-500 p-2 text-xl border-black'>Iné plugins</th>";
echo "<td class='bg-gray-400 p-2 border-black'>";

echo "</td>";
echo "</tr>";
echo "</table>";
?>