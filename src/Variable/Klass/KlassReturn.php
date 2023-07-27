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
 * klass返却値
 */
class KlassReturn
{
    use Clonable;
    use Formatable;

    /** @var string 型 */
    protected string $type;

    /** @var bool null許容 */
    protected bool $nullable = false;

    /** @var string|null コメント */
    protected string|null $comment;

    /** @var string 返却ヒントのフォーマット */
    private string $return_hint_format = <<<'FORMAT'
{{CONJUNCTION_MARK}}{{NULLABLE_MARK}}{{TYPE}}
FORMAT;

    /** @var string 返却コメントのフォーマット */
    private string $return_comment_format = <<<'FORMAT'
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
        // 型
        $type = (false === $is_mixed ? $this->type : '');
        if (true === str_ends_with($type, '[]'))
        {
            // string[]、int[]のような場合に配列に変換する
            $type = 'array';
        }

        // 置換パターン
        $replace_patterns = [
            '{{CONJUNCTION_MARK}}' => (false === $is_mixed ? ': ' : ''),
            '{{TYPE}}'             => $type,
            '{{NULLABLE_MARK}}'    => (true === $is_nullable_mark ? '?' : ''),
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
            '{{INDENT}}'             => $this->callFormat()->indent,
            '{{TYPE}}'               => $this->type,
            '{{WITH_NULL}}'          => (true === $this->nullable ? '|null' : ''),
            '{{WITH_COMMENT_SPACE}}' => (false === Strings::isEmpty($this->comment) ? ' ' : ''),
            '{{COMMENT}}'            => $this->comment,
        ];

        // 置換して返却
        return Strings::patternReplace($replace_patterns, $this->return_comment_format);
    }
}
