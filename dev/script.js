(function($){

	$( '#genesis-nav-primary' ).before( '<button class="menu-toggle" role="button" aria-pressed="false"></button>' ); // Add toggles to menus
	$( '#genesis-nav-primary .sub-menu' ).before( '<button class="sub-menu-toggle" role="button" aria-pressed="false"></button>' ); // Add toggles to sub menus

	// Show/hide the navigation
	$( '.menu-toggle, .sub-menu-toggle' ).on( 'click', function() {
		var $this = $( this );
		$this.attr( 'aria-pressed', function( index, value ) {
			return 'false' === value ? 'true' : 'false';
		});

		$this.toggleClass( 'activated' );
		$this.next( 'nav, .sub-menu' ).slideToggle( 'fast' );

	});

	//To Tops

	var offset = 300,
	//Scroll (in pixels) after which the "back to top" link opacity is reduced
	offset_opacity = 1200,
	//Duration of the top scrolling animation (in ms)
	scroll_top_duration = 700,
	//Get the "To Top" link
	$back_to_top = $('.to-top');

	//Visible or not "To Top" link
	$(window).scroll(function(){
		( $(this).scrollTop() > offset ) ? $back_to_top.addClass('top-is-visible') : $back_to_top.removeClass('top-is-visible top-fade-out');
		if( $(this).scrollTop() > offset_opacity ) {
			$back_to_top.addClass('top-fade-out');
		}
	});

	//Smoothy scroll to top
	$back_to_top.on('click', function(event){
		event.preventDefault();
		$('body,html').animate({
			scrollTop: 0 ,
		 	}, scroll_top_duration
		);
	});

	//Clonar iconos sociales
	$('.social-icons').clone().appendTo('.site-footer .wrap p');

	//clonar formulario suscripcion
	//$('#text-4').clone().appendTo('#genesis-content');

	//Color fondo de thumbnail
	$('article').each(function(){
		clase	= $(this).attr('class').split(' ').pop();
		color 	= '#' + clase.substring(2);
		$(this).find('.thumbnail').css('background-color',color);

		$('.single-post article .thumbnail').fadeTo(200,1);

    //validación para mostrar o no el thumbnail
    if ( $(this).find('.thumbnail img').length <= 0 ){
        $(this).find('.thumbnail').hide();
        $(this).find('.entry-content').css('margin-left',0);
    }

	});



	// Detectar <=IE11
	if(navigator.userAgent.indexOf('MSIE')!==-1
	|| navigator.appVersion.indexOf('Trident/') > 0){
	   $('body').addClass('cssie');
	}


	//Para los botones de redes sociales
	$('.dc-social a').click(function(event){
		event.preventDefault();

                //popup
                var width  = 575,
                    height = 520,
                    left   = ($(window).width()  - width)  / 2,
                    top    = ($(window).height() - height) / 2,
                    opts   = 'status=1' +
                        ',width='  + width  +
                        ',height=' + height +
                        ',top='    + top    +
                        ',left='   + left;

                window.open($(this).attr("href"), 'share', opts);

	});

	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		mostrar_boletin_movil();
	}

	function mostrar_boletin_movil(){
		if ( $(window).width() <=768 ){
			var tmplBoletin = '<div id="boletin-movil"><a class="wheader" href="http://eepurl.com/b_Sghj"><p>Únete a DecodeCMS</p></a></div>';
			$(tmplBoletin).insertBefore('.home #genesis-content article:first-child()');
		}
	}


	//Tabla de contenido

	if ( $('body.single').length ){

		var tmplwrap ="<div id='tabla-contenido'>\n<p class='titulo'>Tabla de Contenido</p>\n{contenido}</div>";
		var tmpllink = "<p><i class='fa fa-caret-right'></i> <a href={link}>{texto}</a></p>\n";
		var cadena 	= "";

		$('article h2').each(function(index){
			texto 	 	= $(this).text();
			enlace_id	= texto.replace(/\d-\s|\?|¿/g,'');
			enlace_id 	= enlace_id.replace(/\s+/g, '_');

			$(this).attr('id',enlace_id);

			cadena += tmpllink.replace('{link}',"'#" + enlace_id + "'");
			cadena  = cadena.replace('{texto}',texto);

		});

		$('div.rel_posts h3').attr('id','relacionados');
		$('p.borde-video').attr('id','video');
		cadena +="<p><i class='fa fa-link'></i> <a href='#relacionados'>- Artículos relacionados</a></p>\n";
		cadena +="<p><i class='fa fa-video-camera'></i> <a href='#video'>- Video explicativo</a></p>\n";

		cadena = tmplwrap.replace('{contenido}',cadena);

		$(cadena).insertBefore( $('.entry-content h2').first() );
	}


	// cursos
	//--------------
	//Para los cursos, link de cursos
	$('.container-cursos .curso').each(function(){

		$(this).css( 'cursor', 'pointer' );

		$(this).click(function(){
			enlace = $(this).find('.container-img a').attr('href');
			window.location.href = enlace;
		});

	});


	//pantalla detalle cursos
  mostrar_notas('link-1');
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


  function mostrar_notas(var_link){

    var_link = '.' + var_link;

    $('.curso-videos .notas-video > div').hide();

    if ( $('.curso-videos .notas-video').find(var_link).length ){
      $('.curso-videos .notas-video').show();
      $('.curso-videos .notas-video').find(var_link).show();
    }
    else{
      $('.curso-videos .notas-video').hide();
    }

  }

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

    mostrar_notas(var_id);

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
	//--------------
	//Fin cursos



})(jQuery);
