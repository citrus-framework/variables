<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable\Klass;

use Citrus\Variable\Klass\KlassFormat;
use Citrus\Variable\Klass\KlassReturn;
use PHPUnit\Framework\TestCase;

/**
 * klass返却のテスト
 */
class KlassReturnTest extends TestCase
{
    /**
     * @test
     */
    public function toReturnHintString_想定通り()
    {
        // パターン1
        $return = new KlassReturn('string', true);
        $expected = <<<'EXPECTED'
: ?string
EXPECTED;
        $this->assertSame($expected, $return->toReturnHintString());

        // パターン2
        $return = new KlassReturn('string', false);
        $expected = <<<'EXPECTED'
: string
EXPECTED;
        $this->assertSame($expected, $return->toReturnHintString());

        // パターン3
        $return = new KlassReturn('mixed', true);
        $expected = <<<'EXPECTED'

EXPECTED;
        $this->assertSame($expected, $return->toReturnHintString());

        // パターン4
        $return = new KlassReturn('mixed', false);
        $expected = <<<'EXPECTED'

EXPECTED;
        $this->assertSame($expected, $return->toReturnHintString());

        // パターン5
        $return = new KlassReturn('string[]', false);
        $expected = <<<'EXPECTED'
: array
EXPECTED;
        $this->assertSame($expected, $return->toReturnHintString());
    }



    /**
     * @test
     */
    public function toReturnCommentString_想定通り()
    {
        // パターン1
        $return = (new KlassReturn('string', true))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
     * @return string|null
EXPECTED;
        $this->assertSame($expected, $return->toReturnCommentString());

        // パターン2
        $return = (new KlassReturn('string', false))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
     * @return string
EXPECTED;
        $this->assertSame($expected, $return->toReturnCommentString());

        // パターン3
        $return = (new KlassReturn('mixed', true, '名前を返します'))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
     * @return mixed|null 名前を返します
EXPECTED;
        $this->assertSame($expected, $return->toReturnCommentString());

        // パターン4
        $return = (new KlassReturn('mixed', false, '名前を返します'))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
     * @return mixed 名前を返します
EXPECTED;
        $this->assertSame($expected, $return->toReturnCommentString());
    }
}
