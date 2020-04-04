<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable;

use Citrus\Variable\Arrays;
use PHPUnit\Framework\TestCase;

/**
 * 配列拡張のテスト
 */
class ArraysTest extends TestCase
{
    /**
     * @test
     */
    public function path_意図通り()
    {
        $values = [
            'hoge' => [
                'fuga' => [
                    'example' => 5,
                ],
            ],
        ];

        // null
        $this->assertNull(Arrays::path($values, 'hoge.fuga.gnu'));
        // 空文字
        $this->assertSame(5, Arrays::path($values, 'hoge.fuga.example'));
    }
}
