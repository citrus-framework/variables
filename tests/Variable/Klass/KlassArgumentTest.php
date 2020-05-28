<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable\Klass;

use Citrus\Variable\Klass\KlassArgument;
use Citrus\Variable\Klass\KlassFormat;
use PHPUnit\Framework\TestCase;

/**
 * klass引数のテスト
 */
class KlassArgumentTest extends TestCase
{
    /**
     * @test
     */
    public function toArgumentString_想定通り()
    {
        // パターン1
        $argument = (new KlassArgument('string', 'name', null, true))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
?string $name = null
EXPECTED;
        $this->assertSame($expected, $argument->toArgumentString());

        // パターン2
        $argument = (new KlassArgument('mixed', 'name'))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
$name
EXPECTED;
        $this->assertSame($expected, $argument->toArgumentString());

        // パターン3
        $argument = (new KlassArgument('bool', 'is_name', true))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
bool $is_name = true
EXPECTED;
        $this->assertSame($expected, $argument->toArgumentString());
    }


    /**
     * @test
     */
    public function toCommentString_想定通り()
    {
        // パターン1
        $argument = (new KlassArgument('string', 'name', null, true))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
     * @param string|null $name
EXPECTED;
        $this->assertSame($expected, $argument->toCommentString());

        // パターン2
        $argument = (new KlassArgument('mixed', 'name', null, false, '名前'))
            ->setFormat(new KlassFormat());
        $expected = <<<'EXPECTED'
     * @param mixed $name 名前
EXPECTED;
        $this->assertSame($expected, $argument->toCommentString());
    }


    /**
     * @test
     */
    public function toArgumentsString_想定通り()
    {
        // パターン1
        $arguments = [
            new KlassArgument('string', 'name1'),
            new KlassArgument('bool', 'name2', true),
            new KlassArgument('mixed', 'name3', null, true),
            new KlassArgument('string', 'name4', null, true),
        ];
        $expected = <<<'EXPECTED'
string $name1, bool $name2 = true, $name3 = null, ?string $name4 = null
EXPECTED;
        $this->assertSame($expected, KlassArgument::toArgumentsString($arguments, new KlassFormat()));
    }
}
