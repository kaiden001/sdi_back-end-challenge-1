<?php

function rentalCarCalculation($requiredSeats, $mediumSeatCapacity = 10, $largeCarCost = 12000)
{
    $carTypes = [
        'S' => ['size' => 'Small', 'seatCapacity' => 5, 'cost' => 5000],
        'M' => ['size' => 'Medium', 'seatCapacity' => $mediumSeatCapacity, 'cost' => 8000],
        'L' => ['size' => 'Large', 'seatCapacity' => 15, 'cost' => $largeCarCost],
    ];

    $minCost = PHP_INT_MAX;
    $carsUsed = [];

    for ($l = 0; $l <= ceil($requiredSeats / $carTypes['L']['seatCapacity']); $l++) {
        for ($m = 0; $m <= ceil($requiredSeats / $carTypes['M']['seatCapacity']); $m++) {
            for ($s = 0; $s <= ceil($requiredSeats / $carTypes['S']['seatCapacity']); $s++) {

                $totalSeats = $l * $carTypes['L']['seatCapacity'] + $m * $carTypes['M']['seatCapacity'] + $s * $carTypes['S']['seatCapacity'];

                if ($totalSeats >= $requiredSeats) {
                    $totalCost = $l * $carTypes['L']['cost'] + $m * $carTypes['M']['cost'] + $s * $carTypes['S']['cost'];

                    if ($totalCost < $minCost) {
                        $minCost = $totalCost;
                        $carsUsed = ['L' => $l, 'M' => $m, 'S' => $s];
                    }
                }
            }
        }
    }

    return [
        'minCost' => $minCost,
        'carsUsed' => $carsUsed,
    ];
}

if ($argc < 2 || $argc > 4) {
    echo "Please input number (seat) :\n";
    exit(1);
}

$requiredSeats = (int) $argv[1];
if ($requiredSeats <= 0) {
    echo "The number of seats must be a positive integer.\n";
    exit(1);
}

$mediumSeatCapacity = $argc > 2 ? (int) $argv[2] : 10;
$largeCarCost = $argc > 3 ? (int) $argv[3] : 12000;

$result = rentalCarCalculation($requiredSeats, $mediumSeatCapacity, $largeCarCost);

echo "Cars used:\n";
foreach ($result['carsUsed'] as $type => $count) {
    if ($count > 0) {
        echo "  $type x $count\n";
    }
}
echo "Total = PHP " . $result['minCost'] . "\n";
