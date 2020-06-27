<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable;

use Citrus\Variable\Stockers;
use Citrus\Variable\Stockers\StockedItem;
use PHPUnit\Framework\TestCase;

/**
 * ストック処理拡張のテスト
 */
class StockersTest extends TestCase
{
    /**
     * @test
     */
    public function exists_想定通り()
    {
        // 検算：まだ何も入れていない
        $this->assertFalse(Stockers::exists());

        // データストック
        Stockers::addItem(StockedItem::newType('ERROR', 'サンプルエラーメッセージ'));
        // 検算：データが入った
        $this->assertTrue(Stockers::exists());

        // 初期化しておく
        Stockers::removeAll();
    }



    /**
     * @test
     */
    public function popWithType_想定通り()
    {
        // データストック
        Stockers::addItem(StockedItem::newType('ERROR', 'サンプルエラーメッセージ'));
        Stockers::addItem(StockedItem::newType('WARNING', 'サンプル警告メッセージ'));
        Stockers::addItem(StockedItem::newType('NOTICE', 'サンプル通知メッセージ'));

        // 検算：3件入っている
        $this->assertCount(3, Stockers::callItems());

        // type:ERRORを取得する
        $items = Stockers::popWithType('ERROR');

        // 検算：全てtype:ERROR
        foreach ($items as $item)
        {
            $this->assertSame('ERROR', $item->type);
        }

        // 検算：2件になっている
        $this->assertCount(2, Stockers::callItems());

        // 初期化しておく
        Stockers::removeAll();
    }



    /**
     * @test
     */
    public function popWithTag_想定通り()
    {
        // データストック
        Stockers::addItem(StockedItem::newTag('ERROR', 'サンプルエラーメッセージ'));
        Stockers::addItem(StockedItem::newTag('WARNING', 'サンプル警告メッセージ'));
        Stockers::addItem(StockedItem::newTag('NOTICE', 'サンプル通知メッセージ'));

        // 検算：3件入っている
        $this->assertCount(3, Stockers::callItems());

        // type:ERRORを取得する
        $items = Stockers::popWithTag('ERROR');

        // 検算：全てtype:ERROR
        foreach ($items as $item)
        {
            $this->assertSame('ERROR', $item->tag);
        }

        // 検算：2件になっている
        $this->assertCount(2, Stockers::callItems());

        // 初期化しておく
        Stockers::removeAll();
    }

//
//
//    /**
//     * @test
//     */
//    public function patternReplace_想定通り()
//    {
//        $patterns = [
//            'he' => 'she',
//            'Jesse' => 'Jessica',
//        ];
//        $subject = 'he is Jesse';
//        $expected = 'she is Jessica';
//
//        // 検算
//        $this->assertSame($expected, Strings::patternReplace($patterns, $subject));
//    }
//
//
//
//    /**
//     * @test
//     */
//    public function removeDuplicateEOL_想定通り()
//    {
//        // 改行5個分の文字列
//        $source = <<<'SOURCE'
//hoge
//
//
//
//
//SOURCE;
//        $expected1 = <<<'EXPECTED'
//hoge
//
//EXPECTED;
//        $expected2 = <<<'EXPECTED'
//hoge
//EXPECTED;
//
//        // 検算
//        $this->assertSame($expected1, Strings::removeDuplicateEOL($source));
//        // 検算(最終文字列が改行だった場合取り除く)
//        $this->assertSame($expected2, Strings::removeDuplicateEOL($source, true));
//    }
}
