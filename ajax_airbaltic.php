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
$url = "https://tickets.airbaltic.com/app/fb.fly";

function post_content ($url, $Origin, $Destination, $first_date) {  //первый запрос на выборку

    $uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";

    $postdata = 'action=avail';
    $postdata.= '&p=bti';
    $postdata.= '&pos=RU';
    $postdata.= '&l=ru';
    $postdata.= '&srcsystem=https%3A%2F%2Fwww.airbaltic.com%2Fru%2Findex';
    $postdata.= '&traveltype=bti';
    $postdata.= '&origin='.$Origin;
    $postdata.= '&origin_type=A';
    $postdata.= '&destin='.$Destination;
    $postdata.= '&destin_type=A';
    $postdata.= '&numadt=1';
    $postdata.= '&numchd=0';
    $postdata.= '&numinf=0';
    $postdata.= '&bbv=0';
    $postdata.= '&flt_origin_text=%D0%9A%D0%B8%D0%B5%D0%B2+%28Boryspol%29+%28KBP%29+-+%D0%A3%D0%BA%D1%80%D0%B0%D0%B8%D0%BD%D0%B0';
    $postdata.= '&flt_destin_text=%D0%92%D0%B0%D1%80%D1%88%D0%B0%D0%B2%D0%B0+%28Frederic+Chopin%29+%28WAW%29+-+%D0%9F%D0%BE%D0%BB%D1%8C%D1%88%D0%B0';
    $postdata.= '&legs=1';
    $postdata.= '&flt_leaving_on='.$first_date;
    $postdata.= '&flt_returning_on='.$first_date;
    $postdata.= '&evoucher%5B%5D=';

    $ch = curl_init( $url );
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate");
    curl_setopt($ch, CURLOPT_USERAGENT, $uagent);
    curl_setopt($ch, CURLOPT_TIMEOUT, 180);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "Z://dcoo.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE,"Z://dcoo.txt");

    $content = curl_exec( $ch );
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
$datetime = DateTime::createFromFormat('d/m/Y', $first_date);
$date_now = $datetime->format('d/m/Y');
$datetime->modify('+3 day');
$d=0;
do{
	$page = post_content($url, $Origin, $Destination, $datetime->format('d.m.Y') );
	$html = str_get_html($page);
	$html = $html->find('div.oneway',0)->find('tr',0);

	foreach ($html->find('span.date-details') as $value) {	
		
		if( !empty($value->find('span.details-price',0)->innertext) ){
			//$preprice = str_replace(array("\r\n", "\r", "\n"), " ", $value->find('span.details-price',0)->innertext);
			preg_match('/От\s(.*)\s(.*)\</', $value->find('span.details-price',0)->innertext, $price);
			$fly_out[ $date_now ]['price'] = $price[1] .' '. $price[2]; 
		}

		$datetime = DateTime::createFromFormat('d/m/Y', $date_now);
		$datetime->modify('+1 day');
		$date_now = $datetime->format('d/m/Y');

		$d++;


	}
	$datetime->modify('+6 day');

}while($d<$period);
unset($html);
$datetime = DateTime::createFromFormat('d/m/Y', $first_date);
$date_now = $datetime->format('d/m/Y');
$datetime->modify('+3 day');

do{
	$page = post_content($url, $Destination, $Origin, $datetime->format('d.m.Y') );
	$html = str_get_html($page);
	$html = $html->find('div.oneway',0)->find('tr',0);

	foreach ($html->find('span.date-details') as $value) {	
		
		if( !empty($value->find('span.details-price',0)->innertext) ){
			//$preprice = str_replace(array("\r\n", "\r", "\n"), " ", $value->find('span.details-price',0)->innertext);
			preg_match('/От\s(.*)\s(.*)\</', $value->find('span.details-price',0)->innertext, $price);
			$fly_in[ $date_now ]['price'] = $price[1] .' '. $price[2]; 
		}

		$datetime = DateTime::createFromFormat('d/m/Y', $date_now);
		$datetime->modify('+1 day');
		$date_now = $datetime->format('d/m/Y');

		$d++;


	}
	$datetime->modify('+6 day');

}while($d<$perback);

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

//print_r($fly_out);
