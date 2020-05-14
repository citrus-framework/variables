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
        $argument = new KlassArgument('string', 'name', null, true);
        $expected = <<<EXPECTED
?string \$name = null
EXPECTED;
        $this->assertSame($expected, $argument->toArgumentString(new KlassFormat()));

        // パターン2
        $argument = new KlassArgument('mixed', 'name');
        $expected = <<<EXPECTED
\$name
EXPECTED;
        $this->assertSame($expected, $argument->toArgumentString(new KlassFormat()));

        // パターン3
        $argument = new KlassArgument('bool', 'is_name', true);
        $expected = <<<EXPECTED
bool \$name = true
EXPECTED;
        $this->assertSame($expected, $argument->toArgumentString(new KlassFormat()));
    }


    /**
     * @test
     */
    public function toCommnetString_想定通り()
    {
        // パターン1
        $argument = new KlassArgument('string', 'name', null, true);
        $expected = <<<EXPECTED
     * @param string|null \$name
EXPECTED;
        $this->assertSame($expected, $argument->toCommentString(new KlassFormat()));

        // パターン2
        $argument = new KlassArgument('mixed', 'name', null, false, '名前');
        $expected = <<<EXPECTED
     * @param mixed \$name 名前
EXPECTED;
        $this->assertSame($expected, $argument->toCommentString(new KlassFormat()));
    }
}
