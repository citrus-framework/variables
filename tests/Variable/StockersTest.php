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
     * {@inheritDoc}
     *
     * @return void
     */
    public function tearDown(): void
    {
        // 初期化しておく
        Stockers::removeAll();
    }

    /**
     * @test
     */
    public function exists_想定通り()
    {
        // 検算：まだ何も入れていない
        $this->assertFalse(Stockers::exists());

        // データストック
        Stockers::addItem(StockedItem::newType(MessageType::ERROR, 'サンプルエラーメッセージ'));
        // 検算：データが入った
        $this->assertTrue(Stockers::exists());
    }

    /**
     * @test
     */
    public function popWithType_想定通り()
    {
        // データストック
        Stockers::addItem(StockedItem::newType(MessageType::ERROR, 'サンプルエラーメッセージ'));
        Stockers::addItem(StockedItem::newType(MessageType::WARNING, 'サンプル警告メッセージ'));
        Stockers::addItem(StockedItem::newType(MessageType::NOTICE, 'サンプル通知メッセージ'));

        // 検算：3件入っている
        $this->assertCount(3, Stockers::callItems());

        // type:ERRORを取得する
        $items = Stockers::popWithType(MessageType::ERROR);

        // 検算：全てtype:ERROR
        foreach ($items as $item)
        {
            $this->assertSame(MessageType::ERROR, $item->type);
        }

        // 検算：2件になっている
        $this->assertCount(2, Stockers::callItems());
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
    }
}

enum MessageType : string implements Stockers\StockedType
{
    case ERROR = 'ERROR';
    case WARNING = 'WARNING';
    case NOTICE = 'NOTICE';
}