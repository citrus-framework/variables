<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

use Citrus\Variable\Strings;

/**
 * klassクラス宣言まわりの文字列
 */
class KlassSignature
{
    /**
     * 継承の文字列
     * @param string|null $extends_name 継承親クラス名
     * @return string
     */
    public static function extends(string|null $extends_name): string
    {
        return ($extends_name !== null ? sprintf(' extends %s', $extends_name) : '');
    }

    /**
     * 実装の文字列
     * @param string[] $implements_names インターフェース名
     * @return string
     */
    public static function implements(array $implements_names): string
    {
        return (count($implements_names) > 0 ? sprintf(' implements %s', implode(', ', $implements_names)) : '');
    }

    /**
     * クラスコメントの文字列
     * @param string|null $class_comment クラスコメント
     * @param string      $format        クラスコメントのフォーマット
     * @return string
     */
    public static function classComment(string|null $class_comment, string $format): string
    {
        // 存在しなければ空文字
        if ($class_comment === null)
        {
            return '';
        }

        // 置換して返却
        return PHP_EOL . Strings::patternReplace(['{{CLASS_COMMENT}}' => $class_comment], $format);
    }
}
