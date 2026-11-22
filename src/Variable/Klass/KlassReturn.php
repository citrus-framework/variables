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
     * @return string
     */
    public function toReturnHintString(): string
    {
        // 置換パターン(mixedは型を書かない、string[]、int[]のような場合は配列に変換する)
        $replace_patterns = [
            '{{CONJUNCTION_MARK}}' => KlassTypeMark::conjunction($this->type),
            '{{TYPE}}' => KlassTypeName::forReturn($this->type),
            '{{NULLABLE_MARK}}' => KlassTypeMark::nullable($this->type, $this->nullable),
        ];

        // 置換して返却
        return Strings::patternReplace($replace_patterns, $this->return_hint_format);
    }

    /**
     * 返却コメント文字列の返却
     * @return string
     */
    public function toReturnCommentString(): string
    {
        // 置換パターン
        $replace_patterns = [
            '{{INDENT}}' => $this->callFormat()->indent,
            '{{TYPE}}' => $this->type,
            '{{WITH_NULL}}' => KlassTypeMark::withNull($this->nullable),
            '{{WITH_COMMENT_SPACE}}' => (Strings::isEmpty($this->comment) === false ? ' ' : ''),
            '{{COMMENT}}' => $this->comment,
        ];

        // 置換して返却
        return Strings::patternReplace($replace_patterns, $this->return_comment_format);
    }
}
