<?php
include "lib/air_flydubai.php";
$city = $_POST['search'];
foreach ($ru_air as $key => $value) {
		?>
		<li data-ata="<?=$value?>"><?=$key?></li>
		<? 
}




















