<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Hash;

/**
 * ハッシュ文字列生成処理
 */
class Hmac extends HashMethod implements Hashable
{
    /**
     * {@inheritDoc}
     */
    #[\Override] public function signature(): string
    {
        // 事前チェック
        $this->validate();

        // 署名処理
        return hash_hmac($this->algorithmType->value, $this->token, $this->secret, true);
    }

    /**
     * {@inheritDoc}
     */
    #[\Override] public function verify(string $signature): bool
    {
        // 検証
        // 検証時の再生成でチェックが入る
        return hash_equals($this->signature(), $signature);
    }

    /**
     * {@inheritDoc}
     */
    #[\Override] protected function validate(): void
    {
        parent::validate();

        // 存在しないアルゴリズム
        $algorithm = $this->algorithmType->value;
        HashException::exceptionElse(
            in_array($algorithm, hash_hmac_algos(), true),
            sprintf('利用できないアルゴリズム「%s」が設定されています。', $algorithm)
        );
    }
}
