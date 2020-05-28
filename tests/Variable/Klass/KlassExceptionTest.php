<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable\Klass;

use Citrus\Variable\Klass\KlassException;
use Citrus\Variable\Klass\KlassFormat;
use PHPUnit\Framework\TestCase;

/**
 * klass例外のテスト
 */
class KlassExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function toExceptionCommentString_想定通り()
    {
        // パターン1
        $return = (new KlassException(\Exception::class))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
     * @throws Exception
EXPECTED;
        $this->assertSame($expected, $return->toExceptionCommentString());
    }
}
