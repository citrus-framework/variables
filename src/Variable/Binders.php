<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

/**
 * 設定系操作
 */
trait Binders
{
    /**
     * 汎用ゲッター
     * @param  string $key キー
     * @return object|array|string|float|int|bool|null
     */
    public function get(string $key): object|array|string|float|int|bool|null
    {
        if (isset($this->$key) === true)
        {
            return $this->$key;
        }
        return null;
    }

    /**
     * 汎用セッター
     * @param string                                  $key    キー
     * @param object|array|string|float|int|bool|null $value  値
     * @param bool                                    $strict 厳密設定
     */
    public function set(string $key, object|array|string|float|int|bool|null $value, bool $strict = false): void
    {
        if (BinderSupports::isSettable($this, $key, $strict) === true)
        {
            $this->$key = $value;
        }
    }

    /**
     * 汎用追加処理
     * @param string                                  $key
     * @param object|array|string|float|int|bool|null $value
     */
    public function add(string $key, object|array|string|float|int|bool|null $value): void
    {
        BinderAppend::append($this->$key, $value);
    }

    /**
     * 汎用削除
     * @param array|string $key
     */
    public function remove($key): void
    {
        $keys = BinderSupports::toKeys($key);
        array_walk($keys, function ($one): void {
            unset($this->$one);
        });
    }

    /**
     * 配列当て込み処理
     * @param array|null $array
     * @param bool|null  $strict
     */
    public function bindArray(?array $array = null, ?bool $strict = false): void
    {
        $items = BinderSupports::orEmpty($array);
        array_walk($items, function ($vl, $ky) use ($strict): void {
            $this->set($ky, $vl, $strict);
        });
    }

    /**
     * オブジェクト当て込み処理
     * @param object|array|string|float|int|bool|null $object
     * @param bool|null                               $strict
     */
    public function bindObject(object|array|string|float|int|bool|null $object = null, ?bool $strict = false): void
    {
        if ($object === null)
        {
            return;
        }
        $array = get_object_vars($object);
        $this->bindArray($array, $strict);
    }

    /**
     * インスタンスを生成して、変数をバインドする
     * @param object|array $data バインドする変数
     * @param bool         $strict 厳密設定
     * @return self
     */
    public static function makeAndBind(object|array $data, ?bool $strict = false): self
    {
        $self = new static();

        if (is_object($data) === true)
        {
            $self->bindObject($data, $strict);
        }
        else
        {
            $self->bindArray($data, $strict);
        }

        return $self;
    }
}
