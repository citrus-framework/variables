<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable\Klass;

use Citrus\Variable\Klass\KlassVariable;
use PHPUnit\Framework\TestCase;

/**
 * klass変数のテスト
 */
class KlassVariableTest extends TestCase
{
    /**
     * @test
     */
    public function toArgumentTypeString_想定通り()
    {
        // パターン1
        $variable = new KlassVariable('string', 'name', null, true);
        $expected = <<<'EXPECTED'
?string
EXPECTED;
        $this->assertSame($expected, $variable->toArgumentTypeString());

        // パターン2
        $variable = new KlassVariable('string', 'name', null, false);
        $expected = <<<'EXPECTED'
string
EXPECTED;
        $this->assertSame($expected, $variable->toArgumentTypeString());

        // パターン3
        $variable = new KlassVariable('mixed', 'name', null, true);
        $expected = <<<'EXPECTED'

EXPECTED;
        $this->assertSame($expected, $variable->toArgumentTypeString());

        // パターン4
        $variable = new KlassVariable('mixed', 'name', null, false);
        $expected = <<<'EXPECTED'

EXPECTED;
        $this->assertSame($expected, $variable->toArgumentTypeString());
    }



    /**
     * @test
     */
    public function toCommentTypeString_想定通り()
    {
        // パターン1
        $variable = new KlassVariable('string', 'name', null, true);
        $expected = <<<'EXPECTED'
string|null
EXPECTED;
        $this->assertSame($expected, $variable->toCommentTypeString());

        // パターン2
        $variable = new KlassVariable('string', 'name', null, false);
        $expected = <<<'EXPECTED'
string
EXPECTED;
        $this->assertSame($expected, $variable->toCommentTypeString());

        // パターン3
        $variable = new KlassVariable('mixed', 'name', null, true);
        $expected = <<<'EXPECTED'
mixed|null
EXPECTED;
        $this->assertSame($expected, $variable->toCommentTypeString());

        // パターン4
        $variable = new KlassVariable('mixed', 'name', null, false);
        $expected = <<<'EXPECTED'
mixed
EXPECTED;
        $this->assertSame($expected, $variable->toCommentTypeString());
    }



    /**
     * @test
     */
    public function toWithDefaultValueString_想定通り()
    {
        // パターン1
        $variable = new KlassVariable('string', 'name', null, true);
        $expected = <<<'EXPECTED'
 = null
EXPECTED;
        $this->assertSame($expected, $variable->toWithDefaultValueString());

        // パターン2
        $variable = new KlassVariable('string', 'name', null, false);
        $expected = <<<'EXPECTED'

EXPECTED;
        $this->assertSame($expected, $variable->toWithDefaultValueString());

        // パターン3
        $variable = new KlassVariable('bool', 'name', true, true);
        $expected = <<<'EXPECTED'
 = true
EXPECTED;
        $this->assertSame($expected, $variable->toWithDefaultValueString());

        // パターン4
        $variable = new KlassVariable('bool', 'name', true, false);
        $expected = <<<'EXPECTED'
 = true
EXPECTED;
        $this->assertSame($expected, $variable->toWithDefaultValueString());
    }
}
