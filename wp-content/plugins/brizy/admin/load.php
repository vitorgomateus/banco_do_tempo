<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}

add_action( 'wp_loaded', 'brizy_load_admin' );


function brizy_add_dashboard_widgets() {
	try {
		Brizy_Admin_DashboardWidget::_init();
	} catch ( Exception $e ) {
		// ignore this exceptions for now.
	}
}

function brizy_load_admin() {

	try {
		new Brizy_Admin_Capabilities( Brizy_Editor_Storage_Common::instance() );

		if ( is_admin() ) {
			Brizy_Admin_Main::_init();
			Brizy_Admin_Settings::_init();
			Brizy_Admin_Flash::instance()->initialize(); // initialize flash
		}
	} catch ( Exception $exception ) {
		Brizy_Admin_Flash::instance()->add_error( 'Unable to empty the trash. Please try again later.' );
		wp_redirect( $_SERVER['HTTP_REFERER'] );
		exit;
	}

	add_action( 'wp_dashboard_setup', 'brizy_add_dashboard_widgets' );
}
