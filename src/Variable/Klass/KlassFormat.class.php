<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

/**
 * klassフォーマット
 */
class KlassFormat
{
    /** @var string インデントタブ */
    public const INDENT_TAB = "\t";

    /** @var string インデントスペース2 */
    public const INDENT_SPACE2 = '  ';

    /** @var string インデントスペース4 */
    public const INDENT_SPACE4 = '    ';

    /** @var string インデントスペース8 */
    public const INDENT_SPACE8 = '        ';

    /** @var string インデント */
    public $indent;

    /** @var int トレイト前後の空行数 */
    private $blank_around_trait = 0;

    /** @var int プロパティ前後の空行数 */
    private $blank_around_property = 1;

    /** @var int メソッド前後の空行数 */
    private $blank_around_method = 3;

    /** @var int プロパティとメソッドなどブロック間の空行数 */
    private $blank_between_block = 3;



    /**
     * constructor.
     *
     * @param string $indent インデント
     */
    public function __construct(string $indent = self::INDENT_SPACE4)
    {
        $this->indent = $indent;
    }



    /**
     * トレイト前後の空行数
     *
     * @param int $blank_around_trait
     * @return self
     */
    public function setBlankAroundTrait(int $blank_around_trait): self
    {
        $this->blank_around_trait = $blank_around_trait;
        return $this;
    }



    /**
     * プロパティ前後の空行数
     *
     * @param int $blank_around_property
     * @return self
     */
    public function setBlankAroundProperty(int $blank_around_property): self
    {
        $this->blank_around_property = $blank_around_property;
        return $this;
    }



    /**
     * メソッド前後の空行数
     *
     * @param int $blank_around_method
     * @return self
     */
    public function setBlankAroundMethod(int $blank_around_method): self
    {
        $this->blank_around_method = $blank_around_method;
        return $this;
    }



    /**
     * トレイトの間の空行が必要かどうかを判断して返却
     *
     * @param KlassTrait   $target
     * @param KlassTrait[] $traits
     * @return string
     */
    public function blankAroundTrait(KlassTrait $target, array $traits): string
    {
        // 配列が0版目の場合は空行はいらない
        if (0 === array_search($target, $traits))
        {
            return '';
        }

        return str_repeat(PHP_EOL, ($this->blank_around_trait + 1));
    }



    /**
     * プロパティの間の空行が必要かどうかを判断して返却
     *
     * @param KlassProperty   $target
     * @param KlassProperty[] $properties
     * @return string
     */
    public function blankAroundProperty(KlassProperty $target, array $properties): string
    {
        // 配列が0版目の場合は空行はいらない
        if (0 === array_search($target, $properties))
        {
            return '';
        }

        return str_repeat(PHP_EOL, $this->blank_around_property);
    }



    /**
     * メソッドの間の空行が必要かどうかを判断して返却
     *
     * @param KlassMethod   $target
     * @param KlassMethod[] $methods
     * @return string
     */
    public function blankAroundMethod(KlassMethod $target, array $methods): string
    {
        // 配列が0版目の場合は空行はいらない
        if (0 === array_search($target, $methods))
        {
            return '';
        }

        // eachする場合に改行が減るので足す
        return str_repeat(PHP_EOL, ($this->blank_around_method + 1));
    }



    /**
     * プロパティとメソッドなどブロック間の空行が必要かどうかを判断して返却
     *
     * @param KlassProperty[] $properties
     * @param KlassMethod[]   $methods
     * @return string
     */
    public function blankBetweenBlock(array $properties, array $methods): string
    {
        // プロパティとメソッドの配列がどちらかでも0なら空行はいらない
        if (0 === count($properties) or 0 === count($methods))
        {
            return '';
        }

        return str_repeat(PHP_EOL, $this->blank_between_block);
    }
}
