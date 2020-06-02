<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

use Citrus\Variable\Strings;

/**
 * klassトレイト
 */
class KlassTrait
{
    use Formatable;

    /** @var string トレイト名 */
    private $name;

    /** @var string 出力フォーマット */
    private $output_format = <<<'FORMAT'
{{INDENT}}use {{TRAIT_NAME}};
FORMAT;



    /**
     * constructor.
     *
     * @param string $name トレイト名
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }



    /**
     * 出力
     *
     * @return string
     */
    public function toString(): string
    {
        // 置換パターン
        $replace_patterns = [
            '{{INDENT}}' => $this->callFormat()->indent,
            '{{TRAIT_NAME}}' => $this->name,
        ];

        // 置換して返却
        return Strings::patternReplace($replace_patterns, $this->output_format);
    }
}