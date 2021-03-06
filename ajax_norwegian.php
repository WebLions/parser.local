<?php

include "simple_html_dom.php";
include "lib/air_norwegian.php";
include 'lib/air_ports.php';

$ac1 = explode(",", $_POST['c1']);
$ac2 = explode(",", $_POST['c2']);

foreach ($ac1 as $c1) {
    foreach ($ac2 as $c2) {
        $Origin = trim($c1);
        $Destination = trim($c2);

        $C1 = $air_ports[$c1];
        $C2 = $air_ports[$c2];
        $first_date = $_POST['first_date'];
        $period = $_POST['pback'];

        $start_date = DateTime::createFromFormat('d/m/Y', $first_date);
        $start_date = '01/' . $start_date->format('m/Y');


        $perback = $period + $_POST['select'];
        $pback = $_POST['select'];

        $datetime = DateTime::createFromFormat('d/m/Y', $first_date);
        $D_Day = $datetime->format('d');
        $R_Day = $D_Day;
        $D_Month = $datetime->format('Ym');
        $DL_Month = $D_Month;
        $R_Month = $D_Month;

        $url = "http://www.norwegian.com/us/booking/flight-tickets/farecalendar/?";


        $cmouth = (int)floor($period / 30) + 1;

        for ($j = 0; $j < $cmouth; $j++) {

            $url = "http://www.norwegian.com/us/booking/flight-tickets/farecalendar/?";

            $R_Month = $D_Month;

            $postdata = 'D_City=' . $Origin;
            $postdata .= '&A_City=' . $Destination;
            $postdata .= '&D_SelectedDay=' . $D_Day;
            $postdata .= '&D_Day=' . $D_Day;
            $postdata .= '&D_Month=' . $D_Month;
            $postdata .= '&R_SelectedDay=' . $R_Day;
            $postdata .= '&R_Day=' . $R_Day;
            $postdata .= '&R_Month=' . $R_Month;
            $postdata .= '&CurrencyCode=USD';
            $postdata .= '&TripType=2';

            $url .= $postdata;
            //echo $url."<br>";
//echo "http://www.norwegian.com/us/booking/flight-tickets/farecalendar/?D_City=AAL&A_City=AGA&D_SelectedDay=01&D_Day=01&D_Month=201601&R_SelectedDay=01&R_Day=01&R_Month=201601&CurrencyCode=USD&TripType=2";
            $html[] = post_content($url);
            //echo $html[0];

            $html[0] = str_get_html($html[0]);
            //print_r($html);

            foreach ($html as $html_content) {
                #ctl01_ctl00_MainContentRegion_MainRegion_ctl00_ipcFareCalendarResultOutbound_pnlFareCalendarResult
                $html_content_out = $html_content->find('#ctl01_ctl00_MainContentRegion_MainRegion_ctl00_ipcFareCalendarResultOutbound_pnlFareCalendarResult', 0);
                $html_content_in = $html_content->find('#ctl01_ctl00_MainContentRegion_MainRegion_ctl00_ipcFareCalendarResultInbound_pnlFareCalendarResult', 0);
                //echo 	$html_content_in

                for ($i = 0; $i < 30; $i++) {

                    if (!empty($html_content_out->find('div.fareCalPrice', $i)->innertext) && (($html_content_out->find('div.fareCalPrice', $i)->innertext) != '&nbsp;')) {


                        $price_out = $html_content_out->find('div.fareCalPrice', $i)->innertext;

                        $fly_out [$start_date] = $price_out;

                    }


                    if (!empty($html_content_in->find('div.fareCalPrice', $i)->innertext) && (($html_content_in->find('div.fareCalPrice', $i)->innertext) != '&nbsp;')) {


                        $price_in = $html_content_in->find('div.fareCalPrice', $i)->innertext;

                        $fly_in [$start_date] = $price_in;
                    }

                    $start_date = DateTime::createFromFormat('d/m/Y', $start_date);
                    $start_date->modify('+1 day');
                    $start_date = $start_date->format('d/m/Y');


                }


            }
            if (!empty($fly_out)) {
                foreach ($fly_out as $key => $val) {
                    if (!empty($key)) {
                        ?>
                        <tr>
                            <td>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 3%"></th>
                                        <th style="width: 30%">Откуда</th>
                                        <th style="width: 30%">Куда</th>
                                        <th style="width: 30%">Датa вылета</th>
                                        <th style="width: 7%">Цена</th>
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
                                                <td style="width: 3%" class="ico-left-fly"></td>
                                                <td style="width: 30%"><?= $air_ports[$c2] ?></td>
                                                <td style="width: 30%"><?= $air_ports[$c1] ?></td>
                                                <td style="width: 30%"><?= $date ?></td>
                                                <td style="width: 7%"><?= $fly_in[$date] ?></td>
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
            }else echo "Рейсов нет";

            $D_Month = DateTime::createFromFormat('d/m/Y', $first_date);
            $D_Month->modify('+' . $j . ' month');
            $D_Month = $D_Month->format('Ym');

        }


    }
}


?>