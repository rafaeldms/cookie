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
        return StaticCookie::set($this->name, $this->value, $this->expiryTime, $this->path, $this->domain,
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
        StaticCookie::unset($this->name);

        return $this->delete();
    }

    /**
     * Verify if exists cookie
     * @return bool
     */
    public function hasCookie(): bool
    {
        if (StaticCookie::has($this->name, $this->value)) {
            return true;
        }
        return false;
    }
}