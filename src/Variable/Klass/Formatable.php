<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

/**
 * フォーマット処理trait
 */
trait Formatable
{
    /** @var KlassFormat フォーマット処理 */
    private KlassFormat $format;



    /**
     * フォーマットの設定
     *
     * @param KlassFormat $format
     * @return self
     */
    public function setFormat(KlassFormat $format): self
    {
        $this->format = $format;
        return $this;
    }

    /**
     * フォーマット設定の取得
     *
     * @return KlassFormat
     */
    public function callFormat(): KlassFormat
    {
        return ($this->format ?: new KlassFormat());
    }
}
