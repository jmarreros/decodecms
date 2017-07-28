<?php


function dc_social_sharing_buttons($content) 
{
	if( is_single() )
	{
		$cad			='';
		$plantilla		='
		 <a class="dc-link dc-twitter" href="{twitter}" target="_blank"><i class="fa fa-twitter"></i> Twittear</a>'.
		'<a class="dc-link dc-facebook" href="{facebook}" target="_blank"><i class="fa fa-facebook"></i> Compartir</a>'.
		'<a class="dc-link dc-googleplus" href="{google}" target="_blank"><i class="fa fa-google-plus"></i> Compartir</a>'.
		'<a class="dc-link dc-linkedin" href="{linkedin}" target="_blank"><i class="fa fa-linkedin"></i> LinkedIn</a>'.
		'<a class="dc-link dc-whatsapp" href="{whatsapp}" target="_blank"><i class="fa fa-whatsapp"></i> WhatsApp</a>';

		$urlArticulo 	= urlencode(get_permalink());
 		$titleArticulo 	= str_replace( ' ', '%20', get_the_title());

		// Urls
		$twitterURL	= 'https://twitter.com/intent/tweet?text='.$titleArticulo.'&amp;url='.$urlArticulo.'&amp;via=DecodeCMS';
		$facebookURL= 'https://www.facebook.com/sharer/sharer.php?u='.$urlArticulo;
		$googleURL 	= 'https://plus.google.com/share?url='.$urlArticulo;
		$whatsappURL= 'whatsapp://send?text='.$titleArticulo . ' ' . $urlArticulo;
		$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$urlArticulo.'&amp;title='.$titleArticulo;
 
		$ar_buscar 		= array('{twitter}','{facebook}','{google}','{linkedin}','{whatsapp}');
		$ar_reemplazar 	= array($twitterURL,$facebookURL,$googleURL,$linkedInURL,$whatsappURL);

		$cad	.= '<div class="dc-social">';
		$cad	.= '<p>¿Me ayudas a llegar a más gente?</p>';
		$cad	.=  str_replace($ar_buscar, $ar_reemplazar, $plantilla);
		$cad	.= '</div>';

		$content = $cad.$content;
		$content .= $cad;

		return $content;
	}
	else
	{
		return $content;
	}
};

add_filter( 'the_content', 'dc_social_sharing_buttons',0);