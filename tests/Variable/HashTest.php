<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable;

use Citrus\Variable\Hash;
use PHPUnit\Framework\TestCase;

/**
 * ハッシュのテスト
 */
class HashTest extends TestCase
{
    /**
     * @test
     */
    public function signature_想定通り()
    {
        $signature = Hash::signature(
            Hash\MethodType::HMAC,
            Hash\AlgorithmType::SHA256,
            'token',
            'secret', // テスト用
        );
        // 検算
        $this->assertNotSame('', $signature);

    }

    /**
     * @test
     */
    public function verify_想定通り()
    {
        $signature = Hash::signature(
            Hash\MethodType::HMAC,
            Hash\AlgorithmType::SHA256,
            'token',
            'secret', // テスト用
        );
        // 検算
        $this->assertTrue(Hash::verify(
            $signature,
            Hash\MethodType::HMAC,
            Hash\AlgorithmType::SHA256,
            'token',
            'secret'
        ));
        // 検算：失敗
        $this->assertFalse(Hash::verify(
            $signature . 'a',
            Hash\MethodType::HMAC,
            Hash\AlgorithmType::SHA256,
            'token',
            'secret'
        ));
    }
}
