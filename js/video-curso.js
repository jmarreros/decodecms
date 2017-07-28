(function($){


	$('.curso-videos #link-1').css('font-weight','bold');
	$('.curso-videos #prev').hide();
	$('.video-actual .ajax-loader').hide();



	$('.curso-videos .temario a').click(function(e){
		e.preventDefault();

		var_url 	= $(this).attr('href');
		var_texto 	= $(this).text();
		var_texto = var_texto.replace(/\(.*\)/, "");

		var_id		= $(this).attr('id');

 		$('.temario a').css('font-weight','');
 		$(this).css('font-weight','bold');

 		( $(this).attr('id')=='link-1' ) ? $('#prev').hide() : $('#prev').show();
 		( $(this).hasClass('link-last') ) ? $('#next').hide() : $('#next').show();

		cambiar_video( var_url, var_texto, var_id);
	});



	$('.curso-videos #next,.curso-videos #prev').click(function(e){
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

		//para videos suscripcion
		if ( $('.video-actual video').length ){

				$('.video-actual video').fadeOut('fast',function(){
					$('.video-actual .ajax-loader').show();
				});

				$('.video-actual').attr('rel',var_id);

				$('.video-actual video').attr('poster',cambiar_portada(var_id));

				$('.video-actual video source').attr('src',var_url);
				$('.video-actual video')[0].load();

				$('.video-actual .titulo').text(var_texto);
				$('.video-actual video').fadeIn('slow', function(){
					$('.video-actual .ajax-loader').hide();
				});

				$("html, body").animate({ scrollTop: 0 }, "slow");
		}

		//para videos youtube
		if ( $('.video-actual .video-youtube').length ){

			$('.video-actual iframe').fadeOut('fast',function(){
				$('.video-actual .ajax-loader').show();
			});

			$('.video-actual').attr('rel',var_id);

			$('.video-actual iframe').attr('src',var_url);

			$('.video-actual .titulo').text(var_texto);
			$('.video-actual iframe').fadeIn('slow', function(){
				$('.video-actual .ajax-loader').hide();
			});

		}


	}



	function cambiar_portada( var_id ){

		if ( $('.video-actual').hasClass('cambiar-portada') ){
			var_numero = var_id.substring(5);
			var_poster = $('.video-actual video').attr('poster');
			var_poster = var_poster.substring(0,var_poster.length-5) + var_numero + '.png';

			return var_poster;
		}

		return "";

	}



})(jQuery);
