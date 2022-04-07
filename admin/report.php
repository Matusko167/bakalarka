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

    $daily = mysqli_query($con, 'SELECT navsteva, count(navsteva) FROM info WHERE DATE_FORMAT(navsteva,"%D %M %Y") = DATE_FORMAT(sysdate(),"%D %M %Y")');

    $dailyArray = $daily->fetch_assoc();

    $datum = $dailyArray['navsteva'];
    $pocet = $dailyArray['count(navsteva)'];

    echo $datum,$pocet;

    // Performing insert query execution
    // here our table name is college
    $sql = "INSERT INTO daily_report (datum,pocet)
    VALUES ('$datum','$pocet')";

    $id = mysqli_query($con, 'SELECT id FROM daily_report WHERE datum = DATE_FORMAT(sysdate(),"%Y-%c-%e")');


    $idAssoc = $id->fetch_assoc();
    $idReal = $idAssoc['id'];

    echo $idReal;

    mysqli_query($con, "DELETE from daily_report WHERE id = $idReal");
    mysqli_query($con, $sql);

// Close connection
    mysqli_close($con);
?>