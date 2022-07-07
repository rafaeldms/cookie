<?php


require __DIR__ . "/assets/config.php";

require dirname(__DIR__, 1) . "/vendor/autoload.php";

use RafaelDms\Cookie\StaticCookie;
use RafaelDms\Cookie\Cookie;

/**
 * show all cookie
 */
var_dump($_COOKIE);

/**
 * METHODS STATICS OF THE CLASS
 */

/**
 * Create a new cookie using the static method
 */
StaticCookie::set("test", "new_test", 10);

/**
 * get value the static method
 */
echo StaticCookie::get("test");

echo "<br><br>";

/**
 * Create value as array the static method
 */
StaticCookie::set('user', ['name' => 'Rafael', 'role' => "Developer"], 10);

/**
 * get value as array the static method
 */
echo StaticCookie::get('user')['role'];


echo "<br><br>";

/**
 * remove the static class
 */
//Cookie::destroy('test');

/**
 * create if it doesn't exist the static method
 */
StaticCookie::setDoesntHave('testIfDoesntHave', true, 10000);

/**
 * create and delete if it exists the static method
 */
StaticCookie::setDoesntHave('testIfDoesntHave', 'ok', 12500, "/admin", true);

/**
 *  get value the static class
 */
echo StaticCookie::get("testIfDoesntHave");

echo "<br><br>";

/**
 * check if exists cookie the static class
 */
if (StaticCookie::has('testIfDoesntHave')) {
    echo "Cookie testIfDoesntHave exist";
} else {
    echo "Cookie testIfDoesntHave not exist";
}

echo "<br><br>";

/**
 * check if exists by value
 */

if (StaticCookie::has("testIfDoesntHave", 1)) {
    echo "the value is equal to ok";
} else {
    echo "the vlaue is no equal to ok";
}
echo "<br><br>";

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