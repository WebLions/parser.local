<?php
include "simple_html_dom.php";
$airports = array(
                'AHB' => 'Abha Airport (AHB) - Abha',           
                'ADD' => 'Addis Ababa Airport (ADD) - Addis Ababa',              
               	'AMD' => 'Ahmedabad Airport (AMD) - Ahmedabad',              
               	'AWZ' => 'Ahwaz Airport (AWZ) - Ahwaz',              
                'HBE' => 'Alexandria Borg El Arab Airport (HBE) - Alexandria',            
                'ALA' => 'Almaty Airport (ALA) - Almaty',            
                'AMM' => 'Amman Airport (AMM) - Amman',            
                'ASB' => 'Ashgabat Airport (ASB) - Ashgabat',            
                'ASM' => 'Asmara Airport (ASM) - Asmara',            
                'TSE' => 'Astana Airport (TSE) - Astana',            
                'BGW' => 'Baghdad Airport (BGW) - Baghdad',            
                'BAH' => 'Bahrain Airport (BAH) - Bahrain',            
                'GYD' => 'Baku Airport (GYD) - Baku',            
                'BND' => 'Bandar Abbas Airport (BND) - Bandar Abbas',            
                'BSR' => 'Basra Airport (BSR) - Basra',            
                'BEY' => 'Beirut Airport (BEY) - Beirut',            
                'BEG' => 'Belgrade Airport (BEG) - Belgrade',            
                'FRU' => 'Bishkek Airport (FRU) - Bishkek',            
                'BTS' => 'Bratislava Airport (BTS) - Bratislava',            
                'OTP' => 'Bucharest Airport (OTP) - Bucharest',            
                'BJM' => 'Bujumbura Airport (BJM) - Bujumbura',            
                'MAA' => 'Chennai Airport (MAA) - Chennai',            
                'CGP' => 'Chittagong Airport (CGP) - Chittagong',            
                'CMB' => 'Colombo Airport (CMB) - Colombo',            
                'DMM' => 'Dammam Airport (DMM) - Dammam',            
                'DAR' => 'Dar es Salaam Airport (DAR) - Dar es Salaam',            
                'DEL' => 'Delhi Airport (DEL) - Delhi',            
                'DAC' => 'Dhaka Airport (DAC) - Dhaka',            
                'JIB' => 'Djibouti Airport (JIB) - Djibouti',            
                'DOH' => 'Doha Airport (DOH) - Doha',            
                'DXB' => 'Dubai All Airports (DXB) - Dubai',            
                'DWC' => 'Al Maktoum International Airport (DWC) - Dubai',            
                'DXB' => 'Dubai International Airport (DXB) - Dubai',            
                'DYU' => 'Dushanbe Airport (DYU) - Dushanbe',            
                'EBB' => 'Entebbe Airport (EBB) - Entebbe',            
                'EBL' => 'Erbil Airport (EBL) - Erbil',            
                'IFN' => 'Esfahan Airport (IFN) - Esfahan',            
                'LYP' => 'Faisalabad Airport (LYP) - Faisalabad',            
                'ELQ' => 'Gassim Airport (ELQ) - Gassim',            
                'GIZ' => 'Gizan Airport (GIZ) - Gizan',            
                'GOI' => 'Goa Airport (GOI) - Goa',            
                'HAS' => 'Hail Airport (HAS) - Hail',            
                'HDM' => 'Hamadan Airport (HDM) - Hamadan',            
                'HGA' => 'Hargeisa Airport (HGA) - Hargeisa',            
                'HOF' => 'Hofuf Airport (HOF) - Hofuf',            
                'HYD' => 'Hyderabad Airport (HYD) - Hyderabad',            
                'SAW' => 'Istanbul Sabiha Airport (SAW) - Istanbul',            
                'JED' => 'Jeddah Airport (JED) - Jeddah',            
                'AJF' => 'Jouf Airport (AJF) - Jouf',            
                'JUB' => 'Juba Airport (JUB) - Juba',            
                'KBL' => 'Kabul Airport (KBL) - Kabul',            
                'KHI' => 'Karachi Airport (KHI) - Karachi',            
                'KTM' => 'Kathmandu Airport (KTM) - Kathmandu',            
                'KZN' => 'Kazan Airport (KZN) - Kazan',            
                'KRT' => 'Khartoum Airport (KRT) - Khartoum',            
                'IEV' => 'Zhulyany Airport (IEV) - Kiev',            
                'KGL' => 'Kigali Airport (KGL) - Kigali',            
                'COK' => 'Kochi Airport (COK) - Kochi',            
                'KRR' => 'Krasnodar Airport (KRR) - Krasnodar',            
                'KWI' => 'Kuwait Airport (KWI) - Kuwait',            
                'LRR' => 'Lar Airport (LRR) - Lar',            
                'LJU' => 'Ljubljana (Central bus station) (LJU) - Ljubljana',            
                'LKO' => 'Lucknow Airport (LKO) - Lucknow',            
                'MED' => 'Madinah Airport (MED) - Madinah',            
                'MLE' => 'Male Airport (MLE) - Male',            
                'MHD' => 'Mashhad Airport (MHD) - Mashhad',            
                'HRI' => 'Mattala Airport (HRI) - Mattala',            
                'MRV' => 'Mineralnye Vody Airport (MRV) - Mineralnye Vody',            
                'VKO' => 'Vnukovo Airport (VKO) - Moscow',            
                'MUX' => 'Multan Airport (MUX) - Multan',            
                'BOM' => 'Mumbai Airport (BOM) - Mumbai',            
                'MCT' => 'Muscat Airport (MCT) - Muscat',            
                'NJF' => 'Najaf Airport (NJF) - Najaf',            
                'GOJ' => 'Nizhny Novgorod Airport (GOJ) - Nizhny Novgorod',            
                'ODS' => 'Odessa Airport (ODS) - Odessa',            
                'PZU' => 'Port Sudan Airport (PZU) - Port Sudan',            
                'PRG' => 'Prague Airport (PRG) - Prague',            
                'UET' => 'Quetta Airport (UET) - Quetta',            
                'RUH' => 'Riyadh Airport (RUH) - Riyadh',            
                'ROV' => 'Rostov on Don Airport (ROV) - Rostov on Don',            
                'SLL' => 'Salalah Airport (SLL) - Salalah',            
                'KUF' => 'Samara Airport (KUF) - Samara',            
                'SJJ' => 'Sarajevo Airport (SJJ) - Sarajevo',            
                'SYZ' => 'Shiraz Airport (SYZ) - Shiraz',            
                'CIT' => 'Shymkent Airport (CIT) - Shymkent',            
                'SKT' => 'Sialkot Airport (SKT) - Sialkot',            
                'SKP' => 'Skopje Airport (SKP) - Skopje',            
                'SOF' => 'Sofia Airport (SOF) - Sofia',            
                'TBZ' => 'Tabriz Airport (TBZ) - Tabriz',            
                'TUU' => 'Tabuk Airport (TUU) - Tabuk',            
                'TIF' => 'Taif Airport (TIF) - Taif',            
                'TBS' => 'Tbilisi Airport (TBS) - Tbilisi',            
                'IKA' => 'Tehran Airport (IKA) - Tehran',            
                'TRV' => 'Thiruvananthapuram Airport (TRV) - Thiruvananthapuram',            
                'UFA' => 'Ufa Airport (UFA) - Ufa',            
                'XWC' => 'Vienna (Central train station) (XWC) - Vienna',            
                'YNB' => 'Yanbu Airport (YNB) - Yanbu',            
                'SVX' => 'Yekaterinburg Airport (SVX) - Yekaterinburg',            
                'EVN' => 'Yerevan Airport (EVN) - Yerevan',            
                'ZAG' => 'Zagreb Airport (ZAG) - Zagreb',            
                'ZNZ' => 'Zanzibar Airport (ZNZ) - Zanzibar'           
);




function post_content ($url,$postdata) {
$uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";

$ch = curl_init( $url );
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate");
curl_setopt($ch, CURLOPT_USERAGENT, $uagent);
curl_setopt($ch, CURLOPT_TIMEOUT, 120);
curl_setopt($ch, CURLOPT_FAILONERROR, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_COOKIEJAR, "coo.txt");
curl_setopt($ch, CURLOPT_COOKIEFILE,"coo.txt");

$content = curl_exec( $ch );
$err = curl_errno( $ch );
$errmsg = curl_error( $ch );
$header = curl_getinfo( $ch );
curl_close( $ch );

$header['errno'] = $err;
$header['errmsg'] = $errmsg;
$header['content'] = $content;
return $header;
} 


$Origin = $_POST['Origin'];
$Destination = $_POST['Destination'];
$first_date = $_POST['first_date'];
$period = $_POST['period'];
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
//print_r( $html );
//preg_match(pattern, $html);


if( $curl = curl_init() ) {
	$uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";
	curl_setopt($curl, CURLOPT_URL, 'http://flights.flydubai.com/en/results/');
	curl_setopt($curl, CURLOPT_HEADER, true);
	curl_setopt($curl, CURLOPT_ENCODING, "gzip, deflate");
	curl_setopt($curl, CURLOPT_USERAGENT, $uagent);
	curl_setopt($curl, CURLOPT_COOKIEJAR, "coo.txt");
	curl_setopt($curl, CURLOPT_COOKIEFILE,"coo.txt");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $out = curl_exec($curl);
    preg_match('/RT\(([0-9]+)/', $out, $matches);
    curl_close($curl);
   } 
//echo 'http://flights.flydubai.com/en/results/threedayview/?_='.$matches[1];
if( $curl = curl_init() ) {
	$uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";
	curl_setopt($curl, CURLOPT_URL, 'http://flights.flydubai.com/en/results/threedayview/?_='.$matches[1]);
	curl_setopt($curl, CURLOPT_HEADER, true);
	curl_setopt($curl, CURLOPT_ENCODING, "gzip, deflate");
	curl_setopt($curl, CURLOPT_USERAGENT, $uagent);
	curl_setopt($curl, CURLOPT_COOKIEJAR, "coo.txt");
	curl_setopt($curl, CURLOPT_COOKIEFILE,"coo.txt");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $html = curl_exec($curl);
    curl_close($curl);
   } 

  // echo $html;
  // $out = str_replace(array("\r", "\n", " "),'',$out);


  //  preg_match('/USD<br\/>(.*?)<\/div>/', $out, $matches);

  //  preg_match('/TDFare_1_ODS_BEY_(.*?)\'/', $out, $d);
  // print_r($matches);
  $html = str_get_html($html);
  //$am = $html->find('.dayAmount .showdiv span',0);
  //$am = $am->find('.showdiv span')->innertext;

/*
$file = 'people.txt';
// Открываем файл для получения существующего содержимого
$current = file_get_contents($file);
// Добавляем нового человека в файл
$current .= $am;
// Пишем содержимое обратно в файл
file_put_contents($file, $current);
*/
function next_day(){

if( $curl = curl_init() ) {
    $uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";
    curl_setopt($curl, CURLOPT_URL, 'http://flights.flydubai.com/en/results/');
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_ENCODING, "gzip, deflate");
    curl_setopt($curl, CURLOPT_USERAGENT, $uagent);
    curl_setopt($curl, CURLOPT_COOKIEJAR, "coo.txt");
    curl_setopt($curl, CURLOPT_COOKIEFILE,"coo.txt");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $out = curl_exec($curl);
    preg_match('/RT\(([0-9]+)/', $out, $matches);
    curl_close($curl);
   } 
//echo 'http://flights.flydubai.com/en/results/threedayview/?_='.$matches[1];
if( $curl = curl_init() ) {
    $uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";
    curl_setopt($curl, CURLOPT_URL, 'http://flights.flydubai.com/en/results/threedayview/?_='.$matches[1]);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_ENCODING, "gzip, deflate");
    curl_setopt($curl, CURLOPT_USERAGENT, $uagent);
    curl_setopt($curl, CURLOPT_COOKIEJAR, "coo.txt");
    curl_setopt($curl, CURLOPT_COOKIEFILE,"coo.txt");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $html = curl_exec($curl);
    curl_close($curl);
   } 
   return $html;
}




$day = 0;
while ($day <= $period ) {
    $tr = $html->find('.priceRow',0);

    for($i=0; $i<7; $i++){
        $day++;
        if($day <= $period){

        $elem = $tr->find('td',$i);
        $am = $elem->find('.showdiv span',0);
        if(empty($am)){
             $am = $elem->find('.hidediv span',0);
        }
        $date = substr($elem->id, strripos($elem->id, "_") + 1, strlen($elem->id));
     
?>
            <tr>
                <td><?php echo $airports[$Origin];?></td>
                <td><?php echo $airports[$Destination];?></td>
                <td><?php echo $date;?></td>
                <td><?php echo $period;?></td>
                <td><?php //echo $second_date;?></td>
                <td><?php echo !empty($am)? $am : 'Рейс не найден';?></td>

            </tr>
<?php 
    
        }else{
            break;
        }
    }

    $date = new DateTime($first_date);
    $first_date = $date->format('d');
    $first_date.= '/'.$date->format('m');
    $first_date.= '/'.$date->format('Y');
    $date = new DateTime($first_date);
    $date->modify('+7 day');
    $first_date = $date->format('d/m/Y');

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
}


?>
