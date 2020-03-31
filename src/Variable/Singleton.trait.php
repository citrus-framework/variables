<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2017, CitrusFramework. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

/**
 * シングルトン
 */
trait Singleton
{
    /**
     * call singleton instance
     *
     * @return self
     */
    public static function sharedInstance(): self
    {
        static $singleton;
        if (true === is_null($singleton))
        {
            $singleton = new static();
        }
        return $singleton;
    }
}
