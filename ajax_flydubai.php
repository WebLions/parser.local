<?php
define('MAX_FILE_SIZE',9000000);
include "simple_html_dom.php";
include "lib/air_flydubai.php";
set_time_limit(9800);

    function search($Y, $uagent, $id){
        $cur = curl_init(  );
        curl_setopt($cur, CURLOPT_URL, 'http://flights.flydubai.com/en/results/onemonthviewsegment/?segmentid='.$id.'&');
        curl_setopt($cur, CURLOPT_HEADER, true);
        curl_setopt($cur, CURLOPT_ENCODING, "gzip");
        curl_setopt($cur, CURLOPT_USERAGENT, $uagent);
        curl_setopt($cur, CURLOPT_COOKIEJAR, "coo.txt");
        curl_setopt($cur, CURLOPT_COOKIEFILE,"coo.txt");
        curl_setopt($cur, CURLOPT_RETURNTRANSFER, 1);
        $html = curl_exec($cur);
        curl_close($cur);
        $test = str_get_html($html);
        //sleep(2);
        if(strpos($test->find('.absoluteHeading',0)->innertext, $Y)) 
            return $html;
        else
            return search($Y, $uagent, $id);
    }

function post_content($first_date,$air_origin,$Origin,$air_destination,$Destination) {  

    $uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";

    $url = "http://flights.flydubai.com/en/flights/search/";

    $postdata = 'roundSingle=on&';
    $postdata.= 'FormModel.Origin='.$air_origin.'&';
    $postdata.= 'FormModel.OriginAirportCode='.$Origin.'&';
    $postdata.= 'FormModel.Destination='.$air_destination.'&';
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

    $ch = curl_init( );
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate");
    curl_setopt($ch, CURLOPT_USERAGENT, $uagent);
    curl_setopt($ch, CURLOPT_TIMEOUT, 180);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "coo.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE,"coo.txt");
    $content = curl_exec( $ch );
    curl_close( $ch );

    $date = DateTime::createFromFormat('d/m/Y', $first_date);
    $Y = $date->format('Y');
    $html[0] = search($Y, $uagent, 1);
    $html[1] = search($Y, $uagent, 2);

    return $html;
}
$C1 = trim($_POST['Origin']);   
$C2 = trim($_POST['Destination']);

$Origin = trim($_POST['Origi']); 
$Destination = trim($_POST['Destinatio']);
if(empty($_POST['first_date'])) exit("Дата не введенна");
$search_date = $first_date = $_POST['first_date'];
$search_date = DateTime::createFromFormat('d/m/Y', $search_date);

$period = $_POST['pback'];
$pback = $_POST['select']; //граници поиска обратного дня

//$html = post_content($first_date,$airports[$Origin],$Origin,$airports[$Destination],$Destination);

do{  

    $html = post_content($first_date,$airports[$Origin],$Origin,$airports[$Destination],$Destination);
    $html_out = str_get_html($html[0]);
    $html_in = str_get_html($html[1]);
    //echo $html[0];
    unset($html);
    foreach ($html_in->find('td.monthDayAmount') as $value) {
        preg_match('/2_[A-Z]+_[A-Z]+_(.*?)\s+00/', $value->id, $last_date);
        $preprice = str_replace(array("\r\n", "\r", "\n"), " ", $value->find('.price', 0)->innertext);
        preg_match("/>(.*?)<.*?>([0-9]+)</", $preprice, $output_array);
        $price = $output_array[1] . $output_array[2];
        $fly_in[$last_date[1]]['price'] = $price;
    }
    unset($html_in);
    foreach ($html_out->find('td.monthDayAmount') as $value) {
        preg_match('/1_[A-Z]+_[A-Z]+_(.*?)\s+00/', $value->id, $last_date);
        $preprice = str_replace(array("\r\n", "\r", "\n"), " ", $value->find('.price', 0)->innertext);
        preg_match("/>(.*?)<.*?>([0-9]+)</", $preprice, $output_array);
        $price = $output_array[1] . $output_array[2];
        $fly_out[$last_date[1]]['price'] = $price;
    }
    unset($html_out);
    //$now_date = DateTime::createFromFormat('d/m/Y', $first_date);
    $last_date[1] = DateTime::createFromFormat('d/m/Y', $last_date[1]);
    //echo $last_date[1]->format('m/d/Y') . " " . $search_date->format('m/d/Y') ."<br>";
    //print_r($last_date);
    $p1 = strtotime($last_date[1]->format('m/d/Y'));
    $p2 = strtotime($search_date->format('m/d/Y'));
    //echo $p1 . " " . $p2;
    if( ($period+$pback) > ($p1 - $p2)/86400 ){
        $first_date = DateTime::createFromFormat('d/m/Y', $first_date);
        $first_date->modify('+1 month');
        $first_date = $first_date->format('01/m/Y');
        echo $first_date;
        unset($last_date);
    }else{
        break;
    }

}while(true);
//echo "<pre>";
//print_r($fly_out);


?>
<?php
/*
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
$date = DateTime::createFromFormat('d/m/Y', $first_date1);
$first_date = '01';
$first_date.= '/'.$date->format('m');
$first_date.= '/'.$date->format('Y');
$raz = $date->format('d') - 1;

$period = $_POST['pback'] + $raz ;
$pback = $_POST['select'];
$cmouth = (int) floor($raz / 30);
$cmouth = ($cmouth==0)? 1 : $cmouth ;
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


post_content('http://flights.flydubai.com/en/flights/search/', $postdata);


$html = next_day($origin, $destination, $first_date);
/*
$file = 'load.txt';
$current = file_get_contents($file);
$current = $i;
file_put_contents($file, $current);
*/
/*
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

$k=0;

foreach ($html_out as $html) {
    
    for($i=1; $i<6; $i++) {

        $out = $html->find('tr',$i);

        foreach ($out->find('td') as $val) {

            if($raz>0){
                $raz--;
                continue;
            } 
            if($k<=$_POST['pback']){
                preg_match('/1_[A-Z]+_[A-Z]+_(.*?)\s+00/', $val->id, $date_out);
                if( isset( $val->find('.price', 0)->innertext ) ){

                    $preprice = str_replace(array("\r\n", "\r", "\n"), " ", $val->find('.price', 0)->innertext);
                    preg_match("/>(.*?)<.*?>([0-9]+)</", $preprice, $output_array);
                    $price = $output_array[1] . $output_array[2];
                }else{  
                    $price = 'Рейс не найден';
                }
                $k++;
                $fly_out[$date_out[1]]['price'] = $price;
            }else{
                break;
            }
        }

    }

}

foreach ($html_in as $html) {

    for($i=1; $i<6; $i++) {

        $in = $html->find('tr',$i);

        foreach ($in->find('td') as $val) {
            
            preg_match('/2_[A-Z]+_[A-Z]+_(.*?)\s+00/', $val->id, $date_in);
            if( isset( $val->find('.price', 0)->innertext ) ){
                $preprice = str_replace(array("\r\n", "\r", "\n"), " ", $val->find('.price', 0)->innertext);
                preg_match("/>(.*?)<.*?>([0-9]+)</", $preprice, $output_array);
                $price = $output_array[1] . $output_array[2];
            }else{  
                $price = 'Рейс не найден';
            }
            $fly_in[$date_in[1]]['price'] = $price;

        }

    }
}
/*
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
            for ($i=0; $i < $period; $i++) { 
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

    }*/
 if(!empty($fly_out)){ 
foreach ($fly_out as $key => $val) {
        if(!empty($key)){   
        ?>
            <tr>
            <td>
                <table class="table">
                <thead>
                 <tr>
                 <th></th>
                 <th>Откуда</th>
                 <th>Куда</th>
                 <th>Датa вылета</th>
                 <th>Цена</th>
                 </tr>
                 </thead>
                 <tbody>
                    <tr>
                    <td class="ico-right-fly"></td>
                    <td><?=$C1?></td>
                    <td><?=$C2?></td>
                    <td><?=$key?></td>
                    <td><?=$val['price']?></td>
                    </tr>
                 </tbody>
                </table>
                <table class="table">
                 <tbody>
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
                }?>  
                </tbody>
                </table>
                
            </td>
            <td style="display:none;">
                <table class="table">
                 <thead>
                 <tr>
                 <th></th>
                 </tr>
                 </thead>
                 <tbody>
                    <tr>
                        <td><?=$val['price']?></td>
                    </tr>
                </tbody>
                </table>
            </td>                     
        </tr>
        <?
            $date = DateTime::createFromFormat('d/m/Y', $key);
            //echo "<tr>". (strtotime($date->format('m/d/Y'))-strtotime($search_date->format('m/d/Y')))/86400 ."</tr>";
            if( ($period) < (strtotime($date->format('m/d/Y'))-strtotime($search_date->format('m/d/Y')))/86400 ){
                break;
            }
            
        }
    }
}else{
    echo "Рейсы отсутствуют";
}
?>