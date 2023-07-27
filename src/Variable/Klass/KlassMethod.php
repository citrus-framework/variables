<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

use Citrus\Variable\Clonable;
use Citrus\Variable\Strings;

/**
 * klassメソッド
 */
class KlassMethod
{
    use Clonable;
    use Formatable;

    /** @var string|null コメント */
    private string|null $comment;

    /** @var KlassVisibility アクセス権 */
    private KlassVisibility $visibility;

    /** @var bool staticメソッドかどうか */
    private bool $is_static;

    /** @var string メソッド名 */
    private string $name;

    /** @var KlassArgument[] 引数リスト */
    private array $arguments = [];

    /** @var KlassReturn|null 返却値 */
    private KlassReturn|null $return = null;

    /** @var KlassException[] 例外リスト */
    private array $exceptions = [];

    /** @var string メソッド内容 */
    private string $body = '';

    /** @var string コメント内容フォーマット */
    private string $comment_format = <<<'FORMAT'
{{INDENT}}/**
{{INDENT}} * {{COMMENT}}
{{COMMENT_SEPARATE}}
{{COMMENT_PARAMS}}
{{COMMENT_RETURNS}}
{{COMMENT_THROWS}}
{{INDENT}} */
FORMAT;

    /** @var string メソッド内容フォーマット */
    private string $method_format = <<<'FORMAT'
{{INDENT}}{{VISIBILITY}}{{WITH_STATIC}} function {{NAME}}({{ARGUMENTS}}){{RETURN}}
{{INDENT}}{
{{BODY}}
{{INDENT}}}
FORMAT;



    /**
     * constructor.
     *
     * @param KlassVisibility $visibility アクセス権
     * @param string          $name       メソッド名
     * @param bool|null       $is_static  staticかどうか
     * @param string|null     $comment    コメント
     */
    public function __construct(
        KlassVisibility $visibility,
        string $name,
        bool $is_static = false,
        string|null $comment = null
    ) {
        $this->visibility = $visibility;
        $this->name = $name;
        $this->is_static = $is_static;
        $this->comment = $comment;
    }

    /**
     * 引数要素の追加
     *
     * @param KlassArgument $argument 引数
     * @return self
     */
    public function addArgument(KlassArgument $argument): self
    {
        $this->arguments[] = $argument;
        return $this;
    }

    /**
     * 返却要素の設定
     *
     * @param KlassReturn $return 返却要素
     * @return self
     */
    public function setReturn(KlassReturn $return): self
    {
        $this->return = $return;
        return $this;
    }

    /**
     * 例外要素の追加
     *
     * @param KlassException $exception 引数
     * @return self
     */
    public function addException(KlassException $exception): self
    {
        $this->exceptions[] = $exception;
        return $this;
    }

    /**
     * メソッド内容の設定
     *
     * @param string $body メソッド内容
     * @return self
     */
    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    /**
     * 名称の設定
     *
     * @param string $name 名称
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * コメントの設定
     *
     * @param string $comment コメント
     * @return self
     */
    public function setComment(string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * コメント出力
     *
     * @return string
     */
    public function toCommentString(): string
    {
        // パラメータ部分
        $comment_params = $this->buildCommentParameter();
        // 返却値部分
        $comment_returns = $this->buildCommentReturn();
        // 例外部分
        $comment_exceptions = $this->buildCommentException();

        // コメントセパレータ
        $is_comment_separate = ('' !== $comment_params or '' !== $comment_returns or '' !== $comment_exceptions);

        // 置換パターン
        $replace_patterns = [
            '{{COMMENT}}'          => $this->comment,
            '{{COMMENT_SEPARATE}}' => (true === $is_comment_separate ? '{{INDENT}} *' . PHP_EOL : ''),
            '{{COMMENT_PARAMS}}'   => $comment_params,
            '{{COMMENT_RETURNS}}'  => $comment_returns,
            '{{COMMENT_THROWS}}'   => $comment_exceptions,
            '{{INDENT}}'           => $this->callFormat()->indent,
        ];

        // 置換して返却
        $replaced = Strings::patternReplace($replace_patterns, $this->comment_format);
        return Strings::removeDuplicateEOL($replaced, true);
    }

    /**
     * メソッド内容を返却
     *
     * @return string
     */
    public function toMethodString(): string
    {
        // 置換パターン
        $replace_patterns = [
            '{{INDENT}}'      => $this->callFormat()->indent,
            '{{VISIBILITY}}'  => $this->visibility->value,
            '{{WITH_STATIC}}' => (true === $this->is_static ? ' static' : ''),
            '{{NAME}}'        => $this->name,
            '{{ARGUMENTS}}'   => KlassArgument::toArgumentsString($this->arguments, $this->callFormat()),
            '{{RETURN}}'      => (false === is_null($this->return) ? $this->return->toReturnHintString() : ''),
            '{{BODY}}'        => $this->body,
        ];

        // 置換して返却
        return Strings::patternReplace($replace_patterns, $this->method_format);
    }

    /**
     * 配列を文字列出力する
     *
     * @param KlassMethod[] $methods 処理対象配列
     * @param KlassFormat   $format  フォーマット
     * @return string
     */
    public static function eachToString(array $methods, KlassFormat $format): string
    {
        $each_methods = '';
        foreach ($methods as $method)
        {
            $method->setFormat($format);
            $each_methods .= $format->blankAroundMethod($method, $methods);
            $each_methods .= ($method->toCommentString() . PHP_EOL . $method->toMethodString());
        }
        return $each_methods;
    }

    /**
     * パラメータコメントを生成して返却
     *
     * @return string
     */
    private function buildCommentParameter(): string
    {
        $comment_params = '';
        if (0 < count($this->arguments))
        {
            $params = [];
            foreach ($this->arguments as $argument)
            {
                $argument->setFormat($this->callFormat());
                $params[] = $argument->toCommentString();
            }
            $comment_params = implode(PHP_EOL, $params);
        }
        return $comment_params;
    }

    /**
     * 返却値コメントを生成して返却
     *
     * @return string
     */
    private function buildCommentReturn(): string
    {
        $comment_returns = '';
        if (false === is_null($this->return))
        {
            $this->return->setFormat($this->callFormat());
            $comment_returns = $this->return->toReturnCommentString();
        }
        return $comment_returns;
    }

    /**
     * 例外コメントを生成して返却
     *
     * @return string
     */
    private function buildCommentException(): string
    {
        $comment_exceptions = '';
        if (0 < count($this->exceptions))
        {
            $exceptions = [];
            foreach ($this->exceptions as $exception)
            {
                $exception->setFormat($this->callFormat());
                $exceptions[] = $exception->toExceptionCommentString();
            }
            $comment_exceptions = implode(PHP_EOL, $exceptions);
        }
        return $comment_exceptions;
    }
}
