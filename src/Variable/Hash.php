<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

use Citrus\Intersection;
use Citrus\Variable\Hash\AlgorithmType;
use Citrus\Variable\Hash\HashException;
use Citrus\Variable\Hash\HashLogic;
use Citrus\Variable\Hash\Hmac;
use Citrus\Variable\Hash\MethodType;
use Citrus\Variable\Hash\Rsa;

/**
 * ハッシュ文字列生成処理
 */
class Hash
{
    /**
     * ロジックの取得
     * @param MethodType    $methodType    ハッシュ化メソッド
     * @param AlgorithmType $algorithmType ハッシュ化アルゴリズム
     * @return HashLogic
     * @throws HashException
     */
    public static function logic(
        MethodType $methodType = MethodType::RSA,
        AlgorithmType $algorithmType = AlgorithmType::SHA256,
    ): HashLogic {
        return Intersection::fetch($methodType->value, [
            MethodType::HMAC->value => fn () => new Hmac($algorithmType, null, null),
            MethodType::RSA->value  => fn () => new Rsa($algorithmType, null, null),
        ]);
    }

    /**
     * 署名
     * @param MethodType    $methodType    ハッシュ化メソッド
     * @param AlgorithmType $algorithmType ハッシュ化アルゴリズム
     * @param string|null   $token         ハッシュ化したい文字列
     * @param string|null   $secret        秘密鍵
     * @return string
     * @throws HashException
     */
    public static function signature(
        MethodType $methodType = MethodType::RSA,
        AlgorithmType $algorithmType = AlgorithmType::SHA256,
        string|null $token = null,
        string|null $secret = null,
    ): string {
        return Intersection::fetch($methodType->value, [
            MethodType::HMAC->value => fn () => (new Hmac($algorithmType, $token, $secret))->signature(),
            MethodType::RSA->value  => fn () => (new Rsa($algorithmType, $token, $secret))->signature(),
        ]);
    }

    /**
     * 検証
     * @param string        $signature     検証したい署名
     * @param MethodType    $methodType    ハッシュ化メソッド
     * @param AlgorithmType $algorithmType ハッシュ化アルゴリズム
     * @param string|null   $token         ハッシュ化したい文字列
     * @param string|null   $secret        秘密鍵
     * @return string
     * @throws HashException
     */
    public static function verify(
        string $signature,
        MethodType $methodType = MethodType::RSA,
        AlgorithmType $algorithmType = AlgorithmType::SHA256,
        string|null $token = null,
        string|null $secret = null,
    ): bool {
        return Intersection::fetch($methodType->value, [
            MethodType::HMAC->value => fn () => (new Hmac($algorithmType, $token, $secret))->verify($signature),
            MethodType::RSA->value  => fn () => (new Rsa($algorithmType, $token, $secret))->verify($signature),
        ]);
    }
}
