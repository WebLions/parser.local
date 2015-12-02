<?php

include 'lib/air_ports.php';

	$key = $_POST['key'];
	
	foreach ($air_ports as $code => $air_port) {
		
	if(strpos($air_port,$key)) $data .='<li value ="'.$code.'">'.$air_port.'</li>';
	
	}

echo $data;
		

?>