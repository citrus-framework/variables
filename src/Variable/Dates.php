<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

use DateInterval;
use DateTime;

/**
 * 日付拡張
 */
class Dates extends DateTime
{
    /** @var self|null 現時刻キャッシュ */
    private static Dates|null $NOW = null;

    /**
     * 日付文字列から生成する
     * @param string $date 日付文字列
     * @return $this|null
     */
    public static function new(string $date): ?self
    {
        try
        {
            return new Dates($date);
        }
        catch (\Exception $e)
        {
            return null;
        }
    }

    /**
     * UnixTimestampから生成する
     * @param int $timestamp UnixTimestamp
     * @return $this|null
     */
    public static function fromTimestamp(int $timestamp): ?self
    {
        try
        {
            $date = new Dates();
            $date->setTimestamp($timestamp);
            return $date;
        }
        catch (\Exception $e)
        {
            return null;
        }
    }

    /**
     * 現時刻を(未設定であれば初期化して)取得
     * @return $this
     * @throws VariableException
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
     * @see https://www.php.net/manual/ja/datetime.construct.php
     * > 5.3.0 time が 日付と時刻の書式 として無効な場合に、例外がスローされるようになりました。
     * 親のDateTimeの第1引数に起因する例外のため、未指定の今回は握りつぶす
     * @return $this
     * @throws VariableException
     */
    public static function clear(): self
    {
        try
        {
            self::$NOW = new static();
        }
        catch (\Exception $e)
        {
            throw VariableException::convert($e);
        }

        return self::$NOW;
    }

    /**
     * よく使われる 2020-01-02 03:04:05 のフォーマットで返す
     * @return string
     */
    public function formatTimestamp(): string
    {
        return $this->format('Y-m-d H:i:s');
    }

    /**
     * よく使われる 2020-01-02 03:04:05+0900 のフォーマットで返す
     * @return string
     */
    public function formatTimestampWithTimezone(): string
    {
        return $this->format('Y-m-d H:i:sO');
    }

    /**
     * 年の加算
     * @param int $year 加算年数
     * @return $this
     */
    public function addYear(int $year): self
    {
        return $this->add(DateInterval::createFromDateString(sprintf('%d years', $year)));
    }

    /**
     * 年の減算
     * @param int $year 減算年数
     * @return $this
     */
    public function subYear(int $year): self
    {
        return $this->sub(DateInterval::createFromDateString(sprintf('%d years', $year)));
    }

    /**
     * 月の加算
     * @param int $month 加算月数
     * @return $this
     */
    public function addMonth(int $month): self
    {
        return $this->add(DateInterval::createFromDateString(sprintf('%d months', $month)));
    }

    /**
     * 月の減算
     * @param int $month 減算月数
     * @return $this
     */
    public function subMonth(int $month): self
    {
        return $this->sub(DateInterval::createFromDateString(sprintf('%d months', $month)));
    }

    /**
     * 日付の加算
     * @param int $day 加算日数
     * @return $this
     */
    public function addDay(int $day): self
    {
        return $this->addSecond(60 * 60 * 24 * $day);
    }

    /**
     * 日数の減算
     * @param int $day 減算日数
     * @return $this
     */
    public function subDay(int $day): self
    {
        return $this->subSecond(60 * 60 * 24 * $day);
    }

    /**
     * 秒数の加算
     * @param int $second 追加秒数
     * @return $this
     */
    public function addSecond(int $second): self
    {
        return $this->add(DateInterval::createFromDateString(sprintf('%d seconds', $second)));
    }

    /**
     * 秒数の減算
     * @param int $second 追加秒数
     * @return $this
     */
    public function subSecond(int $second): self
    {
        return $this->sub(DateInterval::createFromDateString(sprintf('%d seconds', $second)));
    }

    /**
     * 月の最終日
     * @return $this
     */
    public function monthLastDay(): self
    {
        $year = (int)$this->format('Y');
        $month = (int)$this->format('m');

        return $this->setDate($year, $month + 1, 1)->subDay(1);
    }
}
