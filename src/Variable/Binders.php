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
}
