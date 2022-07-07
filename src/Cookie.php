<?php

namespace rafaeldms\Cookie;

/**
 *
 */
final class Cookie
{
    /** @var string the name of the cookie which is also the key for future accesses via `$_COOKIE[...]` */
    private string $name;

    /** @var string|null the value of the cookie that will be stored on the client's machine */
    private ?string $value;

    /** @var int the Unix timestamp indicating the time that the cookie will expire at, i.e. usually `time() + $seconds` */
    private int $expiryTime;

    /** @var string|null the path on the server that the cookie will be valid for (including all sub-directories), e.g. an empty string for the current directory or `/` for the root directory */
    private ?string $path;

    /** @var string|null the domain that the cookie will be valid for (including subdomains) or `null` for the current host (excluding subdomains) */
    private ?string $domain;

    /** @var bool indicates that the cookie should be accessible through the HTTP protocol only and not through scripting languages */
    private bool $httpOnly;

    /** @var bool indicates that the cookie should be sent back by the client over secure HTTPS connections only */
    private bool $secureOnly;

    /**
     * Prepares a new cookie
     *
     * @param string $name the name of the cookie which is also the key for future accesses via `$_COOKIE[...]`
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->value = null;
        $this->expiryTime = 0;
        $this->path = "/";
        $this->domain = null;
        $this->httpOnly = true;
        $this->secureOnly = false;
    }

    /**
     * Returns the name of the cookie
     *
     * @return string the name of the cookie which is also the key for future acesses via `$_COOKIE[...]`
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Return the values of the cookie
     * @return string|null the value of the cookie that will be stored on the client's machine
     */
    public function getValue(): null|string
    {
        return $this->value;
    }

    /**
     * Sets the value for the cookie
     *
     * @param mixed|null $value the value of the cookie that will be stored on the client's machine
     * @return Cookie this instance ofr chaining
     */
    public function setValue(mixed $value): Cookie
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Returns the expiry time of the cookie
     *
     * @return int the Unix timestamp indicating the time that the cookie will expire at, i.e. usually `time() + $seconds`
     */
    public function getExpiryTime(): int
    {
        return $this->expiryTime;
    }

    /**
     * Sets the expiry time for the cookie
     *
     * @param int $expiryTime the Unix timestamp indicating the time that the cookie will expire at, i.e. usually `time() + $seconds`
     * @return static this instance for chaining
     */
    public function setExpiryTime(int $expiryTime): Cookie
    {
        $this->expiryTime = $expiryTime;

        return $this;
    }


    /**
     * Returns the path of the cookie
     *
     * @return string|null the path on the server that the cookie will be valid for (including all sub-directories), e.g. an empty string for the current directory or `/` for the root directory
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * Sets the path for the cookie
     *
     * @param string|null $path the path on the server that the cookie will be valid for (including all sub-directories), e.g. an empty string for the current directory or `/` for the root directory
     * @return static this instance for chaining
     */
    public function setPath(?string $path): Cookie
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Returns the domain of the cookie
     *
     * @return string|null the domain that the cookie will be valid for (including subdomains) or `null` for the current host (excluding subdomains)
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * Sets the domain for the cookie
     *
     * @param string|null $domain the domain that the cookie will be valid for (including subdomains) or `null` for the current host (excluding subdomains)
     * @return static this instance for chaining
     */
    public function setDomain(?string $domain): Cookie
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * Returns whether the cookie should be accessible through HTTP only
     * @return bool whether the cookie should be accessible through the HTTP protocol only and not through scripting languages
     */
    public function isHttpOnly(): bool
    {
        return $this->httpOnly;
    }

    /**
     * Sets whether the cookie should be accessible through HTTP only
     *
     * @param bool $httpOnly indicates that the cookie should be accessible through the HTTP protocol only and not through scripting languages
     * @return static this instance for chaining
     */
    public function setHttpOnly(bool $httpOnly): Cookie
    {
        $this->httpOnly = $httpOnly;
        return $this;
    }

    /**
     * Returns whether the cookie should be sent over HTTPS only
     *
     * @return bool whether the cookie should be sent back by the client over secure HTTPS connections only
     */
    public function isSecureOnly(): bool
    {
        return $this->secureOnly;
    }

    /**
     * Sets whether the cookie should be sent over HTTPS only
     * @param bool $secureOnly indicates that the cookie should be sent back by the client over secure HTTPS connections only
     * @return static this instance for chaining
     */
    public function setSecureOnly(bool $secureOnly): Cookie
    {
        $this->secureOnly = $secureOnly;
        return $this;
    }

    /**
     * Saves the cookie
     * @return bool whether the cookie header has successfully been sent (and will *probably* cause the client to set the cookie)
     */
    public function save(): bool
    {
        return self::setCookie($this->name, $this->value, $this->expiryTime, $this->path, $this->domain,
            $this->secureOnly);
    }

    /**
     * @return bool
     */
    public function saveAndSet(): bool
    {
        $_COOKIE[$this->name] = $this->value;
        return $this->save();
    }

    /**
     * Deletes the cookie
     *
     * @return bool whether the cookie header has successfully been sent (and will *probably* cause the client to delete the cookie)
     */
    public function delete(): bool
    {
        // set the copied cookie's value to an empty string which internally sets the required options for a deletion
        $this->setValue('');

        // save the copied "deletion" cookie
        return $this->save();
    }

    /**
     * Deletes the cookie and immediately removes the corresponding variable from the superglobal `$_COOKIE` array
     *
     * The variable would otherwise only be deleted at the start of the next HTTP request
     *
     * @return bool whether the cookie header has successfully been sent (and will *probably* cause the client to delete the cookie)
     */
    public function deleteAndUnset(): bool
    {
        self::unset($this->name);

        return $this->delete();
    }

    /**
     * Verify if exists cookie
     * @return bool
     */
    public function hasCookie(): bool
    {
        if(self::has($this->name, $this->value)){
            return true;
        }
        return false;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param int $minutes
     * @param string|null $path
     * @param bool $encrypt
     * @return bool
     */
    public static function set(
        string $name,
        mixed $value,
        int $minutes,
        ?string $path = null,
        bool $encrypt = true
    ): bool {
        //check if the cookie value is an array to save in json
        if (is_array($value)) {
            $cookie = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $value = $encrypt ? self::encrypt($cookie) : $cookie;
        } else {
            $value = $encrypt ? self::encrypt($value) : $value;
        }
        return self::setCookie($name, $value, self::expire($minutes), $path);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param string|null $path
     * @return bool
     */
    public static function destroy(string $name, ?string $value = '', ?string $path = null): bool
    {
        return self::setCookie($name, $value, -1, $path);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param string|null $path
     * @return bool
     */
    public static function destroyAndUnset(string $name, ?string $value = '', ?string $path = null): bool
    {
        self::unset($name);
        return self::setCookie($name, $value, -1, $path);
    }

    /**
     * @param string $name
     * @return void
     */
    public static function unset(string $name): void
    {
        unset($_COOKIE[$name]);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param bool $encrypt
     * @return bool
     */
    public static function has(string $name, ?string $value = null, bool $encrypt = true): bool
    {
        $getCookie = self::getCookie($name);
        if (!$value) {
            if ($getCookie) {
                return true;
            }
            return false;
        } else {
            if ($getCookie == ($encrypt ? self::encrypt($value) : $value)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $name
     * @param bool $decrypt
     * @return mixed|string|null
     */
    public static function get(string $name, bool $decrypt = true): mixed
    {
        if (self::has($name)) {
            $cookie = ($decrypt ? self::decrypt(self::getCookie($name)) : self::getCookie($name));
            if ($cookie) {
                if ($decode = json_decode($cookie, true)) {
                    return $decode;
                }
                return $cookie;
            }
            return null;
        }
        return null;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param int $minutes
     * @param string|null $path
     * @param bool $removeHas
     * @return bool|null
     */
    public static function setDoesntHave(
        string $name,
        mixed $value,
        int $minutes,
        ?string $path = null,
        bool $removeHas = false
    ): ?bool {
        if (!self::has($name)) {
            return self::set($name, $value, $minutes, $path);
        }
        if ($removeHas) {
            return self::destroy($name);
        }
        return null;
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param int $expire
     * @param string|null $path
     * @param string|null $domain
     * @param bool $secure
     * @return bool
     */
    public static function setCookie(
        string $name,
        ?string $value,
        int $expire,
        ?string $path,
        ?string $domain = "",
        bool $secure = false
    ): bool {
        return setCookie($name, $value, $expire, ($path ?? "/"), ($domain ?? false), $secure);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public static function getCookie(string $name): mixed
    {
        return filter_input(INPUT_COOKIE, $name, FILTER_DEFAULT);
    }

    /**
     * @param int $minutes
     * @return int
     */
    public static function expire(int $minutes): int
    {
        return time() + (60 * $minutes);
    }

    /**
     * @param string $value
     * @return string
     */
    public static function encrypt(string $value): string
    {
        return base64_encode($value);
    }

    /**
     * @param string $value
     * @return string
     */
    public static function decrypt(string $value): string
    {
        return base64_decode($value);
    }

    /**
     * @param string $name
     * @return bool
     */
    private static function isNameValid(string $name): bool
    {
        // The name of a cookie must not be empty on PHP 7+ (https://bugs.php.net/bug.php?id=69523).
        if ($name !== '' || PHP_VERSION_ID < 70000) {
            if (!preg_match("/[=,: \\t\\r\\n\\013\\014]/", $name)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param int $expiryTime
     * @return bool
     */
    private static function isExpiryTimeValid(int $expiryTime): bool
    {
        return is_numeric($expiryTime) || is_null($expiryTime) || is_bool($expiryTime);
    }

    /**
     * @param int $expireTime
     * @return int
     */
    private static function calculateMaxAge(int $expireTime): int
    {
        if ($expireTime === 0) {
            return 0;
        }

        $maxAge = $expireTime - time();

        // The value of the `Max-Age` property must not be negative on PHP 7.0.19+ (< 7.1) and
        // PHP 7.1.5+ (https://bugs.php.net/bug.php?id=72071).
        if ((PHP_VERSION_ID >= 70019 && PHP_VERSION_ID < 70100) || PHP_VERSION_ID >= 70105) {
            if ($maxAge < 0) {
                $maxAge = 0;
            }
        }
        return $maxAge;
    }

    /**
     * @param int $expiryTime
     * @param bool $forceShow
     * @return string|null
     */
    private static function formatExpiryTime(int $expiryTime, bool $forceShow = false): ?string
    {
        if ($expiryTime > 0 || $forceShow) {
            if ($forceShow) {
                $expiryTime = 1;
            }
            return gmdate('D, d-M-Y H:i:s T', $expiryTime);
        }
        return null;
    }

    /**
     * @param int $expiryTime
     * @param bool $forceShow
     * @return string|null
     */
    private static function formatMaxAge(int $expiryTime, bool $forceShow = false): ?string
    {
        if ($expiryTime > 0 || $forceShow) {
            return self::calculateMaxAge($expiryTime);
        }
        return null;
    }
}