<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Hash;

/**
 * ハッシュ文字列生成抽象
 */
abstract class HashLogic
{
    /**
     * @param AlgorithmType $algorithmType  ハッシュ化アルゴリズム
     * @param string|null   $token          ハッシュ化したい文字列
     * @param string|null   $secret         秘密鍵
     */
    public function __construct(
        public readonly AlgorithmType $algorithmType = AlgorithmType::SHA256,
        public string|null $token = null,
        public string|null $secret = null,
    ) {
    }

    /**
     * 署名
     * @return string
     * @throws HashException
     */
    abstract public function signature(): string;

    /**
     * 検証
     * @param string $signature 検証したい署名
     * @return bool
     * @throws HashException
     */
    abstract public function verify(string $signature): bool;


    /**
     * 事前チェックを行い、不正な場合は例外を投げる
     * @return void
     * @throws HashException
     */
    protected function validate(): void
    {
        // トークンがnull
        HashException::exceptionIf(
            is_null($this->token),
            'ハッシュ化したいトークンが設定されていません。'
        );
        // 秘密鍵がnull
        HashException::exceptionIf(
            is_null($this->token),
            'ハッシュに利用したい秘密鍵が設定されていません。'
        );
    }
}
