<?php
        $connection = mysqli_connect("localhost", "root", "", "manny_bank");
        if (!$connection) {
            echo "Database could not connect" . mysqli_error($connection);
        }else{
            echo "Database connected";
        }
?>