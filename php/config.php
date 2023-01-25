<?php
    $conn = mysqli_connect("localhost", "root", "", "petrocon");
    if($conn){
        echo "Database connected" . mysqli_connect_error();
    }
    else{
        echo "Error";

    }
        ?>