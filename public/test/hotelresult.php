<?php 

$recoveredData = file_get_contents('hotelresult.json');
$recoveredArrays = json_decode($recoveredData, true);
echo '<pre>'; print_r($recoveredArrays); echo '</pre>'; 

?>