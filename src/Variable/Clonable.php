<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 202o, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

/**
 * インスタンスクローン処理
 */
trait Clonable
{
    /**
     * clone したインスタンスを返却
     *
     * @return self
     */
    public function clone(): self
    {
        return clone $this;
    }
}
