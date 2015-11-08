<?php 
include "simple_html_dom.php";
$airports = array(
					'ADA' => 'Adana',
					'GZP' => 'Alanya - Gazipasa',
					'ALA' => 'Almaty',
					'MZH' => 'Amasya-Merzifon',
					'AMS' => 'Amsterdam',
					'ESB' => 'Ankara',
					'AYT' => 'Antalya',
					'ATH' => 'Athens',
					'BGW' => 'Baghdad',
					'BAH' => 'Bahrain',
					'EDO' => 'Balikesir-Edremit',
					'BCN' => 'Barcelona',
					'BSL' => 'Basel - Mulhouse',
					'BAL' => 'Batman',
					'BEY' => 'Beirut',
					'BEG' => 'Belgrade',
					'SXF' => 'Berlin-Schonefeld',
					'FRU' => 'Bishkek',
					'BJV' => 'Bodrum',
					'BLQ' => 'Bologna',
					'CRL' => 'Brussels-Charleroi',
					'OTP' => 'Bucharest-Otopeni',
					'BUD' => 'Budapest',
					'CGN' => 'Cologne',
					'CPH' => 'Copenhagen',
					'DLM' => 'Dalaman',
					'DEL' => 'Delhi',
					'DNZ' => 'Denizli',
					'DIY' => 'Diyarbakir',
					'DOH' => 'Doha',
					'DXB' => 'Dubai',
					'DUS' => 'Dusseldorf',
					'EZS' => 'Elazig',
					'EBL' => 'Erbil',
					'ERC' => 'Erzincan',
					'ERZ' => 'Erzurum',
					'FRA' => 'Frankfurt - Main',
					'GZT' => 'Gaziantep',
					'GVA' => 'Geneva',
					'HAM' => 'Hamburg',
					'HAJ' => 'Hannover',
					'HTY' => 'Hatay',
					'HRG' => 'Hurghada',
					'IST_SAW' => 'Istanbul All',
					'IST' => 'Istanbul-Ataturk',
					'SAW' => 'Istanbul-S.Gokcen',
					'ADB' => 'Izmir',
					'KCM' => 'Kahramanmaras',
					'KSY' => 'Kars',
					'KFS' => 'Kastamonu',
					'ASR' => 'Kayseri',
					'HRK' => 'Kharkiv',
					'KYA' => 'Konya',
					'KRR' => 'Krasnodar',
					'KUT' => 'Kutaisi',
					'KWI' => 'Kuwait',
					'ECN' => 'Lefkosa - N. Cyprus',
					'LEJ' => 'Leipzig',
					'STN_LHR_LGW' => 'London All',
					'LGW' => 'London-Gatwick',
					'STN' => 'London-Stansted',
					'LWO' => 'Lviv',
					'LYS_EBU' => 'Lyon All',
					'EBU' => 'Lyon-Saint Etienne',
					'LYS' => 'Lyon-Saint Exupery',
					'MAD' => 'Madrid - Barajas',
					'MCX' => 'Makhachkala',
					'MLX' => 'Malatya',
					'MQM' => 'Mardin',
					'MRS' => 'Marseille',
					'BGY_MXP' => 'Milan All',
					'BGY' => 'Milan-Bergamo',
					'MXP' => 'Milan-Malpensa',
					'MRV' => 'Mineralnye Vody',
					'DME' => 'Moscow - Domodedovo',
					'MUC' => 'Munich',
					'FMO' => 'Munster',
					'MSR' => 'Mus',
					'NAV' => 'Nevsehir',
					'NCE' => 'Nice',
					'OVB' => 'Novosibirsk',
					'NUE' => 'Nuremberg',
					'OGU' => 'Ordu-Giresun',
					'OSS' => 'Osh',
					'OSL' => 'Oslo',
					'VDA' => 'Ovda',
					'ORY' => 'Paris-Orly(Sud)',
					'PRG' => 'Prague',
					'PRN' => 'Pristina',
					'FCO' => 'Rome-Fiumicino',
					'SZF' => 'Samsun',
					'GNY' => 'Sanliurfa',
					'SJJ' => 'Sarajevo',
					'SSH' => 'Sharm el-Sheikh',
					'VAS' => 'Sivas',
					'SKP' => 'Skopje',
					'ARN' => 'Stockholm - Arlanda',
					'STR' => 'Stuttgart',
					'TBS' => 'Tbilisi',
					'IKA' => 'Tehran - IKA',
					'TLV' => 'Tel Aviv - Ben Gurion',
					'TIA' => 'Tirana',
					'TZX' => 'Trabzon',
					'URC' => 'Urumqi',
					'VAN' => 'Van',
					'VIE' => 'Vienna',
					'SVX' => 'YEKATERINBURG',
					'OZH' => 'Zaporizhia',
					'ZRH' => 'Zurich'
				);

				
function post_content ($url,$postdata) {
$uagent = "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36";

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

$postdata = 'CURRENCY=EUR&'
$postdata.='P=1893&'
$postdata.='LC=RU&'
$postdata.='userId=d32ce38f275bd6965dac92a12f10bbe6&pg=hp&'
$postdata.='autodest='.$airport[$Origin].'&'
$postdata.='DEPPORT='.$Origin.'&'
$postdata.='autodest='.$airport[$Destination].'&'
$postdata.='ARRPORT='.$Destination.'&'
$postdata.='TRIPTYPE=R&'
$postdata.='DEPDATE='.$first_date.'&'
$postdata.='RETDATE='.$ReturnDate.'&'
$postdata.='ADULT=1&'
$postdata.='CHILD=0&'
$postdata.='INFANT=0&'
$postdata.='STUDENT=0&'
$postdata.='SOLDIER=0&'
$postdata.='clickedButton=btnSearch&'
$postdata.='resetErrors=T&'
$postdata.='TXT_PNR_NO_CHECKIN=&'
$postdata.='TXT_NAME_CHECKIN=&'
$postdata.='TXT_SURNAME_CHECKIN=&'
$postdata.='TXT_PNR_NO=&'
$postdata.='TXT_SURNAME=&'
$postdata.='TXT_PNR_NO_edit=&'
$postdata.='TXT_SURNAME_edit=&'
$postdata.='TXT_PNR_NO_baggage=&'
$postdata.='TXT_SURNAME_baggage=&'
$postdata.='TXT_PNR_NO_s=&'
$postdata.='TXT_SURNAME_s=&'
$postdata.='TXT_PNR_NO=&'
$postdata.='TXT_SURNAME=&'
$postdata.='TXT_PNR_NO_insurance=&'
$postdata.='TXT_SURNAME_insurance=&'
$postdata.='TXT_PNR_NO_sports=&'
$postdata.='TXT_SURNAME_sports=&'
$postdata.='__VIEWSTATEGENERATOR=967A6D11'


echo $postdata
//$postdata = urlencode($postdata);
//$html = post_content('http://flights.flydubai.com/en/flights/search/', $postdata);
				
?>
