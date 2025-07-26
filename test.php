<?php
$timeString = "10:3011:0012:00...";
$timeLength = 5; // Assuming each time value is of length 5 (HH:MM)

$times = str_split($timeString, $timeLength);

foreach ($times as $index => $time) {
    // Do something with each time value
    $variableName = "time_" . ($index + 1);
    $$variableName = $time; // Creating dynamic variable names (time_1, time_2, etc.)
}

// Now you have variables like $time_1, $time_2, etc. containing individual time values
echo $time_1; // Output: 10:30
?>