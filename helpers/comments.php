<?php

  function wp_modify_comment_form($arg) {

    $commenter = wp_get_current_commenter();
    $req       = get_option( 'require_name_email' );
    $aria_req  = ( $req ? ' aria-required="true"' : '' );

    $arg['comment_notes_before'] = '';
    $arg['cancel_reply_link'] = '<i class="fa fa-times"></i>';

    
    $arg['comment_field'] =   '<p class="comment-form-comment">' .
                                '<textarea id="comment" name="comment" cols="45" placeholder="Comentarios" rows="6" tabindex="4" aria-required="true"></textarea>' .
                                '<span class="msgcode">'.__('Para escribir código envolver con: ','decodecms').' &lt;pre class="language-xxx"&gt;&lt;code&gt; &lt;/code&gt;&lt;/pre&gt; ,reemplaza las xxx (php, css, html)</span>' ;
                              '</p>'.
    
    $arg['fields']['author']= '<p class="comment-form-author">' .
                                '<label for="author">' . __( 'Name', 'genesis' ) . '</label> ' .
                                '<input id="author" name="author"  placeholder="'.__( 'Name', 'genesis' ).'" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1"' . $aria_req . ' />' .
                                ( $req ? '<span class="required">*</span>' : '' ) .
                              '</p>';

    $arg['fields']['email'] = '<p class="comment-form-email">' .                                
                                '<label for="email">' . __( 'Email', 'genesis' ) . '</label> ' .
                                '<input id="email" name="email" type="email" placeholder="'.__( 'Email', 'genesis' ).'" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" tabindex="2"' . $aria_req . '/>' .
                                ( $req ? '<span class="required">*</span>' : '' ) .
                                ' <span class="msgcode">'.
                                '<a href="https://es.gravatar.com/" target="_blank">'.__('Gravatar habilitado','decodecms').'</a>'.
                                '</span>'.
                              '</p>';

    $arg['fields']['url'] =  '<p class="comment-form-url">' .
                                '<label for="url">' . __( 'Website', 'genesis' ) . '</label>' .
                                '<input id="url" name="url" type="text" placeholder="'. __( 'Website', 'genesis' ).'" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="3" />' .                                
                             '</p>';
                              
    return $arg;
}



add_filter( 'comment_form_defaults', 'wp_modify_comment_form' );



function comment_validation_init() {
if(is_singular() && comments_open() ) { ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(e){e("#commentform").validate({onfocusout:function(e){this.element(e)},rules:{author:{required:!0,minlength:3},email:{required:!0,email:!0},comment:{required:!0,minlength:10}},messages:{author:"Requerido",email:{required:"Requerido",email:"No válido"},comment:{required:"Requerido",minlength:"Mínimo 10 caracteres"}},errorPlacement:function(e,r){}})});
</script>
<?php
}
}

add_action('wp_footer', 'comment_validation_init',20);



add_filter( 'genesis_show_comment_date', 'jmw_remove_comment_time_and_link' );
function jmw_remove_comment_time_and_link( $comment_date ) {
  printf( '<a class="idcomment fa fa-bookmark" href="%s"></a>', esc_url( get_comment_link( $comment->comment_ID ) ) );
  printf( '<p %s>', genesis_attr( 'comment-meta' ) );
  printf( '<time %s>', genesis_attr( 'comment-time' ) );
  echo    esc_html( get_comment_date() );
  echo    '</time></p>';
  
  // Return false so that the parent function doesn't also output the comment date and time
  return false;
}




add_filter( 'comment_author_says_text', 'sp_comment_author_says_text' );
function sp_comment_author_says_text() {
  return '';
}


add_filter( 'comment_form_defaults', 'sp_comment_submit_button' );
function sp_comment_submit_button( $defaults ) {
        $defaults['label_submit'] = __( 'Enviar', 'decodecms' );
        return $defaults;
 
}

//* Modify comments title text in comments
/*
add_filter( 'genesis_title_comments', 'sp_genesis_title_comments' );
function sp_genesis_title_comments() {
  $title = "<h3>".__( 'Discusión', 'decodecms' )."</h3>";
  return $title;
}
*/


add_filter( 'comment_form_defaults', 'sp_comment_form_defaults' );
function sp_comment_form_defaults( $defaults ) {
 
  $defaults['title_reply'] ='';
  return $defaults;
 
}


function custom_comment_reply($content) {
  $content = str_replace('>Responder<', '><i class="fa fa-reply"></i><', $content);
  return $content;
}
add_filter('comment_reply_link', 'custom_comment_reply');





/*
jQuery(document).ready(function($) {

    $('#commentform').validate({

    onfocusout: function(element) {
      this.element(element);
    },
     
    rules: {
      
      author: {
                required: true,
                minlength: 3
              },
     
      email:  {
                required: true,
                email: true
              },
     
      comment:  {
                required: true,
                minlength: 10
                }
    },
     
    messages: {
              author  : "Requerido",
              email   : {
                          required:"Requerido",
                          email:"No válido"
                        },
              comment : {
                          required:"Requerido",
                          minlength:"Mínimo 10 caracteres"
                        }
    },

  errorPlacement: function(error, element) {},
   
    }); //validate
}); //onready
*/
