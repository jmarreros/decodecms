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


	//To Top
	
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
	$('article.post').each(function(){
		clase	= $(this).attr('class').split(' ').pop();
		color 	= '#' + clase.substring(2);
		$(this).find('.thumbnail').css('background-color',color);

		$('.single-post article .thumbnail').fadeTo(200,1);
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


	//if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
	 	// clonar_widget();
	//}
	
	// function clonar_widget(){
	// 	if ( $(window).width() <=768 )
	// 	{
	// 		$('#text-4').clone().insertBefore('#genesis-content article:first-child()');
	// 	}
	// }

	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		mostrar_boletin_movil();
	}
	
	function mostrar_boletin_movil(){
		if ( $(window).width() <=768 ){
			var tmplBoletin = '<div id="boletin-movil"><a class="wheader" href="http://eepurl.com/b_Sghj"><p>Únete a DecodeCMS</p></a></div>';
			$(tmplBoletin).insertBefore('#genesis-content article:first-child()');
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

})(jQuery);
