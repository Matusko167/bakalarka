<?php
session_start();
?>
<?php

$sname = "sql102.epizy.com";

$unmae = "epiz_30548035";

$password = "jNdZ73D4XOMEj";

$db_name = "epiz_30548035_bakalarka";


$con = mysqli_connect($sname, $unmae, $password, $db_name);

$coords = mysqli_query($con, "select fingerprint,latitude,longitude from info where latitude is not null and city is not null group by ip");
$daily = mysqli_query($con, 'SELECT DATE_FORMAT(navsteva,"%D %M %Y"), count(navsteva) FROM info WHERE DATE_FORMAT(navsteva,"%Y") = DATE_FORMAT(sysdate(),"%Y") GROUP BY DATE_FORMAT(navsteva,"%M %e") ORDER BY count(navsteva) DESC');

?>
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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawDailyChart);

        function drawDailyChart() {

            var dailyData = google.visualization.arrayToDataTable([
                ['Dni', 'Pocet prihlasených'],
                <?php  while($row = $daily->fetch_assoc()){
                echo "['".$row['DATE_FORMAT(navsteva,"%D %M %Y")']."',".$row['count(navsteva)']."],"; }
                ?>

            ]);

            var options = {
                title: 'Pocet prihlasených za tento rok',
                backgroundColor: {
                    fill: '#808080',
                    fillOpacity: 0.8
                },
            };

            var chart = new google.visualization.BarChart(document.getElementById('chart-daily'));

            chart.draw(dailyData, options);
        }

    </script>

</head>
<body>

<a class="bg-gray-600 hover:bg-gray-400 text-black font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-500 rounded p-10 m-5" href="../user/index.php" ">back</a>



<div class="justify-center m-5 flex text-black border-black flex-row">

    <table class="shadow-lg justify-center content-center">
        <caption class="bg-gray-500 p-2 text-xl font-bold">Vyber čo chceš zobraziť </caption>
            <tr class="content-center">
                <th class="bg-gray-400 p-2 border-black text-xl">
                    <a class="bg-gray-600 hover:bg-gray-400 text-black font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-500 rounded p-10 m-5" href="last10all.php" ">Posledných 10 - všetky informácie</a>
                </th>
            </tr>
            <tr class="content-center">
                <th class="bg-gray-400 p-2 border-black text-xl">
                    <a class="bg-gray-600 hover:bg-gray-400 text-black font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-500 rounded p-10 m-5" href="allip.php" ">Iba IP adresy a lokácie všetkých</a>
                </th>
            </tr>
        <tr class="content-center">
            <th class="bg-gray-400 p-2 border-black text-xl">
                <a class="bg-gray-600 hover:bg-gray-400 text-black font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-500 rounded p-10 m-5" href="statistic.php" ">Štatistiky</a>
            </th>
        </tr>
    </table>

    <table class="shadow-lg justify-center content-center">
        <caption class="bg-gray-500 p-2 text-xl font-bold">Vyber čo potrebuješ</caption>

        <tr class="content-center">
            <th class="bg-gray-400 p-2 border-black text-xl">
                <button class="button bg-gray-600 hover:bg-gray-400 text-black font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-500 rounded p-10 m-5">Urob zaznam z dneška</button>
            </th>
        </tr>
        <tr class="content-center">
            <th class="bg-gray-400 p-2 border-black text-xl">
                <a class="button2 bg-gray-600 hover:bg-gray-400 text-black font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-500 rounded p-10 m-5" href="exportDStoCSV.php">Export z databázy do CSV súboru</a>
            </th>
        </tr>
    </table>
</div>

<script>
    $(document).ready(function(){
        $(".button").click(function(){
            $.ajax({
                url: "report.php",
                type: "post",
            });
        });
    });
</script>

<?php
    $fingeprints = mysqli_query($con, "select id ,fingerprint from info GROUP by fingerprint");
?>

<form class="justify-center m-5 flex text-black border-black flex-row" action="">
    <select name="customers" onchange="showFP(this.value)">
        <option value="">Select fingerprint:</option>
        <?php while($row = $fingeprints->fetch_assoc()){
            ?> <option value="<?php echo $row['id'] ?>"><?php echo $row['fingerprint']; }?> </option>
    </select>
</form>

<div class="justify-center m-5 flex text-black border-black flex-row" id="txtHint"></div>

<script>
    function showFP(str) {
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        }
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById("txtHint").innerHTML = this.responseText;
        }
        xhttp.open("GET", "getFPInfo.php?q="+str);
        xhttp.send();
    }
</script>

<div style="width: 1024px; height: 860px; display: block;
  margin-left: auto;
  margin-right: auto;
  " id="mapContainer"></div>

<div class="justify-center m-5 flex text-black border-black">
    <div id="chart-daily" style="width: 1000px; height: 700px;"></div>

</div>



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
</body>


