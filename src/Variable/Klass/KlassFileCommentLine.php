<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

use Citrus\Variable\Strings;

/**
 * klassファイルコメントの行
 */
class KlassFileCommentLine
{
    /** コメント一つ分のフォーマット文字列 */
    private const string ONE_FORMAT = ' * @{{TYPE}} {{CONTEXT}}';

    /** コメント平文のフォーマット文字列 */
    private const string ROW_FORMAT = ' * {{CONTEXT}}';

    /** コメントスペースフォーマット文字列 */
    private const string SPACE_FORMAT = ' *';

    /**
     * コメント一つ分の行の配列を返却
     * @param string $type          コメントタイプ
     * @param string $context       コンテキスト
     * @param bool   $is_need_space true:平文の後にコメントスペースが必要
     * @return string[]
     */
    public static function toLines(string $type, string $context, bool $is_need_space): array
    {
        // コメントの分類
        $is_row = ($type === KlassFileComment::RAW);
        // フォーマット
        $patterns = [
            '{{TYPE}}' => $type,
            '{{CONTEXT}}' => $context,
        ];
        $lines = [Strings::patternReplace($patterns, ($is_row === true ? self::ROW_FORMAT : self::ONE_FORMAT))];
        // コメントスペースが必要でタイプが平文の場合はスペースを入れておく
        if ($is_need_space === true and $is_row === true)
        {
            $lines[] = self::SPACE_FORMAT;
        }

        return $lines;
    }
}
