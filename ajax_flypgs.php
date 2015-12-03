<?php 


		include "simple_html_dom.php";
		include "lib/air_flypgs.php";

		set_time_limit(9800);
		define('MAX_FILE_SIZE',9000000);


		if(empty($_POST['first_date'])) exit("Дата не введенна");
		if(empty($_POST['Origin'])) exit("Не указан город 1");
		if(empty($_POST['Destination'])) exit("Не указан город 2");
		if(empty($_POST['pback'])) exit("Не указан диапазон");


		$userID = file_get_contents('http://www.flypgs.com/Services/AdaraHandler.ashx');

		//INFO
		$Origin = $_POST['Origin'];
		$Destination = $_POST['Destination'];
		$first_date = $_POST['first_date'];
		
		$C1 = $_POST['с1'];
		$C2 = $_POST['с2'];
		
		
		$period = $_POST['pback'];
		$pback = $_POST['select'];

		$date_dep = DateTime::createFromFormat('d/m/Y',$first_date);
		$date_dep_result= DateTime::createFromFormat('d/m/Y',$first_date);
		
		$date_dep->modify('+7 day');
		$date_ret = $date_dep;
		
		$date_dep= $date_dep->format('d/m/Y');
		
		$cmouth = (int) floor($period / 15) +1;
		
		
		
		for ($j=0; $j < $cmouth; $j++) 
			{ 
				
				
				$date_ret = $date_dep;
				//POST DATA
				$postdata ='CURRENCY=USD&';
				$postdata.='P=1893&';
				$postdata.='LC=RU&';
				$postdata.='userId='.$userID.'&';
				$postdata.='autodest='.$airport[$Origin].'&';
				$postdata.='DEPPORT='.$Origin.'&';
				$postdata.='autodest='.$airport[$Destination].'&';
				$postdata.='ARRPORT='.$Destination.'&';
				$postdata.='TRIPTYPE=R&';
				$postdata.='DEPDATE='.urldecode($date_dep).'&';
				$postdata.='RETDATE='.urldecode($date_ret).'&';
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

				//echo $postdata.'<br>';
				//echo $date_dep.'<br>';
				
				
				$html[] = post_content('https://book.flypgs.com/Common/MemberRezvResultsPreview.jsp?activeLanguage=RU', $postdata);
						
				
				foreach($html as $html_content){
					
					for($i=0;$i<14;$i++){
						$first_date = DateTime::createFromFormat('d/m/Y',$first_date);
						$first_date->modify('+1 day');
						$first_date= $first_date->format('d/m/Y');
						
						if(!empty($html_content->find('div.#containerDep span.price', $i)->innertext)){
							
							$price = $html_content->find('div.#containerDep span.price', $i)->innertext;
							$preprice = trim(str_replace(array("\r\n", "\r", "\n"), " ", $price));
							preg_match('/^(.*)\<sup\>/',$preprice, $price_out);
							$fly_out [$first_date] = $price_out[1];
							
						}
							
						
						if(!empty($html_content->find('div.#containerRet span.price', $i)->innertext)){
							
							$price = $html_content->find('div.#containerRet span.price', $i)->innertext;
							$preprice = trim(str_replace(array("\r\n", "\r", "\n"), " ", $price));
							preg_match('/^(.*)\<sup\>/',$preprice, $price_in);
							$fly_in [$first_date] = $price_in[1];
						}
							
						
						
					}  					
					
					
				}
				
				$date_dep = DateTime::createFromFormat('d/m/Y',$date_dep);
				$date_dep->modify('+7 day');
				$date_dep= $date_dep->format('d/m/Y');
						

		
			}
			
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
                    <td><?=$val?></td>
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
                            <td><?=$fly_in[$date]?></td>
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
        }
    }


?>