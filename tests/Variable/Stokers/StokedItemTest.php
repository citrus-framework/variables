<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable\Stokers;

use Citrus\Variable\Stockers\StockedItem;
use Citrus\Variable\Stockers\StockedType;
use PHPUnit\Framework\TestCase;

/**
 * ストップアイテムのテスト
 */
class StokedItemTest extends TestCase
{
    /**
     * @test
     */
    public function toString_意図通り()
    {
        $item = StockedItem::newItem('contentTest', TestStockedType::TEST, 'tagTest');

        // 空文字
        $this->assertSame('type:test, tag:tagTest, contentTest', $item->toString());
    }
}

enum TestStockedType : string implements StockedType
{
    case TEST = 'test';
}