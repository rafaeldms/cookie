<?php

use RafaelDms\Cookie\Cookie;

require __DIR__ . "/assets/config.php";

require dirname(__DIR__, 1) . "/vendor/autoload.php";

/**
 * METHOD CONSTRUCT CLASS
 */

/**
 * Create a new cookie using construct method
 */
$cookie = new Cookie("testCookie");

/**
 * set value a cookie using methot set
 */
$cookie->setValue("123456");

/**
 * set expiryTime
 */
$cookie->setExpiryTime(24 * 60 * 60);

/**
 * set path
 */
$cookie->setPath("/admin");

/**
 * set domain
 */
$cookie->setDomain("https://www.cagep.com.br");

/**
 * set httpOnly to false
 */
$cookie->setHttpOnly(false);

/**
 * set secure only to true
 */
$cookie->setSecureOnly(true);

/**
 * save a cookies
 */
$cookie->saveAndSet();

var_dump($cookie);


/**
 * get value
 */
echo "Value: " . $cookie->getValue();
echo "<br><br>";

/**
 * get expire time
 */
echo "Expire Time: " . $cookie->getExpiryTime();
echo "<br><br>";

/**
 * get path
 */
echo "Path: " .  $cookie->getPath();
echo "<br><br>";

/**
 * get domain
 */
echo "Domain: " .  $cookie->getDomain();
echo "<br><br>";

/**
 * is http only
 */
echo "Http only: " . ($cookie->isHttpOnly() ? 'true' : 'false');
echo "<br><br>";

/**
 * is secure only
 */
echo "Secure only: " . ($cookie->isSecureOnly() ? 'true' : "false");
echo "<br><br>";

/**
 * update value
 */
$cookie->setValue("910111213");

var_dump($cookie);

/*
 * check if exists cookie and delete cookie
 */
if($cookie->hasCookie()){
    var_dump($cookie);
}


/**
 * delele cookie and unset
 */
$cookie->deleteAndUnset();

var_dump($cookie);