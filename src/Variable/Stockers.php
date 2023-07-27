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
use Citrus\Variable\Stockers\StockedType;

/**
 * ストック処理
 */
class Stockers
{
    /** @var StockedItem[]  */
    private static array $items = [];



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
    public static function addItem(StockedItem|array $items): void
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
     * @param StockedType $type
     * @return StockedItem[]
     */
    public static function itemsOfType(StockedType $type): array
    {
        return Collection::stream(self::callItems())->filter(function (StockedItem $vl) use ($type) {
            // タイプが一致しているかどうか
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
        return Collection::stream(self::callItems())->filter(function (StockedItem $vl) use ($tag) {
            // タグが一致しているかどうか
            return ($vl->tag === $tag);
        })->toList();
    }

    /**
     * タイプでポップする
     *
     * @param StockedType $type
     * @return StockedItem[]
     */
    public static function popWithType(StockedType $type): array
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
     * @param StockedType $type
     * @return void
     */
    public static function removeWithType(StockedType $type): void
    {
        // 削除後メッセージを取得
        $items = Collection::stream(self::callItems())->remove(function (StockedItem $vl) use ($type) {
            // タグが一致しているかどうか(一致しているものが削除対象)
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
    public static function removeWithTag(string $tag): void
    {
        // 削除後メッセージを取得
        $items = Collection::stream(self::callItems())->remove(function (StockedItem $vl) use ($tag) {
            // タグが一致しているかどうか(一致しているものが削除対象)
            return ($vl->tag === $tag);
        })->toList();

        // 再設定
        self::$items = $items;
    }
}
