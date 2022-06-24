<?php

    include("../database/db_inc.php");
    include("../functions/functions.php");

    $result = $con -> query("SELECT kundeid FROM Kunden");
    echo "Returned rows are: " . $result -> num_rows;
    $new_password = "password";
    while($kunde = $result->fetch_array(MYSQLI_ASSOC)):
        foreach($kunde as $value) {
           echo $value . '<br>';
           $hash = password_hash($new_password, PASSWORD_DEFAULT);
           $stmt = "update kunden set password = '$hash' where kundeid =".$value;
           $jiji = mysqli_query($con, $stmt);
           echo "done";
        }
    endwhile;
    $con->close();

    $result = $con -> query("SELECT Mitarbeiterid FROM Mitarbeiter");
    echo "Returned rows are: " . $result -> num_rows;
    $new_password = "password";
    while($kunde = $result->fetch_array(MYSQLI_ASSOC)):
        foreach($kunde as $value) {
           echo $value . '<br>';
           $hash = password_hash($new_password, PASSWORD_DEFAULT);
           $stmt = "update kunden set password = '$hash' where kundeid =".$value;
           $jiji = mysqli_query($con, $stmt);
           echo "done";
        }
    endwhile;
    $con->close();
    
?>