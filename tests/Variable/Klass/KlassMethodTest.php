<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable\Klass;

use Citrus\Variable\Klass\KlassArgument;
use Citrus\Variable\Klass\KlassException;
use Citrus\Variable\Klass\KlassFormat;
use Citrus\Variable\Klass\KlassMethod;
use Citrus\Variable\Klass\KlassReturn;
use Citrus\Variable\Klass\KlassVisibility;
use PHPUnit\Framework\TestCase;

/**
 * klassメソッドのテスト
 */
class KlassMethodTest extends TestCase
{
    /**
     * @test
     */
    public function toMethodString_想定通り()
    {
        // パターン1
        $method = (new KlassMethod(KlassVisibility::PUBLIC, 'hoge'))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
    public function hoge()
    {

    }
EXPECTED;
        $this->assertSame($expected, $method->toMethodString());

        // パターン2
        $method = (new KlassMethod(KlassVisibility::PUBLIC, 'hoge', true))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
    public static function hoge()
    {

    }
EXPECTED;
        $this->assertSame($expected, $method->toMethodString());

        // パターン3
        $method = (new KlassMethod(KlassVisibility::PUBLIC, 'hoge'))
            ->addArgument(new KlassArgument('string', 'fuga', null, true))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
    public function hoge(?string $fuga = null)
    {

    }
EXPECTED;
        $this->assertSame($expected, $method->toMethodString());

        // パターン4
        $method = (new KlassMethod(KlassVisibility::PUBLIC, 'hoge'))
            ->addArgument(new KlassArgument('string', 'fuga', null, true))
            ->setReturn(new KlassReturn('bool'))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
    public function hoge(?string $fuga = null): bool
    {

    }
EXPECTED;
        $this->assertSame($expected, $method->toMethodString());

        // パターン5
        $method = (new KlassMethod(KlassVisibility::PUBLIC, 'hoge'))
            ->addArgument(new KlassArgument('string', 'fuga', null, true))
            ->setReturn(new KlassReturn('bool'))
            ->setBody(<<<'BODY'
        return true;
BODY
            )
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
    public function hoge(?string $fuga = null): bool
    {
        return true;
    }
EXPECTED;
        $this->assertSame($expected, $method->toMethodString());
    }

    /**
     * @test
     */
    public function toCommentString_想定通り()
    {
        // パターン1
        $method = (new KlassMethod(KlassVisibility::PUBLIC, 'hoge', false, 'hoge hoge hoge'))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
    /**
     * hoge hoge hoge
     */
EXPECTED;
        $this->assertSame($expected, $method->toCommentString());

        // パターン2
        $method = (new KlassMethod(KlassVisibility::PUBLIC, 'hoge', false, 'hoge hoge hoge'))
            ->addArgument(new KlassArgument('string', 'fuga', null, false, 'ふが'))
            ->addArgument(new KlassArgument('bool', 'enable', true, true, '有効化'))
            ->setFormat(new KlassFormat());;
        $expected = <<<'EXPECTED'
    /**
     * hoge hoge hoge
     *
     * @param string $fuga ふが
     * @param bool|null $enable 有効化
     */
EXPECTED;
        $this->assertSame($expected, $method->toCommentString());

        // パターン3
        $method = (new KlassMethod(KlassVisibility::PUBLIC, 'hoge', false, 'hoge hoge hoge'))
            ->addArgument(new KlassArgument('string', 'fuga', null, false, 'ふが'))
            ->addArgument(new KlassArgument('bool', 'enable', true, true, '有効化'))
            ->setReturn(new KlassReturn('string', true, 'hoge and hoge'))
            ->setFormat(new KlassFormat());;
        $expected = <<<'EXPECTED'
    /**
     * hoge hoge hoge
     *
     * @param string $fuga ふが
     * @param bool|null $enable 有効化
     * @return string|null hoge and hoge
     */
EXPECTED;
        $this->assertSame($expected, $method->toCommentString());

        // パターン4
        $method = (new KlassMethod(KlassVisibility::PUBLIC, 'hoge', false, 'hoge hoge hoge'))
            ->addArgument(new KlassArgument('string', 'fuga', null, false, 'ふが'))
            ->addArgument(new KlassArgument('bool', 'enable', true, true, '有効化'))
            ->setReturn(new KlassReturn('string', true, 'hoge and hoge'))
            ->addException(new KlassException(self::class))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
    /**
     * hoge hoge hoge
     *
     * @param string $fuga ふが
     * @param bool|null $enable 有効化
     * @return string|null hoge and hoge
     * @throws Test\Variable\Klass\KlassMethodTest
     */
EXPECTED;
        $this->assertSame($expected, $method->toCommentString());
    }
}
