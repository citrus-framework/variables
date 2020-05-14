<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

/**
 * klass引数
 */
class KlassArgument extends KlassVariable
{
    /** @var string 出力フォーマット */
    private $output_format = <<<FORMAT
{{TYPE}}{{TYPE_SEPARATE}}\${{NAME}}{{WITH_DEFAULT_VALUE}}
FORMAT;

    /** @var string 出力フォーマット */
    private $comment_format = <<<FORMAT
{{INDENT}} * @param {{TYPE}}{{ALIGNMENT_SPACE1}}\${{NAME}}{{ALIGNMENT_SPACE2}}{{COMMENT}}
FORMAT;



    /**
     * 出力
     *
     * @param KlassFormat $format フォーマット定義
     * @return string
     */
    public function toArgumentString(KlassFormat $format): string
    {
        // タイプ文字列
        $type = $this->toArgumentTypeString();

        // タイプセパレータ
        $type_separate = ('' === $type ? '' : ' ');

        // デフォルト値
        $default_value = $this->default_value;
        // デフォルト値がnullではない場合
        if (false === is_null($default_value))
        {
            // タイプがstringの場合
            if ('string' === $this->type)
            {
                $default_value = sprintf('\'%s\'', $default_value);
            }
        }
        // イコールをつける
        $with_default_value = '';
        if (false === is_null($default_value))
        {
            $with_default_value = sprintf(' = %s', $default_value);
        }

        // 置換パターン
        $replace_patterns = [
            '{{TYPE}}' => $type,
            '{{TYPE_SEPARATE}}' => $type_separate,
            '{{NAME}}' => $this->name,
            '{{WITH_DEFAULT_VALUE}}' => $with_default_value,
        ];

        // 置換して返却
        return str_replace(array_keys($replace_patterns), array_values($replace_patterns), $this->output_format);
    }



    /**
     * 出力
     *
     * @param KlassFormat $format フォーマット定義
     * @return string
     */
    public function toCommentString(KlassFormat $format): string
    {
        // タイプ
        $type = $this->toCommentTypeString();

        // デフォルト値
        $default_value = $this->default_value;
        // デフォルト値がnullではない場合
        if (false === is_null($default_value))
        {
            // タイプがstringの場合
            if ('string' === $this->type)
            {
                $default_value = sprintf('\'%s\'', $default_value);
            }
        }

        // 置換パターン
        $replace_patterns = [
            '{{INDENT}}' => $format->indent,
            '{{TYPE}}' => $type,
            '{{ALIGNMENT_SPACE1}}' => ' ',
            '{{ALIGNMENT_SPACE2}}' => (false === is_null($this->comment) ? ' ' : ''),
            '{{NAME}}' => $this->name,
            '{{COMMENT}}' => $this->comment,
        ];

        // 置換して返却
        return str_replace(array_keys($replace_patterns), array_values($replace_patterns), $this->comment_format);
    }
}
