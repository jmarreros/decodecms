<?php

add_action( 'genesis_entry_content', 'dcms_show_main_video', 7 );

function dcms_show_main_video(): void {
	$youtube = get_post_meta( get_the_ID(), 'youtube', true );
	if ( ! is_single() || ! $youtube ) {
		return;
	}
	?>

    <p class="aligncenter borde-video-sus">
        <iframe src="https://www.youtube.com/embed/<?= $youtube ?>" width="560" height="315"
                allowfullscreen="allowfullscreen"></iframe>
    </p>
    <div id="youtube-sus">
        <div id="container-sus">
            <div id="text-sus">Suscríbete a DecodeCMS: &nbsp;</div>
            <div id="video-sus">
                <div class="g-ytsubscribe" data-channelid="UC8n5HIV6dt3W-8O7wPcVxZQ" data-layout="default"
                     data-theme="dark" data-count="default"></div>
            </div>
        </div>
    </div>

	<?php
}