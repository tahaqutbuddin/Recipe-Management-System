<?php

// for developer
define("HOST", "localhost");     // The host you want to connect to.
define("USER", "root");    // The database username. 
define("PASSWORD", "");    // The database password. 
define("DATABASE", "hannah2");    // The database name

// when site is public
// define("HOST", "localhost");     // The host you want to connect to.
// define("USER", "d035927f");    // The database username. 
// define("PASSWORD", "XArHuFPJsyLwgF6f");    // The database password. 
// define("DATABASE", "d035927f");    // The database name


// Google API configuration
define("GOOGLE_CLIENT_ID" , "");
define("GOOGLE_CLIENT_SECRET","");
define("GOOGLE_REDIRECT_URL","");

// Facebook API configuration
define('FB_APP_ID', '');
define('FB_APP_VERSION','v10.0');
define('FB_APP_SECRET', '');
define('FB_REDIRECT_URL', '');

// Start session
if(!session_id()){
    session_start();
}

?>
