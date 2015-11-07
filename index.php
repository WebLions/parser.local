<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="utf-8">
  <title>Parser Settings</title>
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="/js/script.js"></script>
 </head>
 <body>
 
 <div class = "conteiner">
 <form action="" method="post" id="sform">
<div class="row">
  <div class="col-md-10 col-md-offset-1">
<ul class="nav nav-pills">
<br>
  <li id="presentation" onclick="this.className ='active';"><a href="#">flypgs.com</a></li>
  <li id="presentation" onclick="this.className ='active';"><a href="#">flydubai.com</a></li>
  <li id="presentation" onclick="this.className ='active';"><a href="#">etc</a></li>
<button style="float:right;" class="btn btn-primary" id="search" type="submit">Вывести</button>
</ul>


</div>
</div>


<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="input-group">
	<br>
<div class="input-group input-group-sm">

  <span class="input-group-addon" id="sizing-addon3">Город #1</span>
  <input type="text" name="Origin" class="form-control" placeholder="Город #1" aria-describedby="sizing-addon3">
  
  <span class="input-group-addon" id="sizing-addon3">Город #2</span>
  <input type="text" name="Destination" class="form-control" placeholder="Город #2" aria-describedby="sizing-addon3">
  
  <span class="input-group-addon" id="sizing-addon3">Дата #1</span>
  <input type="text" name="first_date" class="form-control" placeholder="Дата #1" aria-describedby="sizing-addon3">
  
  <span class="input-group-addon" id="sizing-addon3">Дата #2</span>
  <input type="text" name="period" class="form-control" placeholder="Дата #2" aria-describedby="sizing-addon3">
  
  <span class="input-group-addon" id="sizing-addon3">Диапазон</span>
  <input type="text" name="pback" class="form-control" placeholder="Диапазон" aria-describedby="sizing-addon3">
</div>
 
 </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->

</div><!-- /.row -->
 
</form>

<div class="row">
  <div class="col-md-10 col-md-offset-1">
  <br>
  </div>
</div>

<div class="row">
  <div class="col-md-10 col-md-offset-1">
  
<table class="table table-striped">
<thead>
 <tr>
 <th>Откуда</th>
 <th>Куда</th>
 <th>Датa вылета</th>
 <th>Период мониторинга</th>
 <th>Дата прибытия</th>
 <th>Цена</th>
 </tr>
 </thead>
 
 <tbody id="result">

 </tbody>
</table>
</div>
</div>


<div class="row">
  <div class="col-md-10 col-md-offset-1">
  
	
	<button class="btn btn-info" type="submit">Печать</button>
	<button class="btn btn-success" type="submit">Сохранить Excel</button>
	
</div>
</div>
</div>

</body>
</html>