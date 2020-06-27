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
 * klass変数
 */
class KlassVariable
{
    use Clonable;

    /** @var string 型 */
    protected $type;

    /** @var string 変数名 */
    protected $name;

    /** @var mixed|null デフォルト値 */
    protected $default_value;

    /** @var bool null許容 */
    protected $nullable = false;

    /** @var string コメント */
    protected $comment;

    /** @var string 引数の変数型フォーマット */
    private $argument_type_format = <<<'FORMAT'
{{NULLABLE_MARK}}{{TYPE}}
FORMAT;

    /** @var string コメントの変数型フォーマット */
    private $comment_type_format = <<<'FORMAT'
{{TYPE}}{{WITH_NULL}}
FORMAT;

    /** @var string デフォルト値フォーマット */
    private $default_value_format = <<<'FORMAT'
{{WITH_DEFAULT_VALUE}}
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
    public function __construct(string $type,
                                string $name, $default_value = null,
                                bool $nullable = false,
                                ?string $comment = null)
    {
        $this->type = $type;
        $this->name = $name;
        $this->default_value = $default_value;
        $this->nullable = $nullable;
        $this->comment = $comment;
    }



    /**
     * 引数の変数型文字列の返却
     *
     * @return string
     */
    public function toArgumentTypeString(): string
    {
        // mixedの場合
        $is_mixed = ('mixed' === $this->type);
        // ?マークでnullを表す
        $is_nullable_mark = (true === $this->nullable and false === $is_mixed);

        // 置換パターン
        $replace_patterns = [
            '{{TYPE}}' => (false === $is_mixed ? $this->type : ''),
            '{{NULLABLE_MARK}}' => (true === $is_nullable_mark ? '?' : ''),
        ];

        // 置換して返却
        return Strings::patternReplace($replace_patterns, $this->argument_type_format);
    }



    /**
     * コメントの変数型文字列の返却
     *
     * @return string
     */
    public function toCommentTypeString(): string
    {
        // 置換パターン
        $replace_patterns = [
            '{{TYPE}}' => $this->type,
            '{{WITH_NULL}}' => (true === $this->nullable ? '|null' : ''),
        ];

        // 置換して返却
        return Strings::patternReplace($replace_patterns, $this->comment_type_format);
    }



    /**
     * デフォルト値の返却
     *
     * @return string
     */
    public function toWithDefaultValueString(): string
    {
        // デフォルト値
        $default_value = $this->default_value;
        // デフォルト値がnull、且つ、変数がnullableの場合
        if (true === is_null($this->default_value) and true === $this->nullable)
        {
            $default_value = 'null';
        }
        // デフォルト値に指定がある、且つ、型がboolの場合
        if (false === is_null($this->default_value) and 'bool' === $this->type)
        {
            $default_value = (true === $this->default_value ? 'true' : 'false');
        }

        // デフォルト値の文字列がある場合は、イコールを付与
        $with_default_value = (false === is_null($default_value) ? sprintf(' = %s', $default_value) : '');

        // 置換パターン
        $replace_patterns = [
            '{{WITH_DEFAULT_VALUE}}' => $with_default_value,
        ];

        // 置換して返却
        return Strings::patternReplace($replace_patterns, $this->default_value_format);
    }
}
