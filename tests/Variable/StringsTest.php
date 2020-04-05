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
    public function pathUpperFirst_想定通り()
    {
        // 先頭スラッシュ無し
        $this->assertSame('Hoge/Fuga', Strings::pathUpperFirst('hoge/fuga'));

        // 先頭スラッシュ有り
        $this->assertSame('/Hoge/Fuga', Strings::pathUpperFirst('/hoge/fuga'));

        // 先頭以外は小文字化する
        $this->assertSame('/Hoge/Fuga', Strings::pathUpperFirst('/HOGE/FUGA'));
    }
}
