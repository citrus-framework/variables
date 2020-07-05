<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable;

use Citrus\Variable\Binders;
use PHPUnit\Framework\TestCase;

/**
 * 設定系操作のテスト
 */
class BindersTest extends TestCase
{
    /**
     * @test
     */
    public function set_想定通り()
    {
        $name = 'John';

        // プロパティに設定できる
        $binderSample = new BinderSample();
        $binderSample->set('name', $name);
        $this->assertSame($name, $binderSample->get('name'));

        // 存在しないプロパティに設定できる
        $binderSample = new BinderSample();
        $binderSample->set('name2', $name);
        $this->assertSame($name, $binderSample->get('name2'));

        // 存在しないプロパティには設定できない
        $binderSample = new BinderSample();
        $binderSample->set('name2', $name, true);
        $this->assertNull($binderSample->get('name2'));
    }



    /**
     * @test
     */
    public function bindArray_想定通り()
    {
        $name = 'John';

        // プロパティに設定できる
        $binderSample = new BinderSample();
        $binderSample->bindArray(['name' => $name]);
        $this->assertSame($name, $binderSample->get('name'));

        // 存在しないプロパティに設定できる
        $binderSample = new BinderSample();
        $binderSample->bindArray(['name2' => $name]);
        $this->assertSame($name, $binderSample->get('name2'));

        // 存在しないプロパティには設定できない
        $binderSample = new BinderSample();
        $binderSample->bindArray(['name2' => $name], true);
        $this->assertNull($binderSample->get('name2'));
    }



    /**
     * @test
     */
    public function bindObject_想定通り()
    {
        $name = 'John';
        $actual = new BinderSample();
        $actual->set('name', $name);
        $actual->set('name2', $name);

        // プロパティに設定できる
        $binderSample = new BinderSample();
        $binderSample->bindObject($actual);
        $this->assertSame($name, $binderSample->get('name'));

        // 存在しないプロパティに設定できる
        $binderSample = new BinderSample();
        $binderSample->bindObject($actual);
        $this->assertSame($name, $binderSample->get('name2'));

        // 存在しないプロパティには設定できない
        $binderSample = new BinderSample();
        $binderSample->bindObject($actual, true);
        $this->assertNull($binderSample->get('name2'));
    }



    /**
     * @test
     */
    public function add_想定通り()
    {
        $name = 'John';
        $actual = new BinderSample();
        $actual->set('name', [$name, $name]);

        // プロパティに設定できる
        $binderSample = new BinderSample();
        $binderSample->add('name', $name);
        $binderSample->add('name', $name);
        $this->assertSame($binderSample->get('name'), $actual->get('name'));

        // 存在しないプロパティに設定できる
        $binderSample = new BinderSample();
        $binderSample->add('name2', $name);
        $binderSample->add('name2', $name);
        $this->assertSame($binderSample->get('name2'), $actual->get('name'));
    }



    /**
     * @test
     */
    public function remove_想定通り()
    {
        $name = 'John';

        // プロパティを削除できる
        $binderSample = new BinderSample();
        // 一度設定する
        $binderSample->set('name', $name);
        $this->assertNotNull($binderSample->get('name'));
        // 削除する
        $binderSample->remove('name');
        $this->assertNull($binderSample->get('name'));
    }
}


class BinderSample
{
    use Binders;

    public $name;
}