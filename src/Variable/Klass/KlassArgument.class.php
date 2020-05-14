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
class KlassArgument
{
    /** @var string 型 */
    private $type;

    /** @var string 変数名 */
    private $name;

    /** @var mixed|null デフォルト値 */
    private $default_value;

    /** @var bool null許容 */
    private $nullable = false;

    /** @var string コメント */
    private $comment;

    /** @var string 出力フォーマット */
    private $output_format = <<<FORMAT
{{MARK_NULLABLE}}{{TYPE}}{{TYPE_SEPARATE}}\${{NAME}}{{WITH_DEFAULT_VALUE}}
FORMAT;

    /** @var string 出力フォーマット */
    private $comment_format = <<<FORMAT
{{INDENT}} * @param {{TYPE}}{{WITH_NULL}}{{ALIGNMENT_SPACE1}}\${{NAME}}{{ALIGNMENT_SPACE2}}{{COMMENT}}
FORMAT;



    /**
     * constructor.
     *
     * @param string      $type          型
     * @param string      $name          変数名
     * @param mixed|null  $default_value デフォルト値
     * @param bool|null   $nullable      true:null許可
     * @param string|null $comment       コメント
     */
    public function __construct(string $type, string $name, $default_value = null, bool $nullable = false, string $comment = null)
    {
        $this->type = $type;
        $this->name = $name;
        $this->default_value = $default_value;
        $this->nullable = $nullable;
        $this->comment = $comment;
    }



    /**
     * 出力
     *
     * @param KlassFormat $format フォーマット定義
     * @return string
     */
    public function toString(KlassFormat $format): string
    {
        // タイプ
        $type = $this->type;
        // mixedの場合、もしくは|(セパレータある場合)
        if (false !== strpos($type, 'mixed') or false !== strpos($type, '|'))
        {
            $type = '';
        }

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
            '{{MARK_NULLABLE}}' => (true === $this->nullable ? '?' : ''),
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
        $type = $this->type;
//        // mixedの場合、もしくは|(セパレータある場合)
//        if (false !== strpos($type, 'mixed') or false !== strpos($type, '|'))
//        {
//            $type = '';
//        }

        // デフォルト値
        $default_value = $this->default_value;
        // デフォルト値がnullではない場合
        if (false === is_null($default_value)) {
            // タイプがstringの場合
            if ('string' === $this->type) {
                $default_value = sprintf('\'%s\'', $default_value);
            }
        }

        // 置換パターン
        $replace_patterns = [
            '{{INDENT}}' => $format->indent,
            '{{TYPE}}' => $type,
            '{{WITH_NULL}}' => (true === $this->nullable ? '|null' : ''),
            '{{ALIGNMENT_SPACE1}}' => ' ',
            '{{ALIGNMENT_SPACE2}}' => (false === is_null($this->comment) ? ' ' : ''),
            '{{NAME}}' => $this->name,
            '{{COMMENT}}' => $this->comment,
        ];

        // 置換して返却
        return str_replace(array_keys($replace_patterns), array_values($replace_patterns), $this->comment_format);
    }
}
