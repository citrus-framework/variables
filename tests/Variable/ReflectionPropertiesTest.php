<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable;

use Citrus\Variable\ReflectionProperties;
use PHPUnit\Framework\TestCase;

/**
 * リフレクションプロパティ拡張のテスト
 */
class ReflectionPropertiesTest extends TestCase
{
    /**
     * @test
     */
    public function call_意図通り()
    {
        $sample = new SampleObject();

        $this->assertSame('fuga', ReflectionProperties::call($sample, 'hoge'));
    }
}

class SampleObject
{
    private $hoge = 'fuga';
}
