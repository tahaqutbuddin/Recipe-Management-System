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
define("GOOGLE_CLIENT_ID" , "1081573984725-etu33sc86b78biarf409njk4vvjtaivo.apps.googleusercontent.com");
define("GOOGLE_CLIENT_SECRET","XzRa0Z9ho12XSHl5zaFwC231");
define("GOOGLE_REDIRECT_URL","https://chef.flavourflip.de/googlelogin/redirect.php");

// Facebook API configuration
define('FB_APP_ID', '1384360135257914');
define('FB_APP_VERSION','v10.0');
define('FB_APP_SECRET', '534370044b6397da07695635b2e69fdc');
define('FB_REDIRECT_URL', 'https://chef.flavourflip.de/facebooklogin/redirect.php');

// Start session
if(!session_id()){
    session_start();
}

?>