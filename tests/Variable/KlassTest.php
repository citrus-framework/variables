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
use Citrus\Variable\Klass\KlassTrait;
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
        $expected = file_get_contents(__DIR__ . '/../Sample/Citrus_20180210045129_CreateTableUsers.php');

        $body = <<<'BODY'
        return <<<SQL
SQL;
BODY;

        $klass = (new Klass('Citrus_20180210045129_CreateTableUsers'))
            ->setExtends('\\Citrus\\Migration\\Item')
            ->setNamespace('Test\\Sample')
            ->setClassComment('Migrations')
            ->setFileComment(KlassFileComment::getInstance()
                ->addComment(KlassFileComment::RAW, 'generated Citrus Migration file at 2018-02-10 04:51:29')
            )
            ->addTrait(new KlassTrait('\\Citrus\\Variable\\Instance'))
            ->addTrait(new KlassTrait('\\Citrus\\Variable\\Singleton'))
            ->addProperty(new KlassProperty('string', 'object_name', '\'users\'', 'テーブル|ビュー名'))
            ->addProperty(new KlassProperty('string', 'schema', '\'citrus\'', 'スキーマ名'))
            ->addMethod((new KlassMethod(KlassVisibility::PUBLIC, 'up', false, 'up query'))
                ->setReturn(new KlassReturn('string', false, 'SQL文字列'))
                ->setBody($body)
            )
            ->addMethod((new KlassMethod(KlassVisibility::PUBLIC, 'down', false, 'down query'))
                ->setReturn(new KlassReturn('string', false, 'SQL文字列'))
                ->setBody($body)
            );

        $this->assertSame($expected, $klass->toString());
    }

    /**
     * @test
     */
    public function toString_想定通り_traitのみ()
    {
        // パターン1
        $expected = file_get_contents(__DIR__ . '/../Sample/Integration/Condition/UserCondition.php');

        $klass = (new Klass('UserCondition'))
            ->setExtends('\\Test\\Sample\\Integration\\Property\\UserProperty')
            ->setNamespace('Test\\Sample\\Integration\\Condition')
            ->setClassComment('Class UserCondition')
            ->setFileComment(KlassFileComment::getInstance()
                ->addComment(KlassFileComment::RAW, 'generated Citrus Condition file at 2018-03-30 06:47:18')
            )
            ->addTrait(new KlassTrait('\\Citrus\\Sqlmap\\Condition'));

        $this->assertSame($expected, $klass->toString());
    }
}
