(function($){
	$(window).load(function(){

	
	
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
		
		
		var parser = $("#sform").attr('data-ajax','flydubai');
		
		$.post("/ajax_"+parser+".php", $( "#sform" ).serialize(), function(data){
				$("#result").html(data);
			});
			return false;
			e.preventdefault();
		});

	});
})(jQuery);