<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="utf-8">
  <title>Parser Settings</title>
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="/js/themes/blue/style.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="/js/jquery.tablesorter.min.js"></script>
  <script src="/js/script.js"></script>
  <link href="bootstrap/css/style.css" rel="stylesheet">
 </head>
 <body>
 
 <div class = "conteiner" style="width:1100px; margin:0 auto;">
 <form action="" method="post" id="sform" data-ajax="flypgs">
<div class="row">
  <div class="col-md-12">
<ul class="nav nav-pills">
<br>
  <li class="select-parser active" data-id="flypgs" ><a href="#">flypgs.com</a></li>
  <li class="select-parser" data-id="flydubai"><a href="#">flydubai.com</a></li>
  <li class="select-parser" data-id="wizzair" ><a href="#">wizzair.com</a></li>
  <li class="select-parser" data-id="norwegian"><a href="#">norwegian.no</a></li>
  <li class="select-parser" data-id="etc" ><a href="#">etc</a></li>
<button style="float:right;" class="btn btn-primary" id="search" type="submit">Вывести</button>
</ul>


</div>
</div>


<div class="row">
  <div class="col-md-12">
    <div class="input-group">
	<br>
<div class="input-group input-group-sm">

  <span class="input-group-addon" id="sizing-addon3">Город #1</span>
  <input type="text" name="Origin" id="city-1" class="form-control" placeholder="Город #1" aria-describedby="sizing-addon3">
  <input type="hidden" name="Origins" id="city-1-ata" value="">
  <div id="select-1" style="display:none"><ul id="airlist"></ul></div>

  <span class="input-group-addon" id="sizing-addon3">Город #2</span>
  <input type="text" name="Destination" class="form-control" placeholder="Город #2" aria-describedby="sizing-addon3">
  
  <span class="input-group-addon" id="sizing-addon3">Дата #1</span>
  <input type="text" name="first_date" class="form-control" placeholder="Дата #1" aria-describedby="sizing-addon3">
  
 <span class="input-group-addon" id="sizing-addon3">Диапазон</span>
  <input type="text" name="pback" class="form-control" placeholder="Колличество дней" aria-describedby="sizing-addon3">
  
  <span class="input-group-addon" id="sizing-addon3">Обратный рейс</span>
  <select name="select" class="selectpicker form-control" style="padding:5px 0px;">
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
  
<table class="table table-striped" id="stable"  class="tablesorter">
<thead>
 <tr>
 <th></th>
 <th>Откуда</th>
 <th>Куда</th>
 <th>Датa вылета</th>
 <th>Период мониторинга</th>
 <!-- <th>Дата прибытия</th> -->
 <th>Цена</th>
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

</body>
</html>