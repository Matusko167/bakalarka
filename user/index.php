<?php
session_start();
if (!$_COOKIE['Test']) {
    $refresh_period = 2; //8h = 28800s, 12h = 43200s, 24h = 86400s
    header("Refresh:$refresh_period; url=http://webmatus.rf.gd/");
}
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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js"
            type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js"
            type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"
            type="text/javascript" charset="utf-8"></script>


</head>
<body>
<?php
if (!$_COOKIE['Test']) {
    ?>
    <div class="start">
        <h1 class="Hlogo1">
            <span class="Hlogo">LOADING</span>
        </h1>
    </div>
    <script src="../js/loadingFav.js"></script>
    <?php
}
?>


<script src="../js/FP2.7.js"></script>


<?php

if ($_SESSION["login"] == NULL) {
?>


<a class="bg-gray-600 hover:bg-gray-400 text-black font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-500 rounded p-10 m-5" href="login.php">Login</a>



<?php }
if ($_SESSION["login"] == true) { ?>

    <a class="bg-gray-600 hover:bg-gray-400 text-black font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-500 rounded p-10 m-5 top-4" href="logout.php" ">Logout</a>
    <a class="bg-gray-600 hover:bg-gray-400 text-black font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-500 rounded p-10 m-5 top-4" href="../admin/admin.php" ">admin</a>


<?php } ?>



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

    $zaznam = mysqli_query($con, "select * from info where fingerprint = $uid AND id=(SELECT MAX(id) from info WHERE fingerprint = $uid)");
    $zaznamArray = $zaznam->fetch_array();

    setcookie("Test", true, time() + 3900);

    $coords = mysqli_query($con, "select fingerprint,latitude,longitude from info where latitude is not null and city is not null group by ip DESC LIMIT 5");

    ?>


<div class="justify-center m-5 flex text-black border-black">
    <table class="shadow-lg justify-center content-center">
        <tr class="content-center">
            <?php if ($array[0] > 1) {
                ?>
                <?php
                $datum = mysqli_query($con,"select navsteva from info where fingerprint = $uid order by id DESC LIMIT 1,1;");

                $datumArray = $datum->fetch_array();
                ?>
                <caption class="bg-gray-500 p-2 text-xl border-black font-bold"><bold>Už si tu bol </bold> <?php echo "<div>" . $datumArray[0] . "</div>" ?></caption>
                <?php
            } else {
                ?>
                <caption class="bg-gray-500 p-2 text-xl border-black font-bold"><bold>Si tu nový</bold></caption>
                <?php
            }
            ?>
        </tr>
        <tr class="content-center">
            <td class="bg-gray-500 p-2 border-black font-bold">Fingerprint: </td>
            <td class="bg-gray-400 p-2 border-black"><?php echo "<div>" . $zaznamArray[1] . "</div>" ?></td>
        </tr>
        <tr class="content-center ">
            <td class="bg-gray-500 p-2 border-black font-bold">Tvoja IP adresa: </td>
            <td class="bg-gray-400 p-2 border-black"><?php echo "<div>" . $zaznamArray[20] . "</div>" ?></td>
        </tr>
    </table>
</div>

    <div class="justify-center m-5 flex text-black border-black">
        <table class="shadow-lg justify-center content-center">
            <tr class="content-center ">
                <td class="bg-gray-500 p-2 border-black font-bold">Browser: </td>
                <td class="bg-gray-400 p-2 border-black"><?php echo "<div>" . $zaznamArray[2] . "</div>" ?></td>
                <td class="bg-gray-400 p-2 border-black">Ako ty má rovnaký browser
                    <?php
                    $browser = mysqli_query($con,"select count(distinct(fingerprint)) from info where browser='$zaznamArray[2]'");

                    $browserArray  = $browser->fetch_array();

                    $browserPerc = ((100 / $vsetkyArray[0]) * $browserArray[0]);

                    echo "<div>" . round($browserPerc,2) . "% </div>" ?>
                </td>
            </tr>
            <tr class="content-center ">
                <td class="bg-gray-500 p-2 border-black font-bold">OS: </td>
                <td class="bg-gray-400 p-2 border-black"><?php echo "<div>" . $zaznamArray[14] . "</div>" ?></td>
                <td class="bg-gray-400 p-2 border-black">Ako ty má rovnaký OS
                    <?php
                    $os = mysqli_query($con,"select count(distinct(fingerprint)) from info where os='$zaznamArray[14]'");

                    $osArray  = $os->fetch_array();

                    $osPerc = ((100 / $vsetkyArray[0]) * $osArray[0]);

                    echo "<div>" . round($osPerc,2) . "% </div>" ?>
                </td>
            </tr>
            <tr class="content-center">
                <td class="bg-gray-500 p-2 border-black font-bold">Jazyk:</td>
                <td class="bg-gray-400 p-2 border-black"><?php echo "<div>" . $zaznamArray[12] . "</div>" ?></td>
                <td class="bg-gray-400 p-2 border-black">Ako ty má rovnaký jazyk
                    <?php
                    $jazyk = mysqli_query($con,"select count(distinct(fingerprint)) from info where language='$zaznamArray[12]'");

                    $jazykArray  = $jazyk->fetch_array();

                    $jazykPerc = ((100 / $vsetkyArray[0]) * $jazykArray[0]);

                    echo "<div>" . round($jazykPerc,2) . "% </div>" ?>
                </td>
            </tr>
            <tr class="content-center ">
                <td class="bg-gray-500 p-2 border-black font-bold">True Browser:</td>
                <td class="bg-gray-400 p-2 border-black"><?php echo "<div>" . $zaznamArray[17] . "</div>" ?></td>
                <td class="bg-gray-400 p-2 border-black">Ako ty má rovnaký True Browser
                    <?php
                    $tbrowser = mysqli_query($con,"select count(distinct(fingerprint)) from info where truebrowser='$zaznamArray[17]'");

                    $tbrowserArray  = $tbrowser->fetch_array();

                    $tbrowserPerc = ((100 / $vsetkyArray[0]) * $tbrowserArray[0]);

                    echo "<div>" . round($tbrowserPerc,2) . "% </div>" ?>
                </td>
            </tr>
            <tr class="content-center ">
                <td class="bg-gray-500 p-2 border-black font-bold">Touch screen: </td>
                <td class="bg-gray-400 p-2 border-black"><?php echo "<div>" . $zaznamArray[16] . "</div>" ?></td>
                <td class="bg-gray-400 p-2 border-black">Ako ty má touch screen
                    <?php
                    $touch = mysqli_query($con,"select count(distinct(fingerprint)) from info where touch='$zaznamArray[16]'");

                    $touchArray  = $touch->fetch_array();

                    $touchPerc = ((100 / $vsetkyArray[0]) * $touchArray[0]);

                    echo "<div>" . round($touchPerc,2) . "% </div>" ?>
                </td>
            </tr>
            <tr class="content-center ">
                <td class="bg-gray-500 p-2 border-black font-bold">Provider: </td>
                <td class="bg-gray-400 p-2 border-black"><?php echo "<div>" . $zaznamArray[21] . "</div>" ?></td>
                <td class="bg-gray-400 p-2 border-black">Ako ty má rovnakého providera
                    <?php
                    $provider = mysqli_query($con,"select count(distinct(fingerprint)) from info where provider='$zaznamArray[21]'");

                    $providerArray  = $provider->fetch_array();

                    $providerPerc = ((100 / $vsetkyArray[0]) * $providerArray[0]);

                    echo "<div>" . round($providerPerc,2) . "% </div>" ?>
                </td>
            </tr>

        </table>
    </div>



<div class="justify-center m-5 flex text-black border-black flex-row">

    <table class="shadow-lg justify-center content-center">
        <caption class="bg-gray-500 p-2 text-xl border-black font-bold">Približné info posledných pripojených IP adries </caption>
        <?php
        $cities = mysqli_query($con,"select * from info where country is not null group by fingerprint DESC LIMIT 5");

        while($row = $cities->fetch_assoc()) {
        ?>
        <tr class="content-center">
            <th class="bg-gray-400 p-2 border-black text-xl"> <?php echo "<div>" . $row['ip'] . "</div>" ?></th>
            <th class="bg-gray-400 p-2 border-black text-xl"> <?php echo "<div>" . $row['country'] . "</div>" ?></th>
            <th class="bg-gray-400 p-2 border-black text-xl"> <?php echo "<div>" . $row['city'] . "</div>" ?></th>
        </tr>

        <?php
            }
        ?>

    </table>
</div>
<div style="width: 600px; height: 350px; display: block;
  margin-left: auto;
  margin-right: auto;
  " id="mapContainer"></div>


</body>
<footer class="px-4 py-8 text-gray-400 bg-gray-800">
    <div class="container flex flex-wrap items-center justify-center mx-auto space-y-4 sm:justify-between sm:space-y-0">
        <p class="text-2xl">
            Táto stránka slúži ako bakalárska práca, pomocou ktorej vieme získať informácie o danom užívateľovi bez toho, aby nám niečo posielal.
            Na obrazovke vidíte základné informácie, ktoré sme o vás získali.
        </p>
    </div>

</footer>

<script type="text/javascript">



    /**
     * Adds markers to the map highlighting the locations of the captials of
     * France, Italy, Germany, Spain and the United Kingdom.
     *
     * @param  {H.Map} map      A HERE Map instance within the application
     */
    function addMarkersToMap(map) {
        <?php while($row = $coords->fetch_assoc()){
        ?>  var x = new H.map.DomMarker({lat:<?php echo $row['latitude'] ?>, lng:<?php echo $row['longitude'] ?>});
        map.addObject(x);  <?php
        }?>
    }



    /**
     * Boilerplate map initialization code starts below:
     */

        //Step 1: initialize communication with the platform
        // In your own code, replace variable window.apikey with your own apikey
    var platform = new H.service.Platform({
            apikey: 'Z8Qdabz3pmgKsfNn1Xfa1mFpqapj5n3rEUhSJxWqBCY'
        });

    // Obtain the default map types from the platform object:
    var defaultLayers = platform.createDefaultLayers();

    // Instantiate (and display) a map object:
    var map = new H.Map(
        document.getElementById('mapContainer'),
        defaultLayers.vector.normal.map,
        {
            zoom: 1,
            center: { lat: 0, lng: 0 },
            pixelRatio: window.devicePixelRatio || 1,

        });

    addMarkersToMap(map);

    window.addEventListener('resize', () => map.getViewPort().resize());
    var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));


</script>
<?php


mysqli_close($con);
        ?>
</html>