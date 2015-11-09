<?php
include "simple_html_dom.php";
include "lib/air_flydubai.php";
set_time_limit(9800);

$C1 = trim($_POST['Origin']);   
$C2 = trim($_POST['Destination']);

$Origin = $ru_air[$C1];
$Destination = $ru_air[$C2];

if(!empty($Origin) && !empty($Destination))
{

$first_date = $_POST['first_date'];
$period = $_POST['pback'];
$pback = $_POST['pback'];
//echo $period;
$date = new DateTime($first_date);
$date->add(new DateInterval('P'.$period.'D'));
$second_date = $date->format('d/m/Y');

$date = new DateTime($first_date);

$first_date = $date->format('d');
$first_date.= '/'.$date->format('m');
$first_date.= '/'.$date->format('Y');
$date = new DateTime($first_date);
$date->modify('+3 day');
$first_date = $date->format('d/m/Y');

$ReturnDate = $second_date;

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


$html = post_content('http://flights.flydubai.com/en/flights/search/', $postdata);

$html = next_day();

$html = str_get_html($html);

/*
$file = 'people.txt';
// Открываем файл для получения существующего содержимого
$current = file_get_contents($file);
// Добавляем нового человека в файл
$current .= $am;
// Пишем содержимое обратно в файл
file_put_contents($file, $current);
*/

$day = 0; $plus_day = 1;
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
?>
            <tr>
                <td><?php echo $C1;?></td>
                <td><?php echo $C2;?></td>
                <td><?php echo $date;?></td>
                <td><?php echo $period;?></td>
                <!-- <td><?php //echo $second_date;?></td> -->
                <td><?php echo !empty($am)? $price : 'Рейс не найден';?></td>

            </tr>
<?php 
    
        }else{
            break;
        }
    }

    $date = new DateTime($first_date);
    $first_date = $date->format('m');
    $first_date.= '/'.$date->format('d');
    $first_date.= '/'.$date->format('Y');

    $dates =  date('m/d/Y', strtotime($first_date. ' + 7 days'));
    $date = new DateTime($dates);
    /*
    $first_date = $date->format('m');
    $first_date.= '/'.$date->format('d');
    $first_date.= '/'.$date->format('Y');
*/
    $first_date = $date->format('d');
    $first_date.= '/'.$date->format('m');
    $first_date.= '/'.$date->format('Y');

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
    $html = post_content('http://flights.flydubai.com/en/flights/search/', $postdata);

    $html = next_day();
    //echo $html;
    $html = str_get_html($html);
}

}else{
    echo 'Неверно указан аеропорт';
}

?>
