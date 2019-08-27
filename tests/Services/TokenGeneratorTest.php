<?php
/**
 * Created by PhpStorm.
 * User: sreckokuzmanovic
 * Date: 27/08/2019
 * Time: 14:04
 */

namespace App\Tests\Services;


use App\Services\TokenGenerator;
use PHPUnit\Framework\TestCase;

class TokenGeneratorTest extends TestCase
{
    public function testTokenGenerator() {
        $tokenGenerator = new TokenGenerator();
        $token = $tokenGenerator->getRandomSecureToken(30);
        $this->assertEquals(30,strlen($token));
        $this->assertTrue(ctype_alnum($token));
    }

}