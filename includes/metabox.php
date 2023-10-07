<?php

// Add metabox for level, related and youtube video metadata

add_action( 'add_meta_boxes', 'dcms_add_custom_box' );
function dcms_add_custom_box(): void {
	add_meta_box(
		'dcms_custom_box_id',
		'Meta dada Info',
		'dcms_custom_box_html',
		'post',
		'side'
	);
}

function dcms_custom_box_html(): void {
	$nivel        = get_post_meta( get_the_ID(), 'Nivel', true );
	$relacionados = get_post_meta( get_the_ID(), 'relacionados', true );
	$youtube      = get_post_meta( get_the_ID(), 'youtube', true );
	?>
    <style>
        .dcms_custom_box label {
            display: block;
        }

        .dcms_custom_box input,
        .dcms_custom_box select {
            min-width: 210px;
        }
    </style>
    <p class="dcms_custom_box">
        <label for="nivel">Nivel:</label> <select name="nivel" id="nivel">
            <option value="Básico" <?php selected( $nivel, 'Básico' ); ?>>Básico</option>
            <option value="Intermedio" <?php selected( $nivel, 'Intermedio' ); ?>>Intermedio</option>
            <option value="Avanzado" <?php selected( $nivel, 'Avanzado' ); ?>>Avanzado</option>
        </select>
    </p>
    <p class="dcms_custom_box">
        <label for="relacionados">Relacionados:</label>
        <input name="relacionados" id="relacionados" type="text" value="<?= $relacionados ?>">
    </p>
    <p class="dcms_custom_box">
        <label for="youtube">YouTube:</label>
        <input name="youtube" id="youtube" type="text" value="<?= $youtube ?>">
    </p>
	<?php
}

add_action( 'save_post', 'dcms_save_custom_box_html' );
function dcms_save_custom_box_html( $post_id ): void {
	if ( array_key_exists( 'nivel', $_POST ) &&
	     array_key_exists( 'relacionados', $_POST ) &&
	     array_key_exists( 'youtube', $_POST ) ) {

		update_post_meta( $post_id, 'Nivel', $_POST['nivel'] );
		update_post_meta( $post_id, 'relacionados', $_POST['relacionados'] );
		update_post_meta( $post_id, 'youtube', $_POST['youtube'] );
	}
}