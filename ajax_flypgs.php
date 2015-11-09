<?php 
define('MAX_FILE_SIZE',9000000);
include "simple_html_dom.php";
set_time_limit(9800);
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


$userID = file_get_contents('http://www.flypgs.com/Services/AdaraHandler.ashx');


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
$content = str_get_html($content);
print_r($content);
echo $content->find('div.relative span.flightPrice',0);
return $content;
} 


$Origin = $_POST['Origin'];
$Destination = $_POST['Destination'];
$first_date = $_POST['first_date'];
$period = $_POST['period'];
$pback = $_POST['pback'];
//echo $period;




$ReturnDate = $second_date;

$postdata ='CURRENCY=USD&';
$postdata.='P=1893&';
$postdata.='LC=RU&';
$postdata.='userId='.$userID.'&';
$postdata.='autodest='.$airport[$Origin].'&';
$postdata.='DEPPORT='.$Origin.'&';
$postdata.='autodest='.$airport[$Destination].'&';
$postdata.='ARRPORT='.$Destination.'&';
$postdata.='TRIPTYPE=R&';
$postdata.='DEPDATE='.$first_date.'&';
$postdata.='RETDATE='.$period.'&';
$postdata.='ADULT=1&';
$postdata.='CHILD=0&';
$postdata.='INFANT=0&';
$postdata.='STUDENT=0&';
$postdata.='SOLDIER=0&';
$postdata.='clickedButton=btnSearch&';
$postdata.='resetErrors=T&';
$postdata.='TXT_PNR_NO_CHECKIN=&';
$postdata.='TXT_NAME_CHECKIN=&';
$postdata.='TXT_SURNAME_CHECKIN=&';
$postdata.='TXT_PNR_NO=&';
$postdata.='TXT_SURNAME=&';
$postdata.='TXT_PNR_NO_edit=&';
$postdata.='TXT_SURNAME_edit=&';
$postdata.='TXT_PNR_NO_baggage=&';
$postdata.='TXT_SURNAME_baggage=&';
$postdata.='TXT_PNR_NO_s=&';
$postdata.='TXT_SURNAME_s=&';
$postdata.='TXT_PNR_NO=&';
$postdata.='TXT_SURNAME=&';
$postdata.='TXT_PNR_NO_insurance=&';
$postdata.='TXT_SURNAME_insurance=&';
$postdata.='TXT_PNR_NO_sports=&';
$postdata.='TXT_SURNAME_sports=&';
$postdata.='__VIEWSTATEGENERATOR=967A6D11';

//echo $postdata;

$html = post_content('https://book.flypgs.com/Common/MemberRezvResults.jsp?activeLanguage=RU', $postdata);

//print_r($html);
?>
