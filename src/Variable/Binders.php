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
     *
     * @param  string $key キー
     * @return mixed
     */
    public function get(string $key)
    {
        if (true === isset($this->$key))
        {
            return $this->$key;
        }
        return null;
    }



    /**
     * 汎用セッター
     *
     * @param string  $key    キー
     * @param mixed   $value  値
     * @param bool    $strict 厳密設定
     */
    public function set(string $key, $value, bool $strict = false): void
    {
        if (true === $strict)
        {
            if (true === property_exists($this, $key))
            {
                $this->$key = $value;
            }
        }
        else
        {
            $this->$key = $value;
        }
    }



    /**
     * 汎用追加処理
     *
     * @param string $key
     * @param mixed  $value
     */
    public function add($key, $value): void
    {
        $add = &$this->$key;

        if (true === is_null($add))
        {
            $add = (true === is_array($value) ? $value : [$value]);
        }
        else
        {
            if (true === is_array($add))
            {
                if (true === is_array($value))
                {
                    $add += $value;
                }
                else
                {
                    array_push($add, $value);
                }
            }
            else
            {
                $add = [$add, $value];
            }
        }
    }



    /**
     * 汎用削除
     *
     * @param array|string $key
     */
    public function remove($key): void
    {
        if (true === is_array($key))
        {
            foreach ($key as $one)
            {
                unset($this->$one);
            }
        }
        else
        {
            unset($this->$key);
        }
    }



    /**
     * 配列当て込み処理
     *
     * @param array|null $array
     * @param bool|null  $strict
     */
    public function bindArray(?array $array = null, ?bool $strict = false): void
    {
        if (true === is_null($array))
        {
            return;
        }
        foreach ($array as $ky => $vl)
        {
            $this->set($ky, $vl, $strict);
        }
    }



    /**
     * オブジェクト当て込み処理
     *
     * @param mixed|null $object
     * @param bool|null  $strict
     */
    public function bindObject($object = null, ?bool $strict = false): void
    {
        if (true === is_null($object))
        {
            return;
        }
        $array = get_object_vars($object);
        $this->bindArray($array, $strict);
    }



    /**
     * インスタンスを生成して、変数をバインドする
     *
     * @param object|array $data バインドする変数
     * @param bool         $strict 厳密設定
     * @return self
     */
    public static function makeAndBind(object|array $data, ?bool $strict = false): self
    {
        $self = new static();

        if (true === is_object($data))
        {
            $self->bindObject($data);
        }
        else if (true === is_array($data))
        {
            $self->bindArray($data);
        }

        return $self;
    }
}
