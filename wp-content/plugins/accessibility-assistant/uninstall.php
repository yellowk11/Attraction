<?php

	// If uninstall is not called from WordPress, exit

	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {

	    exit();

	}

	delete_option( 'accessibility_install');