<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="utf-8">
  <title>Parser Settings</title>
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="js/themes/blue/style.css" rel="stylesheet">
    <link href="bootstrap/css/style.css" rel="stylesheet">
  <link href="bootstrap/datepicker/css/datepicker.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="bootstrap/datepicker/js/bootstrap-datepicker.js"></script>

 </head>
 <body>
 
 <div class = "conteiner" style="width:1000px; margin:0 auto;">
 <form action="" method="post" id="sform" data-ajax="flypgs">
<div class="row">
  <div class="col-md-12">
<ul class="nav nav-pills">
<br>
  <li class="select-parser active" data-id="flypgs" ><a href="#">flypgs.com</a></li>
  <li class="select-parser" data-id="flydubai"><a href="#">flydubai.com</a></li>
  <li class="select-parser" data-id="wizzair" ><a href="#">wizzair.com</a></li>
  <li class="select-parser" data-id="norwegian"><a href="#">norwegian.no</a></li>
  <li class="select-parser" data-id="airbaltic"><a href="#">airbaltic.com</a></li>
  <li class="select-parser" data-id="IATA" ><a href="#">etc</a></li>
<button style="float:right;" class="btn btn-primary" id="search" type="submit">Вывести</button>
</ul>


</div>
</div>


<div class="row">
  <div class="col-md-12">
    <div class="input-group">
	
	<br>

 <div class="input-group input-group-sm">
  <input type="hidden" name="Origin" id="city-1"> 
  <input type="hidden" name="Destination" id="city-2"> 
 
  <span class="input-group-addon" id="sizing-addon3">Город #1</span>
  <input autocomplete="off" type="text" id = "c1" name="c1" class="form-control" placeholder="Город #1" aria-describedby="sizing-addon3" required>

  <div id = "info1" style = "position:absolute;background-color:#428BCA; height:200px;width:141px;z-index: 1;display:none;">
	<ul style = "color:#FFFFFF;list-style-type: none;margin-left: 5px;padding-left: 5px;margin-top: 20px;padding-top: 20px" id="country_id1">
			
	</ul>
  </div>

     <span class="input-group-addon ico-right-fly change-fly" id = "sweg" style=""></span>
  
  <span class="input-group-addon" id="sizing-addon3">Город #2</span>
  <input autocomplete="off" type="text" id="c2" name="c2" class="form-control" placeholder="Город #2" aria-describedby="sizing-addon3" required>
  <div id = "info2" style = "position:absolute;background-color:#428BCA; height:200px;width:141px;z-index: 1;display:none;" >
	<ul style = "color:#FFFFFF;list-style-type: none;margin-left: 5px;padding-left: 5px;margin-top: 20px;padding-top: 20px" id="country_id2">
		
	</ul>
  </div>
  
    
  <span class="input-group-addon" id="sizing-addon3">Дата #1</span>
  <input type="text" name="first_date" class="form-control datepicker" data-provide="datepicker" placeholder="Дата #1" aria-describedby="sizing-addon3" required>
 
  
  
  <span class="input-group-addon" id="sizing-addon3">Диапазон</span>
  <input type="text" name="pback" class="form-control" placeholder="Колличество дней" aria-describedby="sizing-addon3" required>
 
	
 
  <span class="input-group-addon" id="sizing-addon3">Обратный рейс</span>
  <select name="select" class="selectpicker form-control" style="padding:5px 0px;" required>
    <option>1</option> 
    <option>2</option>
    <option>3</option>
    <option>4</option>
    <option>5</option>
    <option>6</option>
    <option>7</option>
    <option>8</option>
    <option>9</option>
    <option>10</option>
    <option>11</option>
    <option>12</option>
    <option>13</option>
    <option>14</option>
  </select>
 
</div>
 
 </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->

</div><!-- /.row -->
 
</form>

<div class="row">
  <div class="col-md-12">
  <br>
  </div>
</div>
<div class="row">
  <div class="col-md-12">

<div class="progress hidden">
  <div class="progress-bar" role="progressbar" aria-valuenow="70"
  aria-valuemin="0" aria-valuemax="100" style="width:70%">
    <span class="sr-only">70% Complete</span>
  </div>
</div>

  <a href="#" id="trigger-l">Сортировать по цене</a>
  <a href="#" id="clear">Очистить</a>
<table class="tablesorter table table-striped" id="myTable">
         <thead>
         <tr>
         <th></th>
         <th></th>
         </tr>
         </thead>
 <tbody id="result">

 </tbody>
</table>
</div>
</div>


<div class="row">
  <div class="col-md-12">
  
	
	<button class="btn btn-info" type="submit" onclick="javascript:window.print(); void 0;">Печать</button>
	<button class="btn btn-success" type="submit" id="save">Сохранить Excel</button>
  <span class="save"></span>
	
</div>
</div>
</div>
  <script type="text/javascript" src="js/jquery.tablesorter.js"></script> 
    <script src="js/script.js"></script>
</body>
</html>
