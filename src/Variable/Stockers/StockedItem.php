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
    /** @var string */
    public $type;

    /** @var string */
    public $tag;

    /** @var string */
    public $content;



    /**
     * マジックメソッド、文字列化する
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('type:%s, tag:%s, %s', $this->type, $this->tag, $this->content);
    }



    /**
     * 生成処理
     *
     * @param string      $content
     * @param string|null $type
     * @param string|null $tag
     * @return static
     */
    public static function newItem(string $content, string $type = null, string $tag = null): self
    {
        $self = new self();
        $self->content = $content;
        $self->type = $type;
        $self->tag = $tag;
        return $self;
    }



    /**
     * タイプベースの生成処理
     *
     * @param string $type
     * @param string $content
     * @return static
     */
    public static function newType(string $type, string $content): self
    {
        $self = new self();
        $self->type = $type;
        $self->content = $content;
        return $self;
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
        $self = new self();
        $self->tag = $tag;
        $self->content = $content;
        return $self;
    }
}
