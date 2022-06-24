<?php

    include("../database/db_inc.php");
    include("../functions/functions.php");

    $result = $con -> query("SELECT mitarbeiterID FROM Mitarbeiter");
    echo "Returned rows are: " . $result -> num_rows;
    $new_password = "password";
    while($kunde = $result->fetch_array(MYSQLI_ASSOC)):
        foreach($kunde as $value) {
           echo $value . '<br>';
           $hash = password_hash($new_password, PASSWORD_DEFAULT);
           $stmt = "update mitarbeiter set password = '$hash' where mitarbeiterID =".$value;
           $jiji = mysqli_query($con, $stmt);
           echo "done";
        }
    endwhile;
    $con->close();
    
?>