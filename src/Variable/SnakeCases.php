<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

/**
 * スネークケース変換処理
 */
class SnakeCases
{
    /**
     * 文字列をスネークケースに変換する
     * @param string $context 対象文字列
     * @param string $glue    グルー文字列
     * @return string
     */
    public static function convert(string $context, string $glue = '_'): string
    {
        $result = '';
        $ascii_a = ord('A');
        $ascii_z = ord('Z');

        $length = strlen($context);
        for ($pos = 0; $pos < $length; $pos++)
        {
            $char = substr($context, $pos, 1);
            $ascii_dec = ord($char);
            // 先頭文字以外で
            // 文字が大文字の範囲
            if ($pos > 0 and ($ascii_a <= $ascii_dec and $ascii_dec <= $ascii_z))
            {
                // 大文字の前にグルー文字列をつける
                $result .= $glue;
            }

            $result .= strtolower($char);
        }

        return $result;
    }
}
