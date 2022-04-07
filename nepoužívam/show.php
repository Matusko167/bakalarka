<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Bakalarka</title>
    <link rel="stylesheet" href="../style/style.css">
    <link href="https://fonts.googleapis.com/css?family=Courgette|Open+Sans&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/tailwind.css">



</head>
<body>

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
$uid = $_COOKIE['gfg'];


$result = mysqli_query($con,"select count(*) from info where fingerprint=$uid");

$array = $result->fetch_array();

$vsetky = mysqli_query($con,"select count(distinct(fingerprint)) from info");

$vsetkyArray = $vsetky->fetch_array();
?>



<div class="justify-center m-5 flex text-blue-200">
    <table class="shadow-lg justify-center content-center">

        <tr class="content-center">
            <?php if ($array[0] > 1) {
                ?>
                <th class="bg-gray-500 ring-1 ring-black p-2">Už si tu bol</th>
                <?php
                $datum = mysqli_query($con,"select navsteva from info where fingerprint = $uid AND id=(SELECT MAX(id) from info WHERE fingerprint = $uid)");

                $datumArray = $datum->fetch_array();
                ?>
                <th class="bg-gray-500 ring-1 ring-black p-2"> <?php echo "<div>" . $datumArray[0] . "</div>" ?> </th>
                <?php
            } else {
                ?>

                <th class="bg-gray-500 ring-1 ring-black p-2">Si tu nový</th>
                <?php
            }
                $zaznam = mysqli_query($con,"select * from info where fingerprint = $uid AND id=(SELECT MAX(id) from info WHERE fingerprint = $uid)");

                $zaznamArray = $zaznam->fetch_array();
            ?>
        </tr>
        <tr class="content-center">
            <td class="bg-gray-400 ring-1 ring-black p-2">Fingerprint: </td>
            <td class="bg-gray-400 ring-1 ring-black p-2"><?php echo "<div>" . $zaznamArray[1] . "</div>" ?></td>
        </tr>
        <tr class="content-center">
            <td class="bg-gray-400 ring-1 ring-black p-2">Browser: </td>
            <td class="bg-gray-400 ring-1 ring-black p-2"><?php echo "<div>" . $zaznamArray[2] . "</div>" ?></td>
            <td class="bg-gray-400 ring-1 ring-black p-2">Ako ty má rovnaký browser
                <?php
                $browser = mysqli_query($con,"select count(distinct(fingerprint)) from info where browser='$zaznamArray[2]'");

                $browserArray  = $browser->fetch_array();

                $browserPerc = ((100 / $vsetkyArray[0]) * $browserArray[0]);

                echo "<div>" . $browserPerc . "</div>" ?> %
            </td>
        </tr>
        <tr class="content-center">
            <td class="bg-gray-400 ring-1 ring-black p-2">OS: </td>
            <td class="bg-gray-400 ring-1 ring-black p-2"><?php echo "<div>" . $zaznamArray[14] . "</div>" ?></td>
            <td class="bg-gray-400 ring-1 ring-black p-2">Ako ty má rovnaký OS
                <?php
                $os = mysqli_query($con,"select count(distinct(fingerprint)) from info where os='$zaznamArray[14]'");

                $osArray  = $os->fetch_array();

                $osPerc = ((100 / $vsetkyArray[0]) * $osArray[0]);

                echo "<div>" . $osPerc . "</div>" ?> %
            </td>
        </tr>
        <tr class="content-center">
            <td class="bg-gray-400 ring-1 ring-black p-2">Jazyk: </td>
            <td class="bg-gray-400 ring-1 ring-black p-2"><?php echo "<div>" . $zaznamArray[12] . "</div>" ?></td>
            <td class="bg-gray-400 ring-1 ring-black p-2">Ako ty má rovnaký jazyk
                <?php
                $jazyk = mysqli_query($con,"select count(distinct(fingerprint)) from info where language='$zaznamArray[12]'");

                $jazykArray  = $jazyk->fetch_array();

                $jazykPerc = ((100 / $vsetkyArray[0]) * $jazykArray[0]);

                echo "<div>" . $jazykPerc . "</div>" ?> %
            </td>
        </tr>
        <tr class="content-center">
            <td class="bg-gray-400 ring-1 ring-black p-2">True Browser: </td>
            <td class="bg-gray-400 ring-1 ring-black p-2"><?php echo "<div>" . $zaznamArray[17] . "</div>" ?></td>
            <td class="bg-gray-400 ring-1 ring-black p-2">Ako ty má rovnaký True Browser
                <?php
                $tbrowser = mysqli_query($con,"select count(distinct(fingerprint)) from info where truebrowser='$zaznamArray[17]'");

                $tbrowserArray  = $tbrowser->fetch_array();

                $tbrowserPerc = ((100 / $vsetkyArray[0]) * $tbrowserArray[0]);

                echo "<div>" . $tbrowserPerc . "</div>" ?> %
            </td>
        </tr>
        <tr class="content-center">
            <td class="bg-gray-400 ring-1 ring-black p-2">Provider: </td>
            <td class="bg-gray-400 ring-1 ring-black p-2"><?php echo "<div>" . $zaznamArray[21] . "</div>" ?></td>
            <td class="bg-gray-400 ring-1 ring-black p-2">Ako ty má rovnakého providera
                <?php
                $provider = mysqli_query($con,"select count(distinct(fingerprint)) from info where provider='$zaznamArray[21]'");

                $providerArray  = $provider->fetch_array();

                $providerPerc = ((100 / $vsetkyArray[0]) * $providerArray[0]);

                echo "<div>" . $providerPerc . "</div>" ?> %
            </td>
        </tr>
        <tr class="content-center">
            <td class="bg-gray-400 ring-1 ring-black p-2">Touch screen: </td>
            <td class="bg-gray-400 ring-1 ring-black p-2"><?php echo "<div>" . $zaznamArray[16] . "</div>" ?></td>
            <td class="bg-gray-400 ring-1 ring-black p-2">Ako ty má touch screen
                <?php
                $touch = mysqli_query($con,"select count(distinct(fingerprint)) from info where touch='$zaznamArray[16]'");

                $touchArray  = $touch->fetch_array();

                $touchPerc = ((100 / $vsetkyArray[0]) * $touchArray[0]);

                echo "<div>" . $touchPerc . "</div>" ?> %
            </td>
        </tr>
        <tr class="content-center">
            <td class="bg-gray-400 ring-1 ring-black p-2">
        <a class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded" href="../index.php" ">back</a>
            </td>
        </tr>
    </table>
</div>

<div class="justify-center m-5 flex text-blue-200">
    <table class="shadow-lg justify-center content-center">
        <tr class="content-center">
            <th class="bg-gray-500 ring-1 ring-black p-2">
                <a class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded" href="show.php" ">Show info</a>
            </th>
        </tr>
    </table>
</div>
<?php
mysqli_close($con);

?>
</body>
</html>