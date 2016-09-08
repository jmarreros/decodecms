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
	 	clonar_widget();
	//}
	
	function clonar_widget(){
		if ( $(window).width() <=768 )
		{
			$('#text-4').clone().insertBefore('.home #genesis-content article:first-child()');
		}
	}	



})(jQuery);
