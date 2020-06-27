<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

/**
 * ディレクトリ処理のクラス
 */
class Directories
{
    /**
     * 引数のディレクトリ文字列を適切な形に修飾する
     *
     * dir1//dir2 => dir1/dir2
     * ./dir1/dir2 => dir1/dir2
     * dir1/../dir2 => dir2
     *
     * @param string $path
     * @return string
     */
    public static function suitablePath(string $path): string
    {
        // パスを分解して逆順にする
        $paths = array_reverse(explode('/', $path));

        // 相殺レベル
        $offset_level = 0;
        // 走査
        foreach ($paths as $ky => $vl)
        {
            // 動かないパスは消す
            if ('.' === $vl)
            {
                unset($paths[$ky]);
                continue;
            }
            // 親指定がある場合は次にパスを削除する
            if ('..' === $vl)
            {
                unset($paths[$ky]);
                $offset_level++;
                continue;
            }
            // 相殺レベルがある場合は削除
            if (0 < $offset_level)
            {
                unset($paths[$ky]);
                $offset_level--;
                continue;
            }
        }
        // 正順に戻して、返却
        return implode('/', array_reverse($paths));
    }



    /**
     * パスの先頭文字を大文字化して返却
     *
     * /hoge/fuga => /Hoge/Fuga
     *
     * @param string $path      パス
     * @param string $delimiter デリミタ
     * @return string
     */
    public static function upperFirstPath(string $path, string $delimiter = '/'): string
    {
        // デリミタで分割
        $paths = explode($delimiter, $path);

        // 先頭文字だけ大文字化
        $results = [];
        foreach ($paths as $row)
        {
            $results[] = ucfirst(strtolower($row));
        }

        // デリミタで結合
        return implode($delimiter, $results);
    }
}
