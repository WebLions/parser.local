<?php
session_start();
define('MAX_FILE_SIZE',9000000);
include "simple_html_dom.php";
include "lib/air_flydubai.php";
include "lib/air_ports.php";
set_time_limit(9800);

$ac1 = explode(",", $_POST['c1']);
$ac2 = explode(",", $_POST['c2']);

foreach ($ac1 as $c1) {
    foreach ($ac2 as $c2) {
        $Origin = trim($c1);
        $Destination = trim($c2);
        $C1 = $air_ports[trim($c1)];
        $C2 = $air_ports[trim($c2)];


        if (empty($_POST['first_date'])) exit("Дата не введенна");
        if (empty($_POST['c1'])) exit("Не указан город 1");
        if (empty($_POST['c2'])) exit("Не указан город 2");
        if (empty($_POST['pback'])) exit("Не указан диапазон");
        $search_date = $first_date = $_POST['first_date'];
        $search_date = DateTime::createFromFormat('d/m/Y', $search_date);

        $period = $_POST['pback'];
        $pback = $_POST['select']; //граници поиска обратного дня
        $col = intval(($period + $pback) / 7);
        echo $col;
//$html = post_content($first_date,$airports[$Origin],$Origin,$airports[$Destination],$Destination);
        $search_date = DateTime::createFromFormat('d/m/Y', $first_date);
        $search_date->modify("+3 day");
        $datetime = $search_date->format('m/d/Y 00:00:00');

        $first_date = $search_date->format('d/m/Y');


        if ($curl = curl_init()) {

            $uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";

            $urls = "http://flights.flydubai.com/en/flights/search/";

            $postdata = 'roundSingle=on&';
            $postdata .= 'FormModel.Origin=' . $airports[$Origin] . '&';
            $postdata .= 'FormModel.OriginAirportCode=' . $Origin . '&';
            $postdata .= 'FormModel.Destination=' . $airports[$Destination] . '&';
            $postdata .= 'FormModel.DestinationAirportCode=' . $Destination . '&';
            $postdata .= 'txtDepartureDate=' . $first_date . '&';
            $postdata .= 'FormModel.DepartureDate=' . $first_date . '&';
            $postdata .= 'txtReturnDate=' . $first_date . '&';
            $postdata .= 'FormModel.ReturnDate=' . $first_date . '&';
            $postdata .= 'FormModel.IsFlexibleOnDates=false&';
            $postdata .= 'FormModel.Adults=1&';
            $postdata .= 'FormModel.Children=0&';
            $postdata .= 'FormModel.Infants=0&';
            $postdata .= 'FormModel.PromoCode=&';
            $postdata .= 'flightSearch=Show+flights';

            curl_setopt($curl, CURLOPT_URL, $urls);
            curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_ENCODING, "gzip, deflate");
            curl_setopt($curl, CURLOPT_USERAGENT, $uagent);
            curl_setopt($curl, CURLOPT_COOKIESESSION, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 180);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($curl, CURLOPT_COOKIEJAR, "coo.txt");
            curl_setopt($curl, CURLOPT_COOKIEFILE, "coo.txt");
            $content = curl_exec($curl);
            //echo $content;

            curl_setopt($curl, CURLOPT_POST, 0);
            curl_setopt($curl, CURLOPT_ENCODING, "gzip, deflate, sdch");
            curl_setopt($curl, CURLOPT_URL, 'http://flights.flydubai.com/en/flights/search/');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $out = curl_exec($curl);
            //echo $out;

            curl_setopt($curl, CURLOPT_ENCODING, "gzip");
            curl_setopt($curl, CURLOPT_POST, 0);
            curl_setopt($curl, CURLOPT_URL, 'http://flights.flydubai.com/en/results/threedayview/');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $out = curl_exec($curl);

            //echo $out;

            for ($i = 0; $i <= $col; $i++) {
                $url = '';
                $url .= 'http://flights.flydubai.com/en/results/changesegmentdate/?date=' . urlencode($datetime);
                $url .= '&origin=' . $Origin;
                $url .= '&destination=' . $Destination;
                $url .= '&originalsegmentid=1';
                $url .= '&monthtabtype=Economy';

                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $out = curl_exec($curl);
                $html_out[] = str_get_html($out);
                //echo $out;
                unset($out);

                $url = '';
                $url .= 'http://flights.flydubai.com/en/results/changesegmentdate/?date=' . urlencode($datetime);
                $url .= '&origin=' . $Origin;
                $url .= '&destination=' . $Destination;
                $url .= '&originalsegmentid=2';
                $url .= '&monthtabtype=Economy';

                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $out = curl_exec($curl);
                $html_in[] = str_get_html($out);
                //echo $out;
                unset($out);

                sleep(1);
                $datetime = DateTime::createFromFormat('m/d/Y H:i:s', $datetime);
                $datetime->modify("+7 day");
                $datetime = $datetime->format('m/d/Y 00:00:00');

            }

            curl_close($curl);

        }

        foreach ($html_out as $html) {
            foreach ($html->find('td.dayAmount') as $value) {
                //echo $value->id;
                preg_match('/1_[A-Z]+_[A-Z]+_(.*)/', $value->id, $last_date);
                //print_r($last_date);
                if (isset($value->find('.pence', 0)->innertext)) {
                    $preprice = str_replace(array("\r\n", "\r", "\n"), " ", $value->find('.pence', 0)->parent()->innertext);
                    //echo $value->find('.pence', 0)->parent()->innertext;
                    preg_match("/(.*?)<.*?>([0-9]+)</", $preprice, $output_array);
                    $price = $output_array[1] . $output_array[2];
                    //print_r($output_array);
                    $fly_out[$last_date[1]]['price'] = $price;
                }
            }
        }
        foreach ($html_in as $html) {
            foreach ($html->find('td.dayAmount') as $value) {
                //echo $value->id;
                preg_match('/2_[A-Z]+_[A-Z]+_(.*)/', $value->id, $last_date);
                //print_r($last_date);
                if (isset($value->find('.pence', 0)->innertext)) {
                    $preprice = str_replace(array("\r\n", "\r", "\n"), " ", $value->find('.pence', 0)->parent()->innertext);
                    //echo $value->find('.pence', 0)->parent()->innertext;
                    preg_match("/(.*?)<.*?>([0-9]+)</", $preprice, $output_array);
                    $price = $output_array[1] . $output_array[2];
                    //print_r($output_array);
                    $fly_in[$last_date[1]]['price'] = $price;
                }
            }
        }

        /*

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
        if (!empty($fly_out)) {
            foreach ($fly_out as $key => $val) {
                if (!empty($key)) {
                    ?>
                    <tr>
                        <td>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th style ="width: 3%"></th>
                                    <th style ="width: 30%">Откуда</th>
                                    <th style ="width: 30%">Куда</th>
                                    <th style ="width: 30%">Датa вылета</th>
                                    <th style ="width: 7%">Цена</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="ico-right-fly"></td>
                                    <td><?= $air_ports[$c1] ?></td>
                                    <td><?= $air_ports[$c2] ?></td>
                                    <td><?= $key ?></td>
                                    <td><?= $val ?></td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="table">
                                <tbody>
                                <?
                                $date = $key;
                                for ($i = 0; $i < $pback; $i++) {
                                    $datetime = DateTime::createFromFormat('d/m/Y', $date);
                                    $datetime->modify('+1 day');
                                    $date = $datetime->format('d/m/Y');
                                    if (!empty($fly_in[$date])) {
                                        ?>
                                        <tr>
                                            <td style ="width: 3%" class="ico-left-fly"></td>
                                            <td style ="width: 30%"><?= $air_ports[$c2] ?></td>
                                            <td style ="width: 30%"><?= $air_ports[$c1] ?></td>
                                            <td style ="width: 30%"><?= $date ?></td>
                                            <td style ="width: 7%"><?= $fly_in[$date] ?></td>
                                        </tr>
                                        <?
                                    }
                                } ?>
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
                                    <td><?= $val['price'] ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <?
                }
            }
        } else {
            echo "Рейсы отсутствуют";
        }
    }
}
?>