<?php

        set_time_limit(9800);
include "simple_html_dom.php";
include "lib/air_ports.php";
if(empty($_POST['first_date'])) exit("Дата не введенна");
if(empty($_POST['c1'])) exit("Не указан город 1");
if(empty($_POST['c2'])) exit("Не указан город 2");
if(empty($_POST['pback'])) exit("Не указан диапазон");

$ac1 = explode(",", $_POST['c1']);
$ac2 = explode(",", $_POST['c2']);
function nexdate()
{
    $uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";

    $postdata = "isAjaxRequest=true&marketIndex=0&direction=1";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://wizzair.com/ru-RU/Select-resource");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_USERAGENT, $uagent);
    curl_setopt($ch, CURLOPT_TIMEOUT, 180);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "dcoo.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "dcoo.txt");
    $content = curl_exec($ch);
    return $content;
}

function post_content($url, $Origin, $Destination, $first_date)
{  //первый запрос на выборку
    /*  if( $curl = curl_init() ) {
          $uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";
          curl_setopt($curl, CURLOPT_URL, 'https://wizzair.com/ru-RU/Select');
          curl_setopt($curl, CURLOPT_HEADER, true);
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($curl, CURLOPT_FOLLOWLOCATION,1);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
          curl_setopt($curl, CURLOPT_ENCODING, "gzip");
          curl_setopt($curl, CURLOPT_USERAGENT, $uagent);
          curl_setopt($curl, CURLOPT_COOKIEJAR, "dcoo.txt");
          curl_setopt($curl, CURLOPT_COOKIEFILE, "dcoo.txt");
          $out = curl_exec($curl);
          curl_close($curl);
      }
      $html = str_get_html($out);
      $viewState = $html->find('input[id=viewState]',0)->value;
      $name = $html->find('form[id=SkySales] input',4)->name;
      $value = $html->find('form[id=SkySales] input',4)->value;
      $viewState = preg_replace('/\//','%2F', $viewState);
      $viewState = preg_replace('/\+/','%2B', $viewState);
  */
    $uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";

    $postdata = '__EVENTTARGET=ControlGroupRibbonAnonNewHomeView_AvailabilitySearchInputRibbonAnonNewHomeView_ButtonSubmit';
    //  $postdata.= '&__VIEWSTATE='.$viewState;
    //  $postdata.= '&'.$name.'='.$value;
    $postdata .= '&ControlGroupRibbonAnonNewHomeView%24AvailabilitySearchInputRibbonAnonNewHomeView%24OriginStation=' . $Origin;
    $postdata .= '&ControlGroupRibbonAnonNewHomeView%24AvailabilitySearchInputRibbonAnonNewHomeView%24DestinationStation=' . $Destination;
    $postdata .= '&ControlGroupRibbonAnonNewHomeView%24AvailabilitySearchInputRibbonAnonNewHomeView%24DepartureDate=' . $first_date;
    $postdata .= '&ControlGroupRibbonAnonNewHomeView%24AvailabilitySearchInputRibbonAnonNewHomeView%24PaxCountADT=1';
    $postdata .= '&ControlGroupRibbonAnonNewHomeView%24AvailabilitySearchInputRibbonAnonNewHomeView%24PaxCountCHD=0';
    $postdata .= '&ControlGroupRibbonAnonNewHomeView%24AvailabilitySearchInputRibbonAnonNewHomeView%24PaxCountINFANT=0';
    $postdata .= '&ControlGroupRibbonAnonNewHomeView%24AvailabilitySearchInputRibbonAnonNewHomeView%24ButtonSubmit=%D0%9F%D0%BE%D0%B8%D1%81%D0%BA';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_USERAGENT, $uagent);
    curl_setopt($ch, CURLOPT_TIMEOUT, 180);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "dcoo.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "dcoo.txt");

    $content = curl_exec($ch);
    //echo $content;
    return $content;
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //echo $code;
    /*
    if ($code == 301 || $code == 302 || $code == 100) {
        preg_match('/Location:(.*?)\n/', $content, $matches);
        $newurl = trim(array_pop($matches));
        curl_close ($ch);
        return post_content($url, $Origin, $Destination, $first_date);
    }else{
        curl_close( $ch );
        return $content;
    }
    if( $curl = curl_init() ) {
        $uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";
        curl_setopt($curl, CURLOPT_URL, 'https://wizzair.com/ru-RU/Select');
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl, CURLOPT_ENCODING, "gzip");
        curl_setopt($curl, CURLOPT_USERAGENT, $uagent);
        curl_setopt($curl, CURLOPT_COOKIEJAR, "dcoo.txt");
        curl_setopt($curl, CURLOPT_COOKIEFILE, "dcoo.txt");
        $out = curl_exec($curl);
        curl_close($curl);
        echo $out;
    } */

}
foreach ($ac1 as $c1) {
    foreach ($ac2 as $c2) {
        $Origin = trim($c1);
        $Destination = trim($c2);
        $C1 = $air_ports[trim($c1)];
        $C2 = $air_ports[trim($c2)];

        $first_date = $_POST['first_date'];
        $period = $_POST['pback'];
        $perback = $period + $_POST['select'];
        $pback = $_POST['select'];
        $datetime = DateTime::createFromFormat('d/m/Y', $first_date);
        $search_date = $datetime->format('Y-m-d');
        $url = "https://wizzair.com/ru-RU/FlightSearch";


//Парсим рейсы туда
        $html = post_content($url, $Origin, $Destination, $first_date);
        do {

            $html = str_get_html($html);
            if(is_object($html->find('div[id=marketColumn0]'))){
                echo "Рейсы отсутствуют";
                break 1;
            }else{
                $html_out = $html->find('div[id=marketColumn0]', 0)->find('.flights-body', 0);
            }
            unset($html);

            $datetime = DateTime::createFromFormat('d/m/Y', $first_date);
            $now_date = $datetime->format('d/m/Y');

            foreach ($html_out->find('.flight-row') as $value) {

                $date_out = $value->find('.flight-date', 0)->find('span', 0)->{'data-flight-departure'};
                if (!empty($date_out)) {

                    preg_match('/(.*?)T/', $date_out, $m);
                    $date_out = $m[1];
                    if (empty($fly_out[$date_out])) {
                        $str = str_replace("\r\n", " ", $value->find('.selectFlightTooltip', 0)->find('label', 1)->innertext);
                        preg_match('/\>(.*)$/', $str, $price);

                        $date_out = DateTime::createFromFormat('Y-m-d', $date_out);
                        $date_out = $date_out->format('d/m/Y');
                        $fly_out[$date_out]['price'] = $price[1];
                        $now_date = $date_out;
                        //echo $now_date;
                    }
                }

            }
            //echo $first_date .'---'. $now_date."<br>";
            $datetime = DateTime::createFromFormat('d/m/Y', $now_date);
            /*
            $datetime->modify('+1 day');
            if($first_date == trim( $datetime->format('d/m/Y') )){
               $datetime->modify('+1 day');
            }
            $first_date = trim( $datetime->format('d/m/Y') );
            if($first_date==$now_date){
               $datetime->modify('+1 day');
               $first_date = trim( $datetime->format('d/m/Y') );
            }*/
            if ($period < ((strtotime($datetime->format('Y-m-d')) - strtotime($search_date)) / 86400)) {
                break;
            } else {
                $html = nexdate();
            }
            unset($datetime);
            //+1 den
        } while (true);

        unset($html);
        unset($html_out);


//Парсим обратные рейсы 
        $first_date = $_POST['first_date'];
        $html = post_content($url, $Destination, $Origin, $first_date);

        do {

            $html = str_get_html($html);

            //$html_in = $html->find('div[id=marketColumn0]', 0)->find('.flights-body', 0);

            if(is_object($html->find('div[id=marketColumn0]'))){
                echo "Рейсы отсутствуют";
                break 1;
            }else{
                $html_in = $html->find('div[id=marketColumn0]', 0)->find('.flights-body', 0);
            }
            unset($html);

            $datetime = DateTime::createFromFormat('d/m/Y', $first_date);
            $now_date = $datetime->format('d/m/Y');

            foreach ($html_in->find('.flight-row') as $value) {

                $date_in = $value->find('.flight-date', 0)->find('span', 0)->{'data-flight-departure'};
                if (!empty($date_in)) {
                    preg_match('/(.*?)T/', $date_in, $m);
                    $date_in = $m[1];
                    if (empty($fly_in[$date_in])) {
                        $str = str_replace("\r\n", " ", $value->find('.selectFlightTooltip', 0)->find('label', 1)->innertext);
                        preg_match('/\>(.*)$/', $str, $price);

                        $date_in = DateTime::createFromFormat('Y-m-d', $date_in);
                        $date_in = $date_in->format('d/m/Y');
                        $fly_in[$date_in]['price'] = $price[1];
                        $now_date = $date_in;
                    }
                }

            }
            $datetime = DateTime::createFromFormat('d/m/Y', $now_date);
            /*
            $datetime->modify('+1 day');
            if($first_date == trim( $datetime->format('d/m/Y') )){
               $datetime->modify('+1 day');
            }
            $first_date = trim( $datetime->format('d/m/Y') );
            $first_date = trim( $datetime->format('d/m/Y') );
            if($first_date==$now_date){
               $datetime->modify('+1 day');
               $first_date = trim( $datetime->format('d/m/Y') );
            }*/
            if ($perback < ((strtotime($datetime->format('Y-m-d')) - strtotime($search_date)) / 86400)) {
                break;
            } else {
                $html = nexdate();
            }
            unset($datetime);
            //+1 den
        } while (true);

        unset($html);
        unset($html_in);

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
        unset($fly_out);
        unset($fly_in);
    }
}