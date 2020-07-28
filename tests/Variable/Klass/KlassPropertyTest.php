<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable\Klass;

use Citrus\Variable\Klass\KlassFileComment;
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



    /**
     * @test
     */
    public function newProtectedString_想定通り()
    {
        // 共通
        $name = 'name';
        $default_value = 'John';
        $comment = '名前';

        // 想定
        $expected = new KlassProperty('string', $name, sprintf('%s', $default_value), $comment, KlassVisibility::TYPE_PROTECTED);

        // 検査対象
        $actual = KlassProperty::newProtectedString($name, $default_value, $comment);

        // 検算
        $this->assertEquals($expected, $actual);
    }



    /**
     * @test
     */
    public function newProtectedQuotedString_想定通り()
    {
        // 共通
        $name = 'name';
        $default_value = 'John';
        $comment = '名前';

        // 想定
        $expected = new KlassProperty('string', $name, sprintf('\'%s\'', $default_value), $comment, KlassVisibility::TYPE_PROTECTED);

        // 検査対象
        $actual = KlassProperty::newProtectedQuotedString($name, $default_value, $comment);

        // 検算
        $this->assertEquals($expected, $actual);
    }
}
