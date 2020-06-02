<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

use DateTime;

/**
 * 日付拡張
 */
class Dates extends DateTime
{
    /** @var self 現時刻キャッシュ */
    private static $NOW;



    /**
     * 現時刻を(未設定であれば初期化して)取得
     *
     * @return self
     */
    public static function now(): self
    {
        if (true === is_null(self::$NOW))
        {
            self::clear();
        }
        return clone self::$NOW;
    }



    /**
     * 現時刻を初期化する
     *
     * @see https://www.php.net/manual/ja/datetime.construct.php
     * > 5.3.0 time が 日付と時刻の書式 として無効な場合に、例外がスローされるようになりました。
     * 親のDateTimeの第1引数に起因する例外のため、未指定の今回は握りつぶす
     *
     * @return self
     */
    public static function clear(): self
    {
        try
        {
            self::$NOW = new static();
        }
        catch (\Exception $e)
        {
        }

        return self::$NOW;
    }



    /**
     * よく使われる 2020-01-02 03:04:05 のフォーマットで返す
     *
     * @return string
     */
    public function formatTimestamp(): string
    {
        return $this->format('Y-m-d H:i:s');
    }



    /**
     * よく使われる 2020-01-02 03:04:05+0900 のフォーマットで返す
     *
     * @return string
     */
    public function formatTimestampWithTimezone(): string
    {
        return $this->format('Y-m-d H:i:sO');
    }
}