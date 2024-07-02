<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Hash;

/**
 * ハッシュ文字列生成インターフェース
 */
interface Hashable
{
    /**
     * 署名
     * @return string
     * @throws HashException
     */
    public function signature(): string;

    /**
     * 検証
     * @param string $signature 検証したい署名
     * @return bool
     * @throws HashException
     */
    public function verify(string $signature): bool;
}
