<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable;

use Citrus\Variable\Singleton;
use PHPUnit\Framework\TestCase;

/**
 * シングルトンのテスト
 */
class SingletonTest extends TestCase
{
    /**
     * @test
     */
    public function sharedInstance_想定通り()
    {
        // php8以降、メソッド内静的変数が共通領域になってしまった
        $this->assertInstanceOf(TestA::class, TestA::sharedInstance());
        $this->assertInstanceOf(TestB::class, TestB::sharedInstance());
    }
}

class TestP
{
    use Singleton;
}

class TestA extends TestP
{
}

class TestB extends TestP
{
}
