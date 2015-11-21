<?php

include "simple_html_dom.php";
include "lib/air_norwegian.php";

$Origin = trim($_POST['Origin']);   
$Destination = trim($_POST['Destination']);
$C1 = $Origin;
$C2 = $Destination;
$first_date = $_POST['first_date'];
$period = $_POST['pback'];

$start_date = DateTime::createFromFormat('d/m/Y',$first_date);
$start_date = '01/'. $start_date->format('m/Y');

echo $start_date;

$perback = $period + $_POST['select'];
$pback = $_POST['select'];

$datetime = DateTime::createFromFormat('d/m/Y', $first_date);
$D_Day = $datetime->format('d');
$R_Day = $D_Day;
$D_Month = $datetime->format('Ym');
$R_Month = $D_Month;

		$url = "http://www.norwegian.com/us/booking/flight-tickets/farecalendar/?";
    
		
		
		$cmouth = (int) floor($period / 30) +1;
		
		for ($j=0; $j < $cmouth; $j++) { 
		
		$postdata = 'D_City='.$C1;
		$postdata.= '&A_City='.$C2;
		$postdata.= '&D_Day='.$D_Day;
		$postdata.= '&D_Month='.$D_Month;
		$postdata.= '&D_SelectedDay='.$D_Day;
		$postdata.= '&R_Day='.$R_Day;
		$postdata.= '&R_Month='.$R_Month;
		$postdata.= '&R_SelectedDay='.$R_Day;
		$postdata.= '&CurrencyCode=USD';
		$postdata.= '&processid=8512';
		
		$url.=$postdata;
		
		$html[] = file_get_html($url);
		
					
		foreach($html as $html_content){
			
					$html_content_out= $html_content->find('#ctl01_ctl00_MainContentRegion_MainRegion_ctl00_TableCellFareCallOutbound',0);
					$html_content_in = $html_content->find('#ctl01_ctl00_MainContentRegion_MainRegion_ctl00_TableCellFareCallInbound',0);
					
					for($i=0;$i<30;$i++){
						$start_date = DateTime::createFromFormat('d/m/Y',$start_date);
						$start_date->modify('+1 day');
						$start_date = $start_date->format('d/m/Y');
						
						
						
						if(!empty($html_content_out->find('div.fareCalPrice', $i)->innertext)&&(($html_content_out->find('div.fareCalPrice', $i)->innertext)!='&nbsp;')){
							
							$price_out = $html_content_out->find('div.fareCalPrice', $i)->innertext;
							//preg_match('/\>(.*)\</',$price, $price);
							$fly_out [$start_date] = $price_in;						
						}
							
						
						
						if(!empty($html_content_in->find('div.fareCalPrice', $i)->innertext)&&(($html_content_in->find('div.fareCalPrice', $i)->innertext)!='&nbsp;')){
							
							$price_in = $html_content_in->find('div.fareCalPrice', $i)->innertext;
							//preg_match('/\>(.*)\</',$price, $price);
							$fly_in [$start_date] = $price_in;
						}
							
						
						
					}  					
					
					
				}
				
/*if(!empty($fly_out))
	foreach ($fly_out as $key => $val) {
        if(!empty($key)){   
        ?>
            <tr>
                <td class="ico-right-fly"></td>
                <td><?=$C1?></td>
                <td><?=$C2?></td>
                <td><?=$key?></td>
                <td><?=$val['price']?></td>
            </tr>
        <?
            $date = $key;
            for ($i=0; $i < $pback; $i++) { 
                $datetime = DateTime::createFromFormat('d/m/Y', $date);
                $datetime->modify('+1 day');  
                $date = $datetime->format('d/m/Y');
                if(!empty($fly_in[$date])){
                    ?>
                        <tr>
                            <td class="ico-left-fly"></td>
                            <td><?=$C2?></td>
                            <td><?=$C1?></td>
                            <td><?=$date?></td>
                            <td><?=$fly_in[$date]['price']?></td>
                        </tr>
                    <?
                }
            }
        }
	}
	$D_Month = DateTime::createFromFormat('Ym',$D_Month);
	$D_Month->modify('+1 month');
	$D_Month->format('Ym');*/
	echo '<pre>';
	print_r($fly_out);
	
	echo $url.$postdata;
	
}



?>