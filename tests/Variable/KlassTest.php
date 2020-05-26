<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable;

use Citrus\Variable\Klass;
use Citrus\Variable\Klass\KlassFileComment;
use Citrus\Variable\Klass\KlassMethod;
use Citrus\Variable\Klass\KlassProperty;
use Citrus\Variable\Klass\KlassReturn;
use Citrus\Variable\Klass\KlassVisibility;
use PHPUnit\Framework\TestCase;

/**
 * クラスジェネレータのテスト
 */
class KlassTest extends TestCase
{
    /**
     * @test
     */
    public function toString_想定通り()
    {
        // パターン1
        $expected = file_get_contents(__DIR__ . '/../Sample/migrations/Citrus_20180210045129_CreateTableUsers.php');

        $body = <<<'BODY'
        return <<<SQL
SQL;
BODY;

        $klass = (new Klass('Citrus_20180210045129_CreateTableUsers'))
            ->setExtends('\Citrus\Migration\Item')
            ->setClassComment('Migrations')
            ->setFileComment(KlassFileComment::getInstance()
                ->addComment(KlassFileComment::ROW, 'generated Citrus Migration file at 2018-02-10 04:51:29')
            )
            ->addProperty(new KlassProperty('object_name', 'users', 'string', 'テーブル|ビュー名'))
            ->addMethod((new KlassMethod(KlassVisibility::TYPE_PUBLIC, 'up', false, 'up query'))
                ->setReturn(new KlassReturn('string', false, 'SQL文字列'))
                ->setBody($body)
            )
            ->addMethod((new KlassMethod(KlassVisibility::TYPE_PUBLIC, 'down', false, 'down query'))
                ->setReturn(new KlassReturn('string', false, 'SQL文字列'))
                ->setBody($body)
            );

        $this->assertSame($expected, $klass->toString());
    }
}
