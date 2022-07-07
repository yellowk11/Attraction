<?php
$core   = new \Bvi\Core\Core();
$option = $core->getOption();

if ( ! empty( $option['bviActive'] ) && filter_var( $option['bviActive'], FILTER_VALIDATE_BOOLEAN ) ) {

	add_action( 'widgets_init', function () {
		register_widget( '\\Bvi\\Core\\Widget' );
	} );
}