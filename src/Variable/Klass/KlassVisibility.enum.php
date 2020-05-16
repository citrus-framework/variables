<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

/**
 * klassアクセス権列挙
 */
class KlassVisibility
{
    /** @var string */
    public const TYPE_PUBLIC = 'public';
    /** @var string  */
    public const TYPE_PRIVATE = 'private';
    /** @var string  */
    public const TYPE_PROTECTED = 'protected';
}
