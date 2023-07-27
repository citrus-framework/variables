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
     * @param object|array|string|float|int|bool|null $object
     * @return bool
     * @deprecated
     */
    public function equals(object|array|string|float|int|bool|null $object): bool
    {
        return ($this === $object);
    }

    /**
     * プロパティ取得
     *
     * @return array
     * @deprecated
     */
    public function properties(): array
    {
        return get_object_vars($this);
    }

    /**
     * シリアライズ
     *
     * @return string
     * @deprecated
     */
    public function serialize(): string
    {
        return serialize($this);
    }

    /**
     * クラス名取得
     *
     * @return string
     * @deprecated
     */
    public function getClass(): string
    {
        return $this::class;
    }
}
