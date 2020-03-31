<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2019, CitrusFramework. All Rights Reserved.
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
    public function isEmpty_意図通り()
    {
        // null
        $this->assertTrue(Strings::isEmpty(null));
        // 空文字
        $this->assertTrue(Strings::isEmpty(''));
        // 0
        $this->assertfalse(Strings::isEmpty('0'));
    }
}
