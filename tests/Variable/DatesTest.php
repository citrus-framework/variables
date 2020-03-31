<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2019, CitrusFramework. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable;

use Citrus\Variable\Dates;
use PHPUnit\Framework\TestCase;

/**
 * 日付拡張のテスト
 */
class DatesTest extends TestCase
{
    /**
     * @test
     */
    public function 現時刻取得()
    {
        // 現時点のタイムスタンプ
        $dates = Dates::now();
        $ts1 = $dates->format('U');

        // 比較用　
        $ts2 = time();

        // 検算(連続で処理しているので、１秒以内であるべき)
        $this->assertLessThanOrEqual(1, abs($ts1 - $ts2));
    }



    /**
     * @test
     */
    public function 現時刻取得_オブジェクトは違うが時間は同じ()
    {
        $dt1 = Dates::now();
        $dt2 = Dates::now();

        // 検算(オブジェクトは違う)
        $this->assertNotSame($dt1, $dt2);

        // 検算(時間はマイクロ秒で同じ)
        $this->assertSame($dt1->format('u'), $dt2->format('u'));
    }
}
