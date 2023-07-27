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
enum KlassVisibility : string
{
    /** public */
    case PUBLIC = 'public';

    /** private  */
    case PRIVATE = 'private';

    /** protected  */
    case PROTECTED = 'protected';
}
