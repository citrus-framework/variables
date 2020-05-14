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
use PHPUnit\Framework\TestCase;

/**
 * klassプロパティのテスト
 */
class KlassPropertyTest extends TestCase
{
    /**
     * @test
     */
    public function toString_想定通り()
    {
        // パターン1
        $property = new KlassProperty(
            'name',
            'John',
            'string',
            '名前',
            KlassProperty::VISIBILITY_PRIVATE);
        $expected = <<<EXPECTED
    /** @var string 名前 */
    private \$name = 'John';
EXPECTED;
        $this->assertSame($expected, $property->toString(new KlassFormat()));

        // パターン2
        $property = new KlassProperty(
            'name',
            null,
            'string',
            '名前',
            KlassProperty::VISIBILITY_PRIVATE);
        $expected = <<<EXPECTED
    /** @var string 名前 */
    private \$name = null;
EXPECTED;
        $this->assertSame($expected, $property->toString(new KlassFormat()));
    }
}
