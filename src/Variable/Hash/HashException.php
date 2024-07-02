<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Hash;

use Citrus\CitrusException;

/**
 * ハッシュ例外
 */
class HashException extends CitrusException
{
    /**
     * {@inheritDoc}
     * @throws HashException
     */
    public static function exceptionIf($expr, string $message): void
    {
        parent::exceptionIf($expr, $message);
    }

    /**
     * {@inheritDoc}
     * @throws HashException
     */
    public static function exceptionElse($expr, string $message): void
    {
        parent::exceptionElse($expr, $message);
    }
}
