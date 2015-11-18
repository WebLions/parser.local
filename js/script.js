(function($){
	$(window).load(function(){

	$('.datepicker').datepicker({
		format: 'dd/mm/yyyy'
	});
	
	$(".select-parser").click(function(){
		
		$("#sform").attr('data-ajax',$(this).attr('data-id'));
		
		if(!$(this).hasClass('active')){
		
			$(".select-parser").each(function(){
				
			$(this).removeClass('active');	
				
				
			});
			$(this).addClass('active');
			
		};
		
		
		return false;		
	});
	
	
	$("#search").click(function(e){

		$("#result").html('<img src="/img/238.GIF">');
		if($('#city-2').val()=="911"){
			$("#result").html('<div id="boom"><img src="/img/911.gif"></div>');
			var audio = new Audio(); // Создаём новый элемент Audio
			  audio.src = '../img/911.mp3'; // Указываем путь к звуку "клика"
			  audio.autoplay = true;
		}else{
		var parser = $("#sform").attr('data-ajax');
		
		$.post("/ajax_"+parser+".php", $( "#sform" ).serialize(), function(data){
				$("#result").html(data);
				result = data;
			});
		}	
			return false;
			e.preventdefault();
	});

	$("#save").click(function(){

		$(".save").html('Сохранение: <img src="/img/238.GIF">');

		var data = result;
		var title = $("#sform").attr('data-ajax');

		$.post("/save_exel.php", {data: data, title: title}, function(data){

				$(".save").html('<a class="btn btn-info" href="'+data+'" >Скачать</a>');
			});
			return false;
			e.preventdefault();

	});

	$(".add-city-1").click(function () {
		if($("#sform").attr('data-ajax') == 'flydubai'){
			var search = $(this).val;
			$.post("get_airflydubai.php", {search: search}, function(data){
				$("#select-1 ul").html(data);
				$("#select-1").css("display","block");
			});
		}
	});
	$( "#airlist" ).delegate( "li", "click", function() {
		if($("#sform").attr('data-ajax') == 'flydubai'){
			$("#select-1").css("display","none");
			$('#city-1-ata').val( $(this).attr('data-ata') );
			$('.city-list-1').append( '<span class="city">' + $(this).html() +'<a href="#" class="del-city">X</a></span>' );
		}
	});
	$( ".city-list-1" ).delegate(".city .del-city", "click", function(){
		$(this).parent().remove();
	});

  });

})(jQuery);