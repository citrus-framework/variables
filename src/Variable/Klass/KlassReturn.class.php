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
 * klass返却値
 */
class KlassReturn
{
    use Formatable;

    /** @var string 型 */
    protected $type;

    /** @var bool null許容 */
    protected $nullable = false;

    /** @var string コメント */
    protected $comment;

    /** @var string 返却ヒントのフォーマット */
    private $return_hint_format = <<<'FORMAT'
{{CONJUNCTION_MARK}}{{NULLABLE_MARK}}{{TYPE}}
FORMAT;

    /** @var string 返却コメントのフォーマット */
    private $return_comment_format = <<<'FORMAT'
{{INDENT}} * @return {{TYPE}}{{WITH_NULL}}{{WITH_COMMENT_SPACE}}{{COMMENT}}
FORMAT;



    /**
     * constructor.
     *
     * @param string      $type          型
     * @param bool|null   $nullable      true:null許可
     * @param string|null $comment       コメント
     */
    public function __construct(string $type, bool $nullable = false, ?string $comment = null)
    {
        $this->type = $type;
        $this->nullable = $nullable;
        $this->comment = $comment;
    }



    /**
     * 返却ヒント文字列の返却
     *
     * @return string
     */
    public function toReturnHintString(): string
    {
        // mixedの場合
        $is_mixed = ('mixed' === $this->type);
        // ?マークでnullを表す
        $is_nullable_mark = (true === $this->nullable and false === $is_mixed);

        // 置換パターン
        $replace_patterns = [
            '{{CONJUNCTION_MARK}}' => (false === $is_mixed ? ': ' : ''),
            '{{TYPE}}' => (false === $is_mixed ? $this->type : ''),
            '{{NULLABLE_MARK}}' => (true === $is_nullable_mark ? '?' : ''),
        ];

        // 置換して返却
        return Strings::patternReplace($replace_patterns, $this->return_hint_format);
    }



    /**
     * 返却コメント文字列の返却
     *
     * @return string
     */
    public function toReturnCommentString(): string
    {
        // 置換パターン
        $replace_patterns = [
            '{{INDENT}}' => $this->callFormat()->indent,
            '{{TYPE}}' => $this->type,
            '{{WITH_NULL}}' => (true === $this->nullable ? '|null' : ''),
            '{{WITH_COMMENT_SPACE}}' => (false === Strings::isEmpty($this->comment) ? ' ' : ''),
            '{{COMMENT}}' => $this->comment,
        ];

        // 置換して返却
        return Strings::patternReplace($replace_patterns, $this->return_comment_format);
    }
}
