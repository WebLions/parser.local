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


/*
$file = 'people.txt';
// Открываем файл для получения существующего содержимого
$current = file_get_contents($file);
// Добавляем нового человека в файл
$current .= $am;
// Пишем содержимое обратно в файл
file_put_contents($file, $current);
*/


foreach ($html_out as $html) {
    
    for($i=1; $i<6; $i++) {

        $out = $html->find('tr',$i);

        foreach ($out->find('td') as $val) {

            preg_match('/1_[A-Z]+_[A-Z]+_(.*?)\s+00/', $val->id, $date_out);
            $fly_out[$date_out[1]]['price'] = isset( $val->find('.price', 0)->innertext )? $val->find('.price', 0)->innertext : 'Рейс не найден';
            
        }

    }

}

foreach ($html_in as $html) {

    for($i=1; $i<6; $i++) {

        $in = $html->find('tr',$i);

        foreach ($in->find('td') as $val) {

            preg_match('/2_[A-Z]+_[A-Z]+_(.*?)\s+00/', $val->id, $date_in);
            $fly_in[$date_in[1]]['price'] = isset( $val->find('.price', 0)->innertext )? $val->find('.price', 0)->innertext : 'Рейс не найден';

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
            $fly_in[$key] = $
        }
    }

    foreach ($fly_in as $key => $val) {
        if(!empty($key)){    
        ?>
            <tr>
                <td class="ico-left-fly"></td>
                <td><?=$C2?></td>
                <td><?=$C1?></td>
                <td><?=$key?></td>
                <td><?=$period?></td>
                <td><?=$val['price']?></td>
            </tr>
        <?
        }
    }

}


/*

$day = 0; $plus_day = 1; $k=1;
while ($day <= $period ) {
    $tr = $html->find('.priceRow',0);

    for($i=0; $i<7; $i++){
        $day++;
        echo $day;
        if($day <= $period){

        $elem = $tr->find('td',$i);
        $am = $elem->find('.showdiv span',0);
        if(empty($am)){
             $am = $elem->find('.hidediv span',0);
        }
        $date = substr($elem->id, strripos($elem->id, "_") + 1, strlen($elem->id));
        
        preg_match('/<span>(.*?)\./',$am, $p);
        preg_match('/\'pence\'>(.*?)</',$am, $p1);
        $price = $p[1].".".$p1[1];


    
        }else{
            break;
        }
    }

    if($plus_day!==1){
        $date = new DateTime($dates);
        $plus_day++;
        $first_date = $date->format('m');
        $first_date.= '/'.$date->format('d');
        $first_date.= '/'.$date->format('Y');
    }else{
        $first_date = $first_date1;
    }


    $dates =  date('m/d/Y', strtotime($first_date. ' + 7 days'));
    $date = new DateTime($dates);
    $first_date = $date->format('d');
    $first_date.= '/'.$date->format('m');
    $first_date.= '/'.$date->format('Y');

    $first_date1 = $date->format('m');
    $first_date1.= '/'.$date->format('d');
    $first_date1.= '/'.$date->format('Y');

    $postdata = 'roundSingle=on&';
    $postdata.= 'FormModel.Origin='.$airports[$Origin].'&';
    $postdata.= 'FormModel.OriginAirportCode='.$Origin.'&';
    $postdata.= 'FormModel.Destination='.$airports[$Destination].'&';
    $postdata.= 'FormModel.DestinationAirportCode='.$Destination.'&';
    $postdata.= 'txtDepartureDate='.$first_date.'&';
    $postdata.= 'FormModel.DepartureDate='.$first_date.'&';
    $postdata.= 'txtReturnDate='.$ReturnDate.'&';
    $postdata.= 'FormModel.ReturnDate='.$ReturnDate.'&';
    $postdata.= 'FormModel.IsFlexibleOnDates=false&';
    $postdata.= 'FormModel.Adults=1&';
    $postdata.= 'FormModel.Children=0&';
    $postdata.= 'FormModel.Infants=0&';
    $postdata.= 'FormModel.PromoCode=&';
    $postdata.= 'flightSearch=Show+flights';
    //$postdata = urlencode($postdata);
    unset($html);
    $html = post_content('http://flights.flydubai.com/en/flights/search/', $postdata);
    $html = next_day();
    //echo $html;
    $html = str_get_html($html);
}

}else{
    echo 'Неверно указан аеропорт';
}
*/
?>