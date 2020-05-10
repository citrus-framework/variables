<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

/**
 * klassフォーマット
 */
class KlassFormat
{
    /** @var string インデントタブ */
    public const INDENT_TAB = "\t";

    /** @var string インデントスペース2 */
    public const INDENT_SPACE2 = '  ';

    /** @var string インデントスペース4 */
    public const INDENT_SPACE4 = '    ';

    /** @var string インデントスペース8 */
    public const INDENT_SPACE8 = '        ';

    /** @var string インデント */
    public $indent;



    /**
     * constructor.
     * @param string $indent インデント
     */
    public function __construct(string $indent = self::INDENT_SPACE4)
    {
        $this->indent = $indent;
    }
}
