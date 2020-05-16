<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

use Citrus\Variable\Strings;

/**
 * klassプロパティ
 */
class KlassProperty
{
    /** @var string アクセス権限 PUBLIC */
    public const VISIBILITY_PUBLIC = 'public';

    /** @var string アクセス権限 PRIVATE */
    public const VISIBILITY_PRIVATE = 'private';

    /** @var string アクセス権限 protected */
    public const VISIBILITY_PROTECTED = 'protected';



    /** @var string フィールド名 */
    private $field_name;

    /** @var string 型 */
    private $type;

    /** @var string コメント */
    private $comment;

    /** @var string アクセス権 */
    private $visibility;

    /** @var mixed デフォルト値 */
    private $default_value;

    /** @var string 出力フォーマット */
    private $output_format = <<<FORMAT
{{INDENT}}/** @var {{TYPE}} {{COMMENT}} */
{{INDENT}}{{VISIBILITY}} \${{FIELD_NAME}} = {{DEFAULT_VALUE}};
FORMAT;



    /**
     * constructor.
     *
     * @param string      $field_name    フィールド名
     * @param mixed|null  $default_value デフォルト値
     * @param string|null $type          型
     * @param string|null $comment       コメント
     * @param string|null $visibility    アクセス権
     */
    public function __construct(string $field_name,
                                $default_value = null,
                                string $type = '',
                                string $comment = '',
                                string $visibility = KlassVisibility::TYPE_PUBLIC
    )
    {
        $this->field_name = $field_name;
        $this->default_value = $default_value;
        $this->type = $type;
        $this->comment = $comment;
        $this->visibility = $visibility;
    }



    /**
     * 出力
     *
     * @param KlassFormat $format フォーマット定義
     * @return string
     */
    public function toString(KlassFormat $format): string
    {
        // デフォルト値
        $default_value = $this->default_value;
        // デフォルト値がnullの場合
        if (true === is_null($default_value))
        {
            $default_value = $default_value ?: 'null';
        }
        // タイプがstringの場合
        else if ('string' === $this->type)
        {
            $default_value = sprintf('\'%s\'', $default_value);
        }



        // 置換パターン
        $replace_patterns = [
            '{{INDENT}}' => $format->indent,
            '{{TYPE}}' => $this->type,
            '{{COMMENT}}' => $this->comment,
            '{{VISIBILITY}}' => $this->visibility,
            '{{FIELD_NAME}}' => $this->field_name,
            '{{DEFAULT_VALUE}}' => $default_value,
        ];

        // 置換して返却
        return Strings::patternReplace($replace_patterns, $this->output_format);
    }
}
