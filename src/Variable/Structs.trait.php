<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

/**
 * 共通オブジェクト操作
 */
trait Structs
{
    /**
     * オブジェクト比較
     *
     * @param mixed $object
     * @return bool
     */
    public function equals($object): bool
    {
        return ($this === $object);
    }



    /**
     * プロパティ取得
     *
     * @return array
     */
    public function properties(): array
    {
        return get_object_vars($this);
    }



    /**
     * シリアライズ
     *
     * @return string
     */
    public function serialize(): string
    {
        return serialize($this);
    }



    /**
     * クラス名取得
     *
     * @return string
     */
    public function getClass(): string
    {
        return get_class($this);
    }



    /**
     * 汎用ゲッター
     *
     * @param  string $key
     * @return mixed
     * @deprecated
     */
    public function get($key)
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
     * @param mixed $key
     * @param mixed $value
     * @param bool  $strict
     */
    public function set($key, $value, bool $strict = false): void
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
     * 汎用の空情報の削除
     *
     * @param string|string[] $key
     */
    public function removeIsEmpty($key): void
    {
        if (true === is_array($key))
        {
            foreach ($key as $one)
            {
                // 再起
                $this->removeIsEmpty($one);
            }
        }
        else
        {
            if (true === empty($this->$key))
            {
                unset($this->$key);
            }
        }
    }



    /**
     * 汎用当て込み処理
     *
     * @param array|null $array
     * @param bool|null  $strict
     */
    public function bind(?array $array = null, ?bool $strict = false): void
    {
        $this->bindArray($array, $strict);
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
     * get value from context path
     *
     * @param string $context
     * @return mixed
     */
    public function getFromContext(string $context)
    {
        $context_list = explode('.', $context);
        $context_size = count($context_list);
        $context_get_limit = $context_size - 1;

        $object = $this;
        for ($i = 1; $i <= $context_get_limit; $i++)
        {
            $method = 'get';
            $method_properties = explode('_', $context_list[$i]);
            foreach ($method_properties as $one)
            {
                $method .= ucfirst(strtolower($one));
            }
            if (true === method_exists($object, $method))
            {
                $object = $object->$method();
            }
            else
            {
                $object = $object->get($context_list[$i]);
            }
        }

        return $object;
    }



    /**
     * set value from context path
     *
     * @param string $context
     * @param mixed  $value
     */
    public function setFromContext(string $context, $value): void
    {
        // condition.rowid -> [ 'condition', 'rowid' ]
        $context_list = explode('.', $context);
        $context_size = count($context_list);

        $object = $this;
        foreach ($context_list as $idx => $property_name)
        {
            // 設定したいオブジェクト
            if ($idx === ($context_size - 1))
            {
                $object->set($property_name, $value);
                break;
            }

            // 階層を下げる
            $target = $object->get($property_name);
            if (true === is_null($target))
            {
                $method_name = 'call' . ucfirst($property_name);
                $target = $object->$method_name();
            }
            if (true === is_null($target))
            {
                break;
            }
            $object = $target;
        }
    }



    /**
     * null以外のプロパティを取得
     *
     * @return array
     */
    public function notNullProperties(): array
    {
        $properties = $this->properties();

        $results = [];
        foreach ($properties as $ky => $vl)
        {
            if (false === is_null($vl))
            {
                $results[$ky] = $vl;
            }
        }
        return $results;
    }
}
