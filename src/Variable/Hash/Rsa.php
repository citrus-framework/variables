<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Hash;

use Citrus\Intersection;

/**
 * ハッシュ文字列生成処理
 */
class Rsa extends HashMethod implements Hashable
{
    /**
     * {@inheritDoc}
     */
    #[\Override] public function signature(): string
    {
        // 事前チェック
        $this->validate();

        // アルゴリズム
        $algorithm = $this->convertOpensslAlgorithm();

        // 署名処理
        $signature = '';
        $success = openssl_sign($this->token, $signature, $this->secret, $algorithm);
        HashException::exceptionElse(
            $success,
            'OpenSSLの鍵生成に失敗しました。'
        );
        return $signature;
    }

    /**
     * {@inheritDoc}
     */
    #[\Override] public function verify(string $signature): bool
    {
        // 検証
        // 検証時の再生成でチェックが入る
        return (1 === openssl_verify($this->signature(), $signature, $this->secret, $this->convertOpensslAlgorithm()));
    }

    /**
     * {@inheritDoc}
     */
    #[\Override] protected function validate(): void
    {
        parent::validate();

        // 存在しないアルゴリズム
        HashException::exceptionIf(
            is_null($this->convertOpensslAlgorithm()),
            sprintf('利用できないアルゴリズム「%s」が設定されています。', $this->algorithmType->value)
        );
    }

    /**
     * opensslで利用できるアルゴリズムに変換
     * @return int|null
     */
    private function convertOpensslAlgorithm(): int|null
    {
        return Intersection::fetch($this->algorithmType->value, [
            AlgorithmType::SHA256->value => OPENSSL_ALGO_SHA256,
            AlgorithmType::SHA384->value => OPENSSL_ALGO_SHA384,
            AlgorithmType::SHA512->value => OPENSSL_ALGO_SHA512,
        ], true);
    }
}
