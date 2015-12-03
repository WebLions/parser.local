<?php
include "simple_html_dom.php";


$html = $_POST['data'];

$title = $_POST['title'];

$html = str_get_html($html);

  require_once 'exel/Classes/PHPExcel.php'; // Подключаем библиотеку PHPExcel
  $phpexcel = new PHPExcel(); // Создаём объект PHPExcel
  /* Каждый раз делаем активной 1-ю страницу и получаем её, потом записываем в неё данные */
  $page = $phpexcel->setActiveSheetIndex(0); // Делаем активной первую страницу и получаем её
  $phpexcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
  $phpexcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
  $phpexcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
  $phpexcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
  $phpexcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
  $phpexcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$mas = array('A','B','C','D','E','F');
$i = 0; $j = 1;
//echo $html;
foreach ($html->find('tr.flyline') as $elem) {
  //9echo $elem->innertext;
  
  $table = $elem->find('tbody',0);
  $table = $elem->find('td',0);

  //$table = $table->find('table',0);
  //$table = $table->find('tbody');
  //echo $table;
  
	foreach ($table->find('tbody > tr') as $val) {
    foreach ($val->find('td') as $value) { 
      $page->setCellValue( $mas[$i].$j , $value->innertext);
      //echo $mas[$i].$j;
      $i++;
    }
    $i=0;
    $j++;
  }
  $table = $elem->find('td',0)->find('table',1);
  foreach ($table->find('tbody > tr') as $val) {
    foreach ($val->find('td') as $value) { 
      $page->setCellValue( $mas[$i].$j , $value->innertext);
      //echo $mas[$i].$j;
      $i++;
    }
    $j++;
    $i=0;
  }
}

  $page->setTitle($title); // Заголовок делаем "Example"
  /* Начинаем готовиться к записи информации в xlsx-файл */
  $objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
  /* Записываем в файл */
  $name = time()."_".$title.".xlsx";

  $objWriter->save( $name);

 echo $name;