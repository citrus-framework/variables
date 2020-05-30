<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable;

use Citrus\Variable\Measures;
use PHPUnit\Framework\TestCase;

/**
 * 時間計測処理のテスト
 */
class MeasuresTest extends TestCase
{
    /**
     * @test
     */
    public function time_想定通り()
    {
        // 1秒の処理を実行する
        $time = Measures::time(function () {
            sleep(1);
        });

        $this->assertTrue(($time >= 1 and $time < 2));
    }
}
