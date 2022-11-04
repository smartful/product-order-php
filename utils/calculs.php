<?php
function getTotalsOnLine(float $unitPrice, float $rate, int $quantity): array {
    $totalHT = $unitPrice * $quantity;
    $totalTTC = $totalHT * (1 + $rate/100);
    return [
        "total_HT" => $totalHT,
        "total_TTC" => $totalTTC
    ];
}