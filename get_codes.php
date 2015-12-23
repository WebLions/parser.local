<?php

include 'lib/air_port_code.php';

	$key = $_POST['key'];
	$num=0;
	
	foreach ($air_ports as $air_port) {
		
		if( $key === substr($air_port, 0, strlen($key)) ) 
		{
			$data .='<li value ="'.$air_port.'">'.$air_port.'</li>';
			$num++;
			if($num>5){
				break;
			}
		}
	
	}

echo $data;
?>