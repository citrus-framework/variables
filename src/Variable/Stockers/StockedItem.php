<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Stockers;

/**
 * ストックアイテム
 */
class StockedItem
{
    /** @var StockedType|null */
    public StockedType|null $type = null;

    /** @var string|null */
    public string|null $tag = null;

    /** @var string */
    public string $content;



    /**
     * マジックメソッド、文字列化する
     *
     * @return string
     */
    public function __toString(): string
    {
        $elements = [];
        if (false === is_null($this->type))
        {
            $elements[] = sprintf('type:%s', $this->type->value);
        }
        if (false === is_null($this->tag))
        {
            $elements[] = sprintf('tag:%s', $this->tag);
        }
        $elements[] = $this->content;
        return implode(', ', $elements);
    }

    /**
     * 生成処理
     *
     * @param string           $content
     * @param StockedType|null $type
     * @param string|null      $tag
     * @return static
     */
    public static function newItem(string $content, StockedType|null $type = null, string|null $tag = null): self
    {
        $self = new static();
        $self->content = $content;
        $self->type = $type;
        $self->tag = $tag;
        return $self;
    }

    /**
     * タイプベースの生成処理
     *
     * @param StockedType $type
     * @param string      $content
     * @return static
     */
    public static function newType(StockedType $type, string $content): self
    {
        return static::newItem($content, $type);
    }

    /**
     * タグベースの生成処理
     *
     * @param string $tag
     * @param string $content
     * @return static
     */
    public static function newTag(string $tag, string $content): self
    {
        return static::newItem($content, null, $tag);
    }
}
