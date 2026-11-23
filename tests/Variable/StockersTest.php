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
    public function addItem_配列を渡したときは中の項目だけが入る_想定通り()
    {
        // データストック(配列で渡す)
        Stockers::addItem([StockedItem::newItem('1件目'), StockedItem::newItem('2件目')]);

        // 検算：配列そのものは入らず、中の2件だけが入っている
        $items = array_values(Stockers::callItems());
        $this->assertCount(2, $items);
        $this->assertInstanceOf(StockedItem::class, $items[0]);
        $this->assertInstanceOf(StockedItem::class, $items[1]);
        $this->assertSame('1件目', $items[0]->content);
        $this->assertSame('2件目', $items[1]->content);
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

    /**
     * @test
     */
    public function removeWithType_想定通り()
    {
        // データストック
        Stockers::addItem(StockedItem::newType(MessageType::ERROR, 'サンプルエラーメッセージ'));
        Stockers::addItem(StockedItem::newType(MessageType::WARNING, 'サンプル警告メッセージ'));
        Stockers::addItem(StockedItem::newType(MessageType::ERROR, 'サンプルエラーメッセージ2'));

        // type:ERRORを削除する
        Stockers::removeWithType(MessageType::ERROR);

        // 検算：type:WARNINGの1件だけが残っている
        $items = Stockers::callItems();
        $this->assertCount(1, $items);
        $this->assertSame(MessageType::WARNING, array_values($items)[0]->type);
    }

    /**
     * @test
     */
    public function removeWithTag_想定通り()
    {
        // データストック
        Stockers::addItem(StockedItem::newTag('ERROR', 'サンプルエラーメッセージ'));
        Stockers::addItem(StockedItem::newTag('WARNING', 'サンプル警告メッセージ'));
        Stockers::addItem(StockedItem::newTag('ERROR', 'サンプルエラーメッセージ2'));

        // tag:ERRORを削除する
        Stockers::removeWithTag('ERROR');

        // 検算：tag:WARNINGの1件だけが残っている
        $items = Stockers::callItems();
        $this->assertCount(1, $items);
        $this->assertSame('WARNING', array_values($items)[0]->tag);
    }
}

enum MessageType : string implements Stockers\StockedType
{
    case ERROR = 'ERROR';
    case WARNING = 'WARNING';
    case NOTICE = 'NOTICE';
}