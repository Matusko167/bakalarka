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

$result = mysqli_query($con, "select * from info group by fingerprint ASC LIMIT 10");


?>
<a class="bg-gray-600 hover:bg-gray-400 text-black font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-500 rounded p-10 m-5" href="admin.php" ">back</a>

    <div class="justify-center m-10 text-black text-center border-black">
        <table class="shadow-lg justify-center content-center border-black">
            <tr class="content-center border-black">
                <th class="bg-gray-500 p-2 border-black">ID</th>
                <th class="bg-gray-500 p-2 border-black" >Fingerprint</th>
                <th class="bg-gray-500 p-2 border-black">Browser</th>
                <th class="bg-gray-500 p-2 border-black">Connection</th>
                <th class="bg-gray-500 p-2 border-black" >Cookie</th>
                <th class="bg-gray-500 p-2 border-black" >Java</th>
                <th class="bg-gray-500 p-2 border-black">Language</th>
                <th class="bg-gray-500 p-2 border-black">Os</th>
                <th class="bg-gray-500 p-2 border-black" >Touch</th>
                <th class="bg-gray-500 p-2 border-black">Useragent</th>
                <th class="bg-gray-500 p-2 border-black" >Ip</th>
                <th class="bg-gray-500 p-2 border-black">Provider</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    ?>
                    <tr class="content-center border-black">
                        <th class="bg-gray-500 p-2 border-black"><?php if(isset($row['id']) != null) {
                                echo "<div>" . $row['id'] . "</div>"; }?></th>
                        <th class="bg-gray-500 p-2 border-black" ><?php if(isset($row['fingerprint']) != null) {
                                echo "<div>" . $row['fingerprint'] . "</div>"; } ?></th>
                        <th class="bg-gray-500 p-2 border-black"><?php if(isset($row['browser']) != null) {
                                echo "<div>" . $row['browser'] . "</div>"; } ?></th>
                        <th class="bg-gray-500 p-2 border-black"><?php if(isset($row['connection']) != null) {
                                echo "<div>" . $row['connection'] . "</div>"; } ?></th>
                        <th class="bg-gray-500 p-2 border-black" ><?php if(isset($row['cookie']) != null) {
                                echo "<div>" . $row['cookie'] . "</div>"; } ?></th> <th class="bg-gray-500 ring-1 ring-black p-2" ><?php echo "<div>" . $row['java'] . "</div>" ?></th>
                        <th class="bg-gray-500 p-2 border-black"><?php if(isset($row['language']) != null) {
                                echo "<div>" . $row['language'] . "</div>"; } ?></th>
                        <th class="bg-gray-500 p-2 border-black"><?php if(isset($row['os']) != null) {
                                echo "<div>" . $row['os'] . "</div>"; } ?></th>
                        <th class="bg-gray-500 p-2 border-black" ><?php if(isset($row['touch']) != null) {
                                echo "<div>" . $row['touch'] . "</div>"; } ?></th>
                        <th class="bg-gray-500 p-2 border-black"><?php if(isset($row['useragent']) != null) {
                                echo "<div>" . $row['useragent'] . "</div>"; } ?></th>
                        <th class="bg-gray-500 p-2 border-black" ><?php if(isset($row['ip']) != null) {
                                echo "<div>" . $row['ip'] . "</div>"; } ?></th>
                        <th class="bg-gray-500 p-2 border-black"><?php if(isset($row['provider']) != null) {
                                echo "<div>" . $row['provider'] . "</div>"; } ?></th>
                        <th class="bg-gray-500 p-2 border-black">Posledná návšteva:
                            <?php
                            $fingerprint = $row['fingerprint'];
                            $datum = mysqli_query($con,"select navsteva from info where fingerprint = $fingerprint AND id=(SELECT MAX(id) from info WHERE fingerprint = $fingerprint)");

                            $datumArray = $datum->fetch_array();
                            if(isset($datumArray[0]) != null) {
                                echo "<div>" . $datumArray[0] . "</div>>";} ?></th>

                    </tr>

                    <?php
                }
            } else {
                echo "0 results";
            }
            ?>




        </table>
    </div>
    </body>

<?php
mysqli_close($con);
?>