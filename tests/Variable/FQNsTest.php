<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable;

use Citrus\Variable\FQNs;
use PHPUnit\Framework\TestCase;

/**
 * FQN処理のテスト
 */
class FQNsTest extends TestCase
{
    /**
     * @test
     */
    public function convertClassName_想定通り()
    {
        $class_name = FQNs::convertClassName(self::class);
        $this->assertSame('FQNsTest', $class_name);
    }
}
