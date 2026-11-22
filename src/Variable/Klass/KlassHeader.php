<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

/**
 * klassクラスより前の部分の文字列
 */
class KlassHeader
{
    /**
     * 厳密な型検査の行
     * @param bool $is_strict_types true:厳密な型検査
     * @return string
     */
    public static function strictTypes(bool $is_strict_types): string
    {
        return ($is_strict_types === true ? PHP_EOL . 'declare(strict_types=1);' : '');
    }

    /**
     * ファイルコメントの行
     * @param KlassFileComment|null $fileComment ファイルコメント
     * @return string
     */
    public static function fileComment(KlassFileComment|null $fileComment): string
    {
        return ($fileComment !== null ? PHP_EOL . $fileComment->toCommentString() : '');
    }

    /**
     * ネームスペースの行
     * @param string|null $namespace ネームスペース
     * @return string
     */
    public static function namespace(string|null $namespace): string
    {
        return ($namespace !== null ? PHP_EOL . sprintf('namespace %s;', $namespace) : '');
    }
}
