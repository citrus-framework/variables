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
     *
     * $context_path : path1.path2
     * ['path1' => ['path2' => 111]]
     *
     * @param string $context_path
     * @return mixed
     */
    public function getPathValue(string $context_path)
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
                // getterがあれば利用する
                case method_exists($object, $method_name):
                    $object = $object->$method_name();
                    break;
                // 汎用getterがあれば利用する
                case method_exists($object, 'get'):
                    $object = $object->get($contexts[$i]);
                    break;
                // 直接指定する
                default:
                    $object = $object->{$contexts[$i]};
            }
        }

        return $object;
    }



    /**
     * パスを利用して値を設定する
     *
     * $context_path : path1.path2
     * ['path1' => ['path2' => 111]]
     *
     * @param string $context_path
     * @param mixed  $value
     */
    public function setPathValue(string $context_path, $value): void
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
                    // setterがあれば利用する
                    case method_exists($object, $method_name):
                        $object->$method_name($value);
                        break;
                    // 汎用setterがあれば利用する
                    case method_exists($object, 'set'):
                        $object->set($property_name, $value);
                        break;
                    // 直接指定する
                    default:
                        $object->$property_name = $value;
                }
                break;
            }

            // 階層を下げる
            $object = $object->getPathValue($property_name);
        }
    }
}
