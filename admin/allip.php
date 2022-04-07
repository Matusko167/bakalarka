<head>
    <meta charset="UTF-8">
    <title>Bakalarka</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/tailwind.css">
</head>
<?php

$sname = "sql102.epizy.com";

$unmae = "epiz_30548035";

$password = "jNdZ73D4XOMEj";

$db_name = "epiz_30548035_bakalarka";


$con = mysqli_connect($sname, $unmae, $password, $db_name);


?>
<body>

<a class="bg-gray-600 hover:bg-gray-400 text-black font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-500 rounded p-10 m-5" href="admin.php" ">back</a>

    <div class="justify-center m-5 flex text-black border-black flex-row">

        <table class="shadow-lg justify-center content-center">
            <caption class="bg-gray-500 p-2 text-xl">Všetky pripojené IP</caption>
            <tr class="content-center">
                <th class="bg-gray-400 p-2 border-black text-xl">IP</th>
                <th class="bg-gray-400 p-2 border-black text-xl">Štát</th>
                <th class="bg-gray-400 p-2 border-black text-xl">Mesto</th>
            </tr>
            <?php
            $cities = mysqli_query($con,"select * from info where ip is not null group by fingerprint");

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


<?php
mysqli_close($con);
?>

</body>
