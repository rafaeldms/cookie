<?php

namespace Unit;

use PHPUnit\Framework\TestCase;
use rafaeldms\Cookie\Cookie;

class CookieTest extends TestCase
{
    /** @test */
    public function it_getvalue():void
    {
        //given that we have a cookie object
        $cookie = new Cookie('test');

        $expcted = "test";

        $this->assertEquals($expcted, $cookie->getName());
    }

    /** @test */
    public function it_setvalue():void
    {
        //given that we have a cookie object
        $cookie = new Cookie("test");

        //when we call a set method
        $cookie->setValue("12345");

        $expcted = "12345";

        //then we assert value was seted
        $this->assertEquals($expcted, $cookie->getValue());
    }

    /** @test */
    public function it_setExpirytime()
    {
        //given that we have a cookie object
        $cookie = new Cookie("test");

        //when we call a set method
        $cookie->setExpiryTime(10);

        $expcted = 10;

        //then we assert value was seted
        $this->assertEquals($expcted, $cookie->getExpiryTime());
    }
}