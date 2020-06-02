<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

use ReflectionProperty;

/**
 * リフレクションプロパティ拡張
 */
class ReflectionProperties
{
    /**
     * プライベートなプロパティの値を取得
     *
     * @param object $object オブジェクト
     * @param string $property プロパティ
     * @return mixed
     * @throws \ReflectionException
     */
    public static function call(object $object, string $property)
    {
        // リフレクション
        $ref = new ReflectionProperty(get_class($object), $property);
        // アクセス可
        $ref->setAccessible(true);
        // プロパティの値を返却
        return $ref->getValue($object);
    }
}
