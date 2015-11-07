(function($){
	$(window).load(function(){

	$("#search").click(function(e){
		$("#result").html('<img src="/img/238.GIF">');

		
		$.post("/ajax_flydubai.php", $( "#sform" ).serialize(), function(data){
				$("#result").html(data);
			});
		return false;
		e.preventdefault();
	});

	});
})(jQuery);