<?php 
    require 'vendor/autoload.php';
    use Carbon\Carbon;
    echo date("Y-m-d H:i:s");
    echo "<br>";
    echo time();
    echo "<br>";

    $date = Carbon::now();
    echo $date->format('F j, Y');
    echo "<br>";
    // $last_week = $date->subweek();
    echo "<br>";
    // echo $last_week->format('Y-m-d H:i:s');
    echo "<br>";
    echo $date;
    echo "<br>";
    echo $date->copy()->addDays(7)->diffForHumans();
    echo "<br>";
    echo $date->copy()->subDays(3)->format('F j, Y');
    echo "<br>";
    echo $date->copy()->addWeeks(2)->format('F j, Y');
    echo "<br>";
    echo $date->copy()->addMonths(3)->format('F j, Y');
    echo "<br>";
    echo $date->copy()->subMonths(1)->format('F j, Y');
    echo "<br>";
    echo $date->copy()->addYears(3)->diffForHumans();
    echo "<br>";
    echo $date->copy()->subYears(1)->format('F j, Y');
    echo "<br>";

    echo $date->copy()->addHours(4)->format('F j, Y H:i:s');
    echo "<br>";
    echo $date->copy()->subMinutes(30)->format('F j, Y H:i:s');
    // $yesterday = $date->

    //yesterday, lastmonth, lastyear, 4days ago, 2 weeks ago, 3 months ago, 6 months ago, 5 years ago
    //file reader
?>