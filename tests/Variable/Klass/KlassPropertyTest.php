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
use Citrus\Variable\Klass\KlassVisibility;
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
        $property = (new KlassProperty(
            'string',
            'name',
            '\'John\'',
            '名前',
            KlassVisibility::TYPE_PRIVATE))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
    /** @var string 名前 */
    private $name = 'John';
EXPECTED;
        $this->assertSame($expected, $property->toString());

        // パターン2
        $property = (new KlassProperty(
            'string',
            'name',
            null,
            '名前',
            KlassVisibility::TYPE_PRIVATE))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
    /** @var string 名前 */
    private $name;
EXPECTED;
        $this->assertSame($expected, $property->toString());
    }
}
