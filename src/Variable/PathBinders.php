<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

/**
 * パスを使った設定系操作
 */
trait PathBinders
{
    /**
     * パスを利用して値を取得する
     * $context_path : path1.path2
     * ['path1' => ['path2' => 111]]
     * @param string $context_path
     * @return object|array|string|float|int|bool|null
     */
    public function getPathValue(string $context_path): object|array|string|float|int|bool|null
    {
        // ドットで分解
        $contexts = explode('.', $context_path);
        $context_size = count($contexts);
        $context_get_limit = $context_size - 1;

        $object = $this;
        for ($i = 0; $i <= $context_get_limit; $i++)
        {
            $method_name = sprintf('get%s', Strings::upperCamelCase($contexts[$i]));
            switch (true)
            {
                case method_exists($object, $method_name):
                    // getterがあれば利用する
                    $object = $object->$method_name();
                    break;
                case method_exists($object, 'get'):
                    // 汎用getterがあれば利用する
                    $object = $object->get($contexts[$i]);
                    break;
                default:
                    // 直接指定する
                    $object = $object->{$contexts[$i]};
            }
        }
        return $object;
    }

    /**
     * パスを利用して値を設定する
     * $context_path : path1.path2
     * ['path1' => ['path2' => 111]]
     * @param string                                  $context_path
     * @param object|array|string|float|int|bool|null $value
     */
    public function setPathValue(string $context_path, object|array|string|float|int|bool|null $value): void
    {
        // ドットで分解
        $contexts = explode('.', $context_path);
        $context_size = count($contexts);

        $object = $this;
        foreach ($contexts as $index => $property_name)
        {
            // 設定したいオブジェクトまで到達したら設定する
            if ($index === ($context_size - 1))
            {
                $method_name = sprintf('set%s', Strings::upperCamelCase($property_name));
                switch (true)
                {
                    case method_exists($object, $method_name):
                        // setterがあれば利用する
                        $object->$method_name($value);
                        break;
                    case method_exists($object, 'set'):
                        // 汎用setterがあれば利用する
                        $object->set($property_name, $value);
                        break;
                    default:
                        // 直接指定する
                        $object->$property_name = $value;
                }
                break;
            }

            // 階層を下げる
            $object = $object->getPathValue($property_name);
        }
    }
}
