<?php
define('MAX_FILE_SIZE',9000000);
include "simple_html_dom.php";
include "lib/air_flydubai.php";
set_time_limit(9800);

$C1 = trim($_POST['Origin']);   
$C2 = trim($_POST['Destination']);

$Origin = $ru_air[$C1];
$Destination = $ru_air[$C2];



if(!empty($Origin) && !empty($Destination))
{

$first_date1 = $_POST['first_date'];
$date = new DateTime($first_date1);
$first_date = '01';
$first_date.= '/'.$date->format('m');
$first_date.= '/'.$date->format('Y');

$period = $_POST['pback'];
$pback = $_POST['select'];
$cmouth = (int) floor($period / 30) + 1;
$ara = true;

for ($i=0; $i <= $cmouth; $i++) { 
    
$postdata = 'roundSingle=on&';
$postdata.= 'FormModel.Origin='.$airports[$Origin].'&';
$postdata.= 'FormModel.OriginAirportCode='.$Origin.'&';
$postdata.= 'FormModel.Destination='.$airports[$Destination].'&';
$postdata.= 'FormModel.DestinationAirportCode='.$Destination.'&';
$postdata.= 'txtDepartureDate='.$first_date.'&';
$postdata.= 'FormModel.DepartureDate='.$first_date.'&';
$postdata.= 'txtReturnDate='.$first_date.'&';
$postdata.= 'FormModel.ReturnDate='.$first_date.'&';
$postdata.= 'FormModel.IsFlexibleOnDates=false&';
$postdata.= 'FormModel.Adults=1&';
$postdata.= 'FormModel.Children=0&';
$postdata.= 'FormModel.Infants=0&';
$postdata.= 'FormModel.PromoCode=&';
$postdata.= 'flightSearch=Show+flights';
//$postdata = urlencode($postdata);


$html = post_content('http://flights.flydubai.com/en/flights/search/', $postdata);


$html = next_day($origin, $destination, $first_date);

$html_out[] = str_get_html($html[0]);
$html_in[] = str_get_html($html[1]);

    $date = new DateTime($first_date);
    if($ara){
        $first_date = $date->format('d/m/Y');
        $ara = false;
    }else{
        $first_date = $date->format('m/d/Y');
        $ara = true;
    }
    $date = new DateTime($first_date);
    $date->add(new DateInterval('P1M'));
    if($ara){
        $first_date = $date->format('m/d/Y');
        $ara = false;
    }else{
        $first_date = $date->format('d/m/Y');
        $ara = true;
    }

}

foreach ($html_out as $html) {
    
    for($i=1; $i<6; $i++) {

        $out = $html->find('tr',$i);

        foreach ($out->find('td') as $val) {

            preg_match('/1_[A-Z]+_[A-Z]+_(.*?)\s+00/', $val->id, $date_out);
            if( isset( $val->find('.price', 0)->innertext ) ){
                preg_match("/amount\">(.*?)<.*?pence\">([0-9]+)<\/span/", $val->find('.price', 0)->innertext, $output_array);
                $price = $output_array[1] . $output_array[2];
            }else{  
                $price = 'Рейс не найден';
            }
            $fly_out[$date_out[1]]['price'] = $price;
            
        }

    }

}

foreach ($html_in as $html) {

    for($i=1; $i<6; $i++) {

        $in = $html->find('tr',$i);

        foreach ($in->find('td') as $val) {
            
            preg_match('/2_[A-Z]+_[A-Z]+_(.*?)\s+00/', $val->id, $date_in);
            if( isset( $val->find('.price', 0)->innertext ) ){
                preg_match("/amount\">(.*?)<.*?pence\">([0-9]+)<\/span/", $val->find('.price', 0)->innertext, $output_array);
                $price = $output_array[1] . $output_array[2];
            }else{  
                $price = 'Рейс не найден';
            }
            $fly_in[$date_in[1]]['price'] = $price;

        }

    }
}



    foreach ($fly_out as $key => $val) {
        if(!empty($key)){   
        ?>
            <tr>
                <td class="ico-right-fly"></td>
                <td><?=$C1?></td>
                <td><?=$C2?></td>
                <td><?=$key?></td>
                <td><?=$period?></td>
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
                            <td><?=$period?></td>
                            <td><?=$fly_in[$date]['price']?></td>
                        </tr>
                    <?
                }
            }
        }
    }
}


?>