<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Hash;

/**
 * ハッシュ化アルゴリズタイプ
 */
enum AlgorithmType : string
{
    /** SHA256 */
    case SHA256 = 'sha256';

    /** SHA384 */
    case SHA384 = 'sha384';

    /** SHA256 */
    case SHA512 = 'sha512';
}
