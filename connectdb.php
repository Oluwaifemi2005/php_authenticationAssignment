<?php

$connection = mysqli_connect("localhost", "root", "", "manny_bank");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}