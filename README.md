# Cookie @RafaelDms

[![Maintainer](http://img.shields.io/badge/maintainer-@rafaeldms-blue.svg?style=flat-square)](https://instagram.com/rafaeldamasceno86)
[![Source Code](http://img.shields.io/badge/source-rafaeldms/rafaeldms-blue.svg?style=flat-square)](https://github.com/rafaeldms/cookie)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/rafaeldms/cookie.svg?style=flat-square)](https://packagist.org/packages/rafaeldms/cookie)
[![Latest Version](https://img.shields.io/github/release/rafaeldms/cookie.svg?style=flat-square)](https://github.com/rafaeldms/cookie/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Quality Score](https://img.shields.io/scrutinizer/g/rafaeldms/cookie.svg?style=flat-square)](https://scrutinizer-ci.com/g/rafaeldms/cookie)
[![Total Downloads](https://img.shields.io/packagist/dt/rafaeldms/cookie.svg?style=flat-square)](https://packagist.org/packages/rafaeldms/cookie)

###### The Cookie is a component for creating Cookies in the browser with the possibility to create, read, edit and remove cookies.

O Cookie é um componente para criação de Cookies nos navegadores tendo a possibilidade de criar, ler, editar e remover cookies.

### Highlights

- Simple Installation (Instalação simples)
- Easy get instance (Fácil de instanciar)
- Total controle of the cookies (Controle total dos cookies)
- Create cookies with base_64 encryption (Crie cookies com criptografia base_64)
- Composer ready and PSR-2 compliant  (Pronto para o composer e Compatível com PSR-2)

## Installation

Cookie is available via Composer:

```bash
"rafaeldms/cookie": "^1.0.*"
```

or run

```bash
composer require rafaeldms/cookie
```

## Documentation

###### For details on how to use the Cookie, see the sample folder with details in the component directory

Para mais detalhes sobre como usar o Cookie, veja a pasta de exemplo com detalhes no diretório do componente


###### To start using the Cookie you can Instantiate a new Class or use it in an abstract way

Para começar a usar o Cookie pode Instanciar uma nova Classe ou utilizá-lo de forma abstrata

#### Create Cookie using static methods (Criando cookies usando o método estático)

```php 
use RafaelDms\Cookie\StaticCookie;

/**
 * Create a new cookie using the static method
 */
 StaticCookie::setCookie::set("test", "new_test", 10);
```

#### Get Cookie using static methods (Obter Cookie usando métodos estáticos)

```php 
 /**
 * get value the static method
 */
 echo StaticCookie::get("test");

 echo "<br><br>";
```

#### Create values as array (Criando valores em array)
```php
/**
 * Create value as array
 */
StaticCookie::set('user', ['name' => 'Rafael', 'role' => "Developer"], 10);
```

#### Get Cookie using static methods (Obter Cookie usando métodos estáticos)
```php
/**
 * get value as array the static method
 */
echo StaticCookie::get('user')['role'];


echo "<br><br>";
```
#### Delete cookie using static method (Deletar cookie usando método estático)
```php 
/**
 * remove the static class
 */
StaticCookie::destroy('test');
```

#### Create if it doens't exist using method static (Criando um cookie se não existir usando método estático)
```php 

/**
 * create if it doesn't exist the static method
 */
StaticCookie::setDoesntHave('testIfDoesntHave', true, 10000);
```

#### Create and delete if it exists the static method (Criando e deletando um cookie se existir usando método estático)
```php 

/**
 * create if it doesn't exist the static method
 */
StaticCookie::setDoesntHave('testIfDoesntHave', 'ok', 12500, "/admin", true);
```

#### Check if exists using a static method (Verificando se um cookie existe usando método estático)
```php 
/**
 * check if exists cookie the static class
 */
if (StaticCookie::has('testIfDoesntHave')) {
    echo "Cookie testIfDoesntHave exist";
} else {
    echo "Cookie testIfDoesntHave not exist";
}

echo "<br><br>";
```

#### Check if exists by value using a static method (Verificando se um cookie existe um valor usando método estático)
```php 
/**
 * check if exists by value
 */

if (StaticCookie::has("testIfDoesntHave", 1)) {
    echo "the value is equal to ok";
} else {
    echo "the vlaue is no equal to ok";
}
echo "<br><br>";
```


## Instance a new cookie object (Instanciando um novo objeto cookie)

```php
use RafaelDms\Cookie\Cookie;

/**
 * Create a new cookie using construct method
 */
$cookie = new Cookie("testCookie");
```

### Set methods

#### Set value
```php
/**
 * set value a cookie using methot set
 */
$cookie->setValue("123456");
```

#### Set expiryTime
```php
/**
 * set expiryTime
 */
$cookie->setExpiryTime(24 * 60 * 60);
```

#### Set path
```php
/**
 * set path
 */
$cookie->setPath("/admin");
```

#### Set domain
```php
/**
 * set domain
 */
$cookie->setDomain("https://www.cagep.com.br");
```

#### Set http only
```php
/**
 * set httpOnly to false
 */
$cookie->setHttpOnly(false);
```

#### Set secure only
```php
/**
 * set secure only to true
 */
$cookie->setSecureOnly(true);
```

#### Save and set
```php
/**
 * save a cookies
 */
$cookie->saveAndSet();

var_dump($cookie);
```

### Get methods

#### Get value
```php
/**
 * get value
 */
echo "Value: " . $cookie->getValue();
echo "<br><br>";
```

#### Get expire time
```php
/**
 * get expire time
 */
echo "Expire Time: " . $cookie->getExpiryTime();
echo "<br><br>";
```

#### Get path
```php
/**
 * get path
 */
echo "Path: " .  $cookie->getPath();
echo "<br><br>";
```

#### Get domain
```php
/**
 * get domain
 */
echo "Domain: " .  $cookie->getDomain();
echo "<br><br>";
```

#### Is http only
```php
/**
 * is http only
 */
echo "Http only: " . ($cookie->isHttpOnly() ? 'true' : 'false');
echo "<br><br>";
```

#### Is secure only
```php
/**
 * is secure only
 */
echo "Secure only: " . ($cookie->isSecureOnly() ? 'true' : "false");
echo "<br><br>";
```

#### Update value (set new value)
```php
/**
 * update value
 */
$cookie->setValue("910111213");

var_dump($cookie);
```

#### Check if exists cookie and delete cookie
```php
/*
 * check if exists cookie and delete cookie
 */
if($cookie->hasCookie()){
    var_dump($cookie);
}
```

#### Delete and unset cookie
```php
/**
 * delele cookie and unset
 */
$cookie->deleteAndUnset();

var_dump($cookie);
```

## Contributing

Please see [CONTRIBUTING](https://github.com/rafaeldms/cookie/blob/master/CONTRIBUTING.md) for details.

## Support

###### Security: If you discover any security related issues, please email rafael@cagep.com.br instead of using the issue tracker.

Se você descobrir algum problema relacionado à segurança, envie um e-mail para rafael@cagep.com.br em vez de usar o
rastreador de problemas.

Thank you

## Credits

- [Rafael Damasceno Ferreira](https://github.com/rafaeldms) (Developer)
- [Cagep Consultoria](https://github.com/cagep-001) (Team)
- [All Contributors](https://github.com/rafaeldms/cookie/contributors)

## License

The MIT License (MIT). Please see [License File](https://github.com/rafaeldms/cookie/blob/master/LICENSE) for more
information.