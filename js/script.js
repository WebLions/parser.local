(function($){
	$(window).load(function(){

	$("#stable").tablesorter();
	
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
		
		var parser = $("#sform").attr('data-ajax');
		
		$.post("/ajax_"+parser+".php", $( "#sform" ).serialize(), function(data){
				$("#result").html(data);
				result = data;
			});
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

	});

})(jQuery);