<?php
include "simple_html_dom.php";


$html = $_POST['data'];

$title = $_POST['title'];

$html = str_get_html($html);

  require_once 'exel/Classes/PHPExcel.php'; // Подключаем библиотеку PHPExcel
  $phpexcel = new PHPExcel(); // Создаём объект PHPExcel
  /* Каждый раз делаем активной 1-ю страницу и получаем её, потом записываем в неё данные */
  $page = $phpexcel->setActiveSheetIndex(0); // Делаем активной первую страницу и получаем её

$mas = array('A','B','C','D','E','F');
$i = 0; $j = 1;

foreach ($html->find('tr') as $elem) {
	foreach ($elem->find('td') as $val) {
		$page->setCellValue( $mas[$i].$j , $val->innertext);
		//echo $mas[$i].$j;
		$i++;
	}
	$j++;
	$i=0;
}

  $page->setTitle($title); // Заголовок делаем "Example"
  /* Начинаем готовиться к записи информации в xlsx-файл */
  $objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
  /* Записываем в файл */
  $name = time()."_".$title.".xlsx";

  $objWriter->save( $name);

 echo $name;