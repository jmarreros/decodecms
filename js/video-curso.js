(function($){
	
	$('#link-1').css('font-weight','bold');
	$('#prev').hide();

	$('.temario a').click(function(e){
		e.preventDefault();
		
		var_url 	= $(this).attr('href');
		var_texto 	= $(this).text();
		var_id		= $(this).attr('id');
 		
 		$('.temario a').css('font-weight','');
 		$(this).css('font-weight','bold');

 		( $(this).attr('id')=='link-1' ) ? $('#prev').hide() : $('#prev').show();
 		( $(this).attr('id')=='link-8' ) ? $('#next').hide() : $('#next').show();

		cambiar_video( var_url,var_texto, var_id);
	});

	$('#next,#prev').click(function(e){
		e.preventDefault();

		var_id 		= $('.video-actual ').attr('rel');

		if ( $(this).attr('id') == "next" ){
			id_valor 	= parseInt(var_id.substring(5)) + 1;
		}
		else{
			id_valor 	= parseInt(var_id.substring(5)) - 1 ;
		}

		$('#link-'+id_valor).trigger('click');
	});


	function cambiar_video( var_url, var_texto, var_id ){

		$('.video-actual ').attr('rel',var_id);
		$('.video-actual video source').attr('src',var_url);
		$('.video-actual video')[0].load();

		$('.video-actual .seccion:first-child').text(var_texto);
		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

})(jQuery);
