<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
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
    public function fromTimestamp_想定通り()
    {
        $dt = Dates::fromTimestamp(1758067200);

        // 検算(日数差は1日)
        $this->assertSame('2025-09-17 00:00:00+0000', $dt->formatTimestampWithTimezone());
    }

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

    /**
     * @test
     */
    public function フォーマット_想定どおり()
    {
        $dt1 = Dates::now()->formatTimestamp();
        $dt2 = Dates::now()->format('Y-m-d H:i:s');

        // 検算(時間文字列が一致)
        $this->assertSame($dt1, $dt2);
    }

    /**
     * @test
     */
    public function フォーマット_タイムゾーン付き_想定どおり()
    {
        $dt1 = Dates::now()->formatTimestampWithTimezone();
        $dt2 = Dates::now()->format('Y-m-d H:i:sO');

        // 検算(時間文字列が一致)
        $this->assertSame($dt1, $dt2);
    }

    /**
     * @test
     */
    public function new_想定通り()
    {
        // 普通の日付
        $dt1 = Dates::new('2020-03-04');
        // 存在しない日付
        $dt2 = Dates::new('2020-05-67');

        // 検算(普通の日付)
        $this->assertSame('3', $dt1->format('n'));
        $this->assertSame('4', $dt1->format('j'));
        // 検算(存在しない日付)
        $this->assertNull($dt2);
    }

    /**
     * @test
     */
    public function addYear_想定通り()
    {
        $dt1 = Dates::new('2020-03-04');
        $dt2 = (clone $dt1)->addYear(1);

        // 検算
        $diff = $dt1->diff($dt2);
        $this->assertSame(1, $diff->y);
        $this->assertSame(0, $diff->m);
        $this->assertSame(0, $diff->d);
        $this->assertSame(365, $diff->days);
        $this->assertTrue($dt1 < $dt2);
    }

    /**
     * @test
     */
    public function subYear_想定通り()
    {
        $dt1 = Dates::new('2020-03-04');
        $dt2 = (clone $dt1)->subYear(1);

        // 検算
        $diff = $dt1->diff($dt2);
        $this->assertSame(1, $diff->y);
        $this->assertSame(0, $diff->m);
        $this->assertSame(0, $diff->d);
        $this->assertSame(366, $diff->days);
        $this->assertTrue($dt1 > $dt2);
    }

    /**
     * @test
     */
    public function addMonth_想定通り()
    {
        $dt1 = Dates::new('2020-03-04');
        $dt2 = (clone $dt1)->addMonth(1);

        // 検算
        $diff = $dt1->diff($dt2);
        $this->assertSame(0, $diff->y);
        $this->assertSame(1, $diff->m);
        $this->assertSame(0, $diff->d);
        $this->assertSame(31, $diff->days);
        $this->assertTrue($dt1 < $dt2);
    }

    /**
     * @test
     */
    public function subMonth_想定通り()
    {
        $dt1 = Dates::new('2020-03-04');
        $dt2 = (clone $dt1)->subMonth(1);

        // 検算
        $diff = $dt1->diff($dt2);
        $this->assertSame(0, $diff->y);
        $this->assertSame(1, $diff->m);
        $this->assertSame(0, $diff->d);
        $this->assertSame(29, $diff->days);
        $this->assertTrue($dt1 > $dt2);
    }

    /**
     * @test
     */
    public function addDay_想定通り()
    {
        $dt1 = Dates::new('2020-03-04');
        $dt2 = (clone $dt1)->addDay(1);

        // 検算(日数差は1日)
        $this->assertSame(1, $dt1->diff($dt2)->d);
        $this->assertTrue($dt1 < $dt2);
    }

    /**
     * @test
     */
    public function subDay_想定通り()
    {
        $dt1 = Dates::new('2020-03-04');
        $dt2 = (clone $dt1)->subDay(1);

        // 検算(日数差は1日)
        $this->assertSame(1, $dt1->diff($dt2)->d);
        $this->assertTrue($dt1 > $dt2);
    }

    /**
     * @test
     */
    public function monthLastDay_想定通り()
    {
        $dt1 = Dates::new('2020-03-04');
        $dt2 = (clone $dt1)->monthLastDay();

        // 検算
        $diff = $dt1->diff($dt2);
        $this->assertSame(0, $diff->y);
        $this->assertSame(0, $diff->m);
        $this->assertSame(27, $diff->d);
        $this->assertSame(27, $diff->days);
        $this->assertTrue($dt1 < $dt2);
    }
}
