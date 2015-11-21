<?php

include "simple_html_dom.php";
$Origin = trim($_POST['Origin']);   
$Destination = trim($_POST['Destination']);
$C1 = $Origin;
$C2 = $Destination;
$first_date = $_POST['first_date'];
$period = $_POST['pback'];
$perback = $period + $_POST['select'];
$pback = $_POST['select'];
$datetime = DateTime::createFromFormat('d/m/Y', $first_date);
$search_date = $datetime->format('Y-m-d');
$url = "https://wizzair.com/ru-RU/FlightSearch";

function post_content ($url, $Origin, $Destination, $first_date) {  //первый запрос на выборку
    if( $curl = curl_init() ) {
        $uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";
        curl_setopt($curl, CURLOPT_URL, 'https://wizzair.com/ru-RU/Select');
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1); 
        curl_setopt($curl, CURLOPT_ENCODING, "gzip, deflate");
        curl_setopt($curl, CURLOPT_USERAGENT, $uagent);
        curl_setopt($curl, CURLOPT_COOKIEJAR, "Z://dcoo.txt");
        curl_setopt($curl, CURLOPT_COOKIEFILE, "Z://dcoo.txt");
        $out = curl_exec($curl);
        curl_close($curl);
    }     
    $html = str_get_html($out);
    $viewState = $html->find('input[id=viewState]',0)->value;
    $name = $html->find('form[id=SkySales] input',4)->name;
    $value = $html->find('form[id=SkySales] input',4)->value;
    $viewState = preg_replace('/\//','%2F', $viewState);
    $viewState = preg_replace('/\+/','%2B', $viewState);

    $uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";

    $postdata = '__EVENTTARGET=ControlGroupRibbonAnonNewHomeView_AvailabilitySearchInputRibbonAnonNewHomeView_ButtonSubmit';
    $postdata.= '&__VIEWSTATE='.$viewState;
    $postdata.= '&'.$name.'='.$value;
    $postdata.= '&ControlGroupRibbonAnonNewHomeView%24AvailabilitySearchInputRibbonAnonNewHomeView%24OriginStation='.$Origin;
    $postdata.= '&ControlGroupRibbonAnonNewHomeView%24AvailabilitySearchInputRibbonAnonNewHomeView%24DestinationStation='.$Destination;
    $postdata.= '&ControlGroupRibbonAnonNewHomeView%24AvailabilitySearchInputRibbonAnonNewHomeView%24DepartureDate='.$first_date;
    $postdata.= '&ControlGroupRibbonAnonNewHomeView%24AvailabilitySearchInputRibbonAnonNewHomeView%24PaxCountADT=1';
    $postdata.= '&ControlGroupRibbonAnonNewHomeView%24AvailabilitySearchInputRibbonAnonNewHomeView%24PaxCountCHD=0';
    $postdata.= '&ControlGroupRibbonAnonNewHomeView%24AvailabilitySearchInputRibbonAnonNewHomeView%24PaxCountINFANT=0';
    $postdata.= '&ControlGroupRibbonAnonNewHomeView%24AvailabilitySearchInputRibbonAnonNewHomeView%24ButtonSubmit=%D0%9F%D0%BE%D0%B8%D1%81%D0%BA';

    $ch = curl_init( $url );
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate");
    curl_setopt($ch, CURLOPT_USERAGENT, $uagent);
    curl_setopt($ch, CURLOPT_TIMEOUT, 360);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "Z://dcoo.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE,"Z://dcoo.txt");

    $content = curl_exec( $ch );
    //echo $content;
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //echo $code;
    if ($code == 301 || $code == 302) {
        preg_match('/Location:(.*?)\n/', $content, $matches);
        $newurl = trim(array_pop($matches));
        curl_close ($ch);
        return post_content($newurl, $Origin, $Destination, $first_date);
    }else{
        curl_close( $ch );
        return $content;
    }

}
//Парсим рейсы туда
do{   
    $html = post_content($url, $Origin, $Destination, $first_date);
    
    $html = str_get_html($html);
    $html_out = $html->find('div[id=marketColumn0]',0)->find('.flights-body',0);
    unset($html); 
    $datetime = DateTime::createFromFormat('d/m/Y', $first_date); 
    $now_date = $datetime->format('Y-m-d'); 

    foreach ($html_out->find('.flight-row') as $value) {
        $date_out = $value->find('.flight-date',0)->find('span',0)->{'data-flight-departure'};
            if( !empty( $date_out )){
                preg_match('/(.*?)T/', $date_out, $m);
                $date_out = $m[1];
                if( empty( $fly_out[ $date_out ]) ){
                    $str = str_replace("\r\n", " ", $value->find('.selectFlightTooltip',0)->find('label',1)->innertext);
                    preg_match('/\>(.*)$/', $str, $price );

                    $date_out = DateTime::createFromFormat('Y-m-d', $date_out);
                    $date_out = $date_out = $date_out->format('d/m/Y');
                    $fly_out[ $date_out ]['price'] = $price[1];
                    $now_date = $date_out;
                }
            }
    }
    $datetime = DateTime::createFromFormat('d/m/Y', $now_date);
    $datetime->modify('+1 day'); 
    $first_date = trim( $datetime->format('d/m/Y') );
    if($first_date==$now_date){
       $datetime->modify('+1 day'); 
       $first_date = trim( $datetime->format('d/m/Y') );
    }
    if( $period < ( (strtotime($datetime->format('Y-m-d')) - strtotime($search_date)) / 86400) ){
        break;
    }
    unset($datetime);
    //+1 den
}while(true==1);
unset($html);
unset($html_out);

//Парсим обратные рейсы 
$first_date = $_POST['first_date'];
do{   
    $html = post_content($url, $Destination, $Origin, $first_date);
    $html = str_get_html($html);
    $html_in = $html->find('div[id=marketColumn0]',0)->find('.flights-body',0);
    unset($html); 
    $datetime = DateTime::createFromFormat('d/m/Y', $first_date); 
    $now_date = $datetime->format('Y-m-d'); 

    foreach ($html_in->find('.flight-row') as $value) {
        $date_in = $value->find('.flight-date',0)->find('span',0)->{'data-flight-departure'};
            if( !empty( $date_in )){
                preg_match('/(.*?)T/', $date_in, $m);
                $date_in = $m[1];
                if( empty( $fly_in[ $date_in ]) ){
                    $str = str_replace("\r\n", " ", $value->find('.selectFlightTooltip',0)->find('label',1)->innertext);
                    preg_match('/\>(.*)$/', $str, $price );

                    $date_in = DateTime::createFromFormat('Y-m-d', $date_in);
                    $date_in = $date_in->format('d/m/Y');
                    $fly_in[ $date_in ]['price'] = $price[1];
                    $now_date = $date_in;
                }
            }
    }
    $datetime = DateTime::createFromFormat('d/m/Y', $now_date);
    $datetime->modify('+1 day'); 
    $first_date = trim( $datetime->format('d/m/Y') );
    if($first_date==$now_date){
       $datetime->modify('+1 day'); 
       $first_date = trim( $datetime->format('d/m/Y') );
    }
    if( $perback < ( (strtotime($datetime->format('Y-m-d')) - strtotime($search_date)) / 86400) ){
        break;
    }
    unset($datetime);
    //+1 den
}while(true);

unset($html);
unset($html_in);

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