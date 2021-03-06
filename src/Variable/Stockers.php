<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

use Citrus\Collection;
use Citrus\Variable\Stockers\StockedItem;

/**
 * ストック処理
 */
class Stockers
{
    /** @var StockedItem[]  */
    private static $items = [];



    /**
     * メッセージが1件でもあるかどうか
     *
     * @return bool
     */
    public static function exists(): bool
    {
        return (0 < count(self::$items));
    }



    /**
     * メッセージの取得
     *
     * @return StockedItem[]
     */
    public static function callItems(): array
    {
        return self::$items;
    }



    /**
     * メッセージの登録
     *
     * @param StockedItem|StockedItem[] $items アイテムかアイテム配列
     * @return void
     */
    public static function addItem($items): void
    {
        // 配列の場合は再起
        if (true === is_array($items))
        {
            foreach ($items as $item)
            {
                self::addItem($item);
            }
        }

        // 追加
        self::$items[] = $items;
    }



    /**
     * タイプでフィルタリングしてメッセージを取得する
     *
     * @param string $type
     * @return StockedItem[]
     */
    public static function itemsOfType(string $type): array
    {
        return Collection::stream(self::callItems())->filter(function ($vl) use ($type) {
            // タイプが一致しているかどうか
            /** @var StockedItem $vl */
            return ($vl->type === $type);
        })->toList();
    }



    /**
     * タグでフィルタリングしてメッセージを取得する
     *
     * @param string $tag
     * @return StockedItem[]
     */
    public static function itemsOfTag(string $tag): array
    {
        return Collection::stream(self::callItems())->filter(function ($vl) use ($tag) {
            // タグが一致しているかどうか
            /** @var StockedItem $vl */
            return ($vl->tag === $tag);
        })->toList();
    }



    /**
     * タイプでポップする
     *
     * @param string $type
     * @return StockedItem[]
     */
    public static function popWithType(string $type): array
    {
        // 返す方のアイテム
        $results = self::itemsOfType($type);

        // 再設定
        self::$items = array_diff(self::callItems(), $results);

        return $results;
    }



    /**
     * タグでポップする
     *
     * @param string $tag
     * @return StockedItem[]
     */
    public static function popWithTag(string $tag): array
    {
        // 返す方のアイテム
        $results = self::itemsOfTag($tag);

        // 再設定
        self::$items = array_diff(self::callItems(), $results);

        return $results;
    }



    /**
     * アイテムの全削除
     *
     * @return void
     */
    public static function removeAll(): void
    {
        self::$items = [];
    }



    /**
     * メッセージのタイプごと削除
     *
     * @param string|null $type
     * @return void
     */
    public static function removeWithType(string $type = null): void
    {
        // 削除後メッセージを取得
        $items = Collection::stream(self::callItems())->remove(function ($vl) use ($type) {
            // タグが一致しているかどうか(一致しているものが削除対象)
            /** @var StockedItem $vl */
            return ($vl->tag === $type);
        })->toList();

        // 再設定
        self::$items = $items;
    }



    /**
     * メッセージのタグごと削除
     *
     * @param string $tag
     * @return void
     */
    public static function removeWithTag(string $tag = null): void
    {
        // 削除後メッセージを取得
        $items = Collection::stream(self::callItems())->remove(function ($vl) use ($tag) {
            // タグが一致しているかどうか(一致しているものが削除対象)
            /** @var StockedItem $vl */
            return ($vl->tag === $tag);
        })->toList();

        // 再設定
        self::$items = $items;
    }
}
