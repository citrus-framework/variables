<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2017, CitrusFramework. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

/**
 * インスタンス生成
 */
trait Instance
{
    /**
     * call singleton instance
     *
     * @return self
     */
    public static function getInstance(): self
    {
        return new static();
    }
}
