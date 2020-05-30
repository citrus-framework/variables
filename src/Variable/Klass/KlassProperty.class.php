<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

use Citrus\Variable\Clonable;
use Citrus\Variable\Strings;

/**
 * klassプロパティ
 */
class KlassProperty
{
    use Clonable;
    use Formatable;

    /** @var string フィールド名 */
    private $name;

    /** @var string 型 */
    private $type;

    /** @var string コメント */
    private $comment;

    /** @var string アクセス権 */
    private $visibility;

    /** @var mixed デフォルト値 */
    private $default_value;

    /** @var string 出力フォーマット */
    private $output_format = <<<'FORMAT'
{{INDENT}}/** @var {{TYPE}} {{COMMENT}} */
{{INDENT}}{{VISIBILITY}} ${{FIELD_NAME}} = {{DEFAULT_VALUE}};
FORMAT;



    /**
     * constructor.
     *
     * @param string|null $type          型
     * @param string      $name          フィールド名
     * @param mixed|null  $default_value デフォルト値
     * @param string|null $comment       コメント
     * @param string|null $visibility    アクセス権
     */
    public function __construct(string $type,
                                string $name,
                                $default_value = null,
                                string $comment = '',
                                string $visibility = KlassVisibility::TYPE_PUBLIC
    ) {
        $this->name = $name;
        $this->default_value = $default_value;
        $this->type = $type;
        $this->comment = $comment;
        $this->visibility = $visibility;
    }



    /**
     * 出力
     *
     * @return string
     */
    public function toString(): string
    {
        // デフォルト値
        $default_value = $this->default_value;
        // デフォルト値がnullの場合
        if (true === is_null($default_value))
        {
            $default_value = $default_value ?: 'null';
        }
        else
        {
            // タイプがstringの場合
            if ('string' === $this->type)
            {
                $default_value = sprintf('\'%s\'', $default_value);
            }
        }

        // 置換パターン
        $replace_patterns = [
            '{{INDENT}}' => $this->callFormat()->indent,
            '{{TYPE}}' => $this->type,
            '{{COMMENT}}' => $this->comment,
            '{{VISIBILITY}}' => $this->visibility,
            '{{FIELD_NAME}}' => $this->name,
            '{{DEFAULT_VALUE}}' => $default_value,
        ];

        // 置換して返却
        return Strings::patternReplace($replace_patterns, $this->output_format);
    }
}
