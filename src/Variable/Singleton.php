<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
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
        static $singletons = [];
        if (false === array_key_exists(static::class, $singletons))
        {
            $singletons[static::class] = new static();
        }
        return $singletons[static::class];
    }
}
