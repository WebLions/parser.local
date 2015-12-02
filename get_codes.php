<?php

include 'lib/air_ports.php';

	$key = $_POST['key'];
	$num=0;
	
	foreach ($air_ports as $code => $air_port) {
		
		if( $key === substr($air_port, 0, strlen($key)) ) 
		{
			$data .='<li value ="'.$code.'">'.$air_port.'</li>';
			$num++;
			if($num>5){
				break;
			}
		}
	
	}

echo $data;
?>