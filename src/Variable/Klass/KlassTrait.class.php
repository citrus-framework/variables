<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

use Citrus\Variable\FQNs;

/**
 * クラストレイト
 */
class KlassTrait
{
    /** @var string FQN 完全修飾名(autoloadのuseに利用するため) */
    private $fqn;

    /** @var string 出力フォーマット */
    private $output_format = <<<FORMAT
{{INDENT}}use {{TRAIT_NAME}};
FORMAT;



    /**
     * constructor.
     *
     * @param string $fqn 完全修飾名
     */
    public function __construct(string $fqn)
    {
        $this->fqn = $fqn;
    }



    /**
     * 出力
     *
     * @param KlassFormat $format フォーマット定義
     * @return string
     */
    public function toString(KlassFormat $format): string
    {
        // FQNからトレイト名に変換
        $trait_name = FQNs::convertClassName($this->fqn);

        // 置換パターン
        $replace_patterns = [
            '{{INDENT}}' => $format->indent,
            '{{TRAIT_NAME}}' => $trait_name,
        ];

        // 置換して返却
        return str_replace(array_keys($replace_patterns), array_values($replace_patterns), $this->output_format);
    }
}
