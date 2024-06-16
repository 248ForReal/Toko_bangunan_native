<?php
function toPercent($decimal) {
    $percent = number_format($decimal * 100, 2);
    return $percent . '%';
}
?>
