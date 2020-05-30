<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable;

use Citrus\Variable\Clonable;
use Citrus\Variable\Strings;
use PHPUnit\Framework\TestCase;

/**
 * インスタンスクローン処理のテスト
 */
class ClonableTest extends TestCase
{
    /**
     * @test
     */
    public function clone_想定通り()
    {
        // ただのコピー
        $sample1 = new SampleClone();
        $sample2 = $sample1;
        $sample1->name = 'bbb';
        // 検算(インスタンスが同じ)
        $this->assertSame($sample1, $sample2);
        // 検算(プロパティが一緒に変更される)
        $this->assertSame($sample1->name, $sample2->name);

        // クローン処理
        $sample1 = new SampleClone();
        $sample2 = $sample1->clone();
        $sample1->name = 'bbb';
        // 検算(インスタンスが違う)
        $this->assertNotSame($sample1, $sample2);
        // 検算(プロパティが一緒に変更されない)
        $this->assertNotSame($sample1->name, $sample2->name);
    }
}

/**
 * クローンテスト用のクラス
 */
class SampleClone
{
    use Clonable;

    public $name = 'aaa';
}
