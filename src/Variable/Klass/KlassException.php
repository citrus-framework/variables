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
 * klass例外
 */
class KlassException
{
    use Clonable;
    use Formatable;

    /** @var string 型 */
    protected string $type;

    /** @var string 例外コメントのフォーマット */
    private string $exception_comment_format = <<<'FORMAT'
{{INDENT}} * @throws {{TYPE}}
FORMAT;



    /**
     * constructor.
     *
     * @param string $type 型
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * 例外コメント文字列の返却
     *
     * @return string
     */
    public function toExceptionCommentString(): string
    {
        // 置換パターン
        $replace_patterns = [
            '{{INDENT}}' => $this->callFormat()->indent,
            '{{TYPE}}'   => $this->type,
        ];

        // 置換して返却
        return Strings::patternReplace($replace_patterns, $this->exception_comment_format);
    }
}
