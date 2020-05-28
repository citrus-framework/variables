<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable\Klass;

use Citrus\Variable\Klass\KlassFormat;
use Citrus\Variable\Klass\KlassProperty;
use Citrus\Variable\Klass\KlassTrait;
use PHPUnit\Framework\TestCase;

/**
 * klassトレイトのテスト
 */
class KlassTraitTest extends TestCase
{
    /**
     * @test
     */
    public function toString_想定通り()
    {
        // パターン
        $trait = new KlassTrait(self::class);
        $expected = <<<'EXPECTED'
    use KlassTraitTest;
EXPECTED;
        $this->assertSame($expected, $trait->toString(new KlassFormat()));
    }
}
