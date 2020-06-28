<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable;

use Citrus\Variable\PathBinders;
use PHPUnit\Framework\TestCase;

/**
 * パスを使った設定系操作のテスト
 */
class PathBindersTest extends TestCase
{
    /**
     * @test
     */
    public function getPathValue_想定通り()
    {
        $sample = new PathBinderSample();
        // 検算
        $this->assertSame(111, $sample->getPathValue('object.list'));
    }



    /**
     * @test
     */
    public function setPathValue_想定通り()
    {
        $sample = new PathBinderSample();
        // 設定
        $sample->setPathValue('object.list', 222);
        // 検算
        $this->assertSame(222, $sample->getPathValue('object.list'));
    }
}

class PathBinderSample
{
    use PathBinders;

    public $object;

    public function __construct()
    {
        $this->object = (new class {
            public $list = 111;
        });
    }
}
