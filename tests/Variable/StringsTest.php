<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable;

use Citrus\Variable\Strings;
use PHPUnit\Framework\TestCase;

/**
 * 文字列拡張のテスト
 */
class StringsTest extends TestCase
{
    /**
     * @test
     */
    public function isEmpty_想定通り()
    {
        // null
        $this->assertTrue(Strings::isEmpty(null));
        // 空文字
        $this->assertTrue(Strings::isEmpty(''));
        // 0
        $this->assertfalse(Strings::isEmpty('0'));
    }



    /**
     * @test
     */
    public function patternReplace_想定通り()
    {
        $patterns = [
            'he' => 'she',
            'Jesse' => 'Jessica',
        ];
        $subject = 'he is Jesse';
        $expected = 'she is Jessica';

        // 検算
        $this->assertSame($expected, Strings::patternReplace($patterns, $subject));
    }



    /**
     * @test
     */
    public function removeDuplicateEOL_想定通り()
    {
        // 改行5個分の文字列
        $source = <<<'SOURCE'
hoge




SOURCE;
        $expected1 = <<<'EXPECTED'
hoge

EXPECTED;
        $expected2 = <<<'EXPECTED'
hoge
EXPECTED;

        // 検算
        $this->assertSame($expected1, Strings::removeDuplicateEOL($source));
        // 検算(最終文字列が改行だった場合取り除く)
        $this->assertSame($expected2, Strings::removeDuplicateEOL($source, true));
    }


    /**
     * @test
     */
    public function upperCamelCase_想定通り()
    {
        $snake_case_context = 'application_name';
        // 検算
        $this->assertSame('ApplicationName', Strings::upperCamelCase($snake_case_context));
    }
}
