<?php 


include "simple_html_dom.php";
include "lib/air_flypgs.php";

set_time_limit(9800);
define('MAX_FILE_SIZE',9000000);


$userID = file_get_contents('http://www.flypgs.com/Services/AdaraHandler.ashx');


function post_content ($url,$postdata) {
	
$uagent = "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36";

$ch = curl_init( $url );
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, false);
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

return $content;
} 


$Origin = $_POST['Origin'];
$Destination = $_POST['Destination'];
$first_date = $_POST['first_date'];
$period = $_POST['pback'];
$pback = $_POST['pback'];

$day = (int)substr($first_date, 0, 2);
$day_rest = substr($first_date, 2, 10);

$day+=$pback;

$pback = (string)$day.$day_rest;

$day = (int)substr($first_date, 0, 2);
//echo $pback;



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

$html = post_content('https://book.flypgs.com/Common/MemberRezvResultsPreview.jsp?activeLanguage=RU', $postdata);



for ($x=-1; $x++<$period;) 
{
	
	//echo $html->find('div.item',$x);
	
	$price = $html->find('div.relative span.price',$x);
	
	$C1 = $html->find('span.start',0);
	$C2 = $html->find('span.end',0);
	
	$date = ((int)$day + $x);
	$date.=$day_rest;
	preg_match("/\">(.*?)<sup>/", trim($price), $price);
		
?>	
			<tr>
                <td><?php echo $C1;?></td>
                <td><?php echo $C2;?></td>
                <td><?php echo $date;?></td>
                <td><?php echo $period;?></td>
                <td><?php echo !empty($price)? $price[1]: 'Рейс не найден';?></td>
								
            </tr>
			
<?php	
}
//print_r($html);
?>
