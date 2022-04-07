<?php

$sname = "sql102.epizy.com";

$unmae = "epiz_30548035";

$password = "jNdZ73D4XOMEj";

$db_name = "epiz_30548035_bakalarka";


$con = mysqli_connect($sname, $unmae, $password, $db_name);


$browsers = mysqli_query($con, "select browser from info group by browser");
$os = mysqli_query($con, "select os from info group by os");
$provider = mysqli_query($con, "select provider from info group by provider");
$touch = mysqli_query($con, "select touch from info group by touch");
$country = mysqli_query($con, "SELECT city, count(navsteva) FROM info where city is not null and navsteva BETWEEN NOW() - INTERVAL 30 DAY AND NOW() GROUP BY city ORDER BY count(navsteva) DESC");
$countryWord = mysqli_query($con, "SELECT city FROM info where city is not null and navsteva BETWEEN NOW() - INTERVAL 30 DAY AND NOW()");

?>

<head>
    <meta charset="UTF-8">
    <title>Bakalarka</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/tailwind.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/wordcloud.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawBrowserChart);
        google.charts.setOnLoadCallback(drawOsChart);
        google.charts.setOnLoadCallback(drawProviderChart);
        google.charts.setOnLoadCallback(drawTouchChart);
        google.charts.setOnLoadCallback(drawCountryChart);


        function drawBrowserChart() {

            var browserData = google.visualization.arrayToDataTable([
                ['Browser', 'Pocet'],
                <?php  while($row = $browsers->fetch_assoc()){
                $browseros = $row['browser'];
                $browser = mysqli_query($con, "select COUNT(browser) from info where browser = '$browseros'");
                $browserArray = $browser->fetch_array();
                echo "['".$row['browser']."',".$browserArray[0]."],";
            }?>

            ]);

            var options = {
                title: 'Browsers',
                backgroundColor: {
                    fill: '#808080',
                    fillOpacity: 0.8
                },
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart-browsers'));

            chart.draw(browserData, options);
        }
        function drawOsChart() {

            var osData = google.visualization.arrayToDataTable([
                ['OS', 'Pocet'],
                <?php  while($row = $os->fetch_assoc()){
                $oss = $row['os'];
                $osd = mysqli_query($con, "select COUNT(os) from info where os = '$oss'");
                $osArray = $osd->fetch_array();
                echo "['".$row['os']."',".$osArray[0]."],";
            }?>

            ]);

            var options = {
                title: 'OS',
                backgroundColor: {
                    fill: '#808080',
                    fillOpacity: 0.8
                },
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart-os'));

            chart.draw(osData, options);
        }
        function drawProviderChart() {

            var providerData = google.visualization.arrayToDataTable([
                ['Provider', 'Pocet'],
                <?php  while($row = $provider->fetch_assoc()){
                $provideros = $row['provider'];
                $providers = mysqli_query($con, "select COUNT(provider) from info where provider = '$provideros'");
                $providerArray = $providers->fetch_array();
                echo "['".$row['provider']."',".$providerArray[0]."],";
            }?>

            ]);

            var options = {
                title: 'Provider',
                backgroundColor: {
                    fill: '#808080',
                    fillOpacity: 0.8
                },
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart-provider'));

            chart.draw(providerData, options);
        }
        function drawTouchChart() {

            var touchData = google.visualization.arrayToDataTable([
                ['Touch', 'Pocet'],
                <?php  while($row = $touch->fetch_assoc()){
                $touchos = $row['touch'];
                $touchs = mysqli_query($con, "select COUNT(touch) from info where touch = '$touchos'");
                $touchArray = $touchs->fetch_array();
                echo "['".$row['touch']."',".$touchArray[0]."],";
            }?>

            ]);

            var options = {
                title: 'Touchscreen',
                backgroundColor: {
                    fill: '#808080',
                    fillOpacity: 0.8
                },
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart-touch'));

            chart.draw(touchData, options);
        }
        function drawCountryChart() {

            var dailyData = google.visualization.arrayToDataTable([
                ['City', 'Pocet prihlasených'],
                <?php  while($row = $country->fetch_assoc()){
                echo "['".$row['city']."',".$row['count(navsteva)']."],"; }
                ?>

            ]);

            var options = {
                title: 'Pocet prihlasených z daných miest za 30 dní',
                backgroundColor: {
                    fill: '#808080',
                    fillOpacity: 0.8
                },
            };

            var chart = new google.visualization.BarChart(document.getElementById('chart-country'));

            chart.draw(dailyData, options);
        }

    </script>


<body>
<a class="bg-gray-600 hover:bg-gray-400 text-black font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-500 rounded p-10 m-5" href="admin.php" ">back</a>


<div class="justify-center m-5 flex text-black border-black">
    <div id="piechart-browsers" style="width: 1000px; height: 700px;"></div>
    <div id="piechart-os" style="width: 1000px; height: 700px;"></div>
</div>
<div class="justify-center m-5 flex text-black border-black">
    <div id="piechart-provider" style="width: 1000px; height: 700px;"></div>
    <div id="piechart-touch" style="width: 1000px; height: 700px;"></div>
</div>
<div class="justify-center m-5 flex text-black border-black">
    <div id="chart-country" style="width: 1000px; height: 700px;"></div>
</div>
<div class="justify-center m-5 flex text-black border-black">
    <div id="my_dataviz"></div>
</div>
<div id="container"></div>
<script>
    const text = '<?php  while($row = $countryWord->fetch_assoc()){
            echo $row['city'] . ', '; }
            ?>',
        lines = text.split(/[,\.]+/g),
        data = lines.reduce((arr, word) => {
            let obj = Highcharts.find(arr, obj => obj.name === word);
            if (obj) {
                obj.weight += 1;
            } else {
                obj = {
                    name: word,
                    weight: 1
                };
                arr.push(obj);
            }
            return arr;
        }, []);

    Highcharts.chart('container', {
        accessibility: {
            screenReaderSection: {
                beforeChartFormat: '<h5>{chartTitle}</h5>' +
                    '<div>{chartSubtitle}</div>' +
                    '<div>{chartLongdesc}</div>' +
                    '<div>{viewTableButton}</div>'
            }
        },
        series: [{
            type: 'wordcloud',
            data,
            name: 'Occurrences'
        }],
        title: {
            text: 'Prihlásenia z miest'
        }
    });
</script>
</body>
