<?php

require_once __SITE_PATH . '/app/' . 'controller_base.class.php';

require_once __SITE_PATH . '/app/' . 'registry.class.php';

require_once __SITE_PATH . '/app/' . 'router.class.php';

require_once __SITE_PATH . '/app/' . 'template.class.php';

require_once __SITE_PATH . '/app/database/' . 'db.class.php';

spl_autoload_register( function( $class_name ) 
{
	$filename = strtolower($class_name) . '.class.php';
	$file = __SITE_PATH . '/model/' . $filename;

	if( file_exists($file) === false )
	    return false;

	require_once ($file);
} );

