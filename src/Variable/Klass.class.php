<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

use Citrus\Variable\Klass\Formatable;
use Citrus\Variable\Klass\KlassFileComment;
use Citrus\Variable\Klass\KlassFormat;
use Citrus\Variable\Klass\KlassMethod;
use Citrus\Variable\Klass\KlassProperty;

/**
 * クラスジェネレータ
 */
class Klass
{
    use Formatable;

    /** @var string クラス名 */
    private $name;

    /** @var string|null クラスコメント */
    private $class_comment;

    /** @var string|null ネームスペース */
    private $namespace;

    /** @var string|null 継承親クラス名 */
    private $extends_name;

    /** @var string[] インターフェース名 */
    private $implements_names = [];

    /** @var KlassFileComment ファイルコメント */
    private $fileComment;

    /** @var KlassProperty[] プロパティ配列 */
    private $properties = [];

    /** @var KlassMethod[] メソッド配列 */
    private $methods = [];

    /** @var bool 厳密な型検査 */
    private $is_strict_types = true;

    /** @var string クラスコメントのフォーマット */
    private $class_comment_format = <<<'FORMAT'
/**
 * {{CLASS_COMMENT}}
 */
FORMAT;

    /** @var string クラス出力用フォーマット、最終行には空行を入れておく */
    private $class_format = <<<'FORMAT'
<?php
{{WITH_STRICT_TYPES}}
{{FILE_COMMENT}}
{{WITH_NAMESPACE}}
{{CLASS_COMMENT}}
class {{NAME}}{{WITH_EXTENDS}}{{WITH_IMPLEMENTS}}
{
{{EACH_PROPERTIES}}
{{EACH_METHODS}}
}

FORMAT;




    /**
     * constructor.
     *
     * @param string $name クラス名
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }



    /**
     * ネームスペースの設定
     *
     * @param string $namespace ネームスペース
     * @return $this
     */
    public function setNamespace(string $namespace): self
    {
        $this->namespace = $namespace;
        return $this;
    }



    /**
     * クラスコメントの追加
     *
     * @param string $class_comment クラスコメント
     * @return $this
     */
    public function setClassComment(string $class_comment): self
    {
        $this->class_comment = $class_comment;
        return $this;
    }



    /**
     * 継承親クラスの設定
     *
     * @param string $extends_name 継承親クラス
     * @return $this
     */
    public function setExtends(string $extends_name): self
    {
        $this->extends_name = $extends_name;
        return $this;
    }



    /**
     * インターフェースクラスの設定
     *
     * @param string $implements_name インターフェースクラス
     * @return $this
     */
    public function addImplementsName(string $implements_name): self
    {
        $this->implements_names[] = $implements_name;
        return $this;
    }



    /**
     * ファイルコメントの追加
     *
     * @param KlassFileComment $fileComment ファイルコメント
     * @return $this
     */
    public function setFileComment(KlassFileComment $fileComment): self
    {
        $this->fileComment = $fileComment;
        return $this;
    }



    /**
     * プロパティの追加
     *
     * @param KlassProperty $property
     * @return $this
     */
    public function addProperty(KlassProperty $property): self
    {
        $this->properties[] = $property;
        return $this;
    }



    /**
     * メソッドの追加
     *
     * @param KlassMethod $method
     * @return $this
     */
    public function addMethod(KlassMethod $method): self
    {
        $this->methods[] = $method;
        return $this;
    }



    /**
     * 厳密な型検査の設定
     *
     * @param bool $is_strict_types true:厳密な型検査
     * @return $this
     */
    public function setStrictTypes(bool $is_strict_types): self
    {
        $this->is_strict_types = $is_strict_types;
        return $this;
    }



    /**
     * 文字列化
     *
     * @return string
     */
    public function toString(): string
    {
        // フォーマット
        $format = new KlassFormat();
        // 厳密な型検査
        $with_strict_types = '';
        if (true === $this->is_strict_types)
        {
            $with_strict_types = PHP_EOL . 'declare(strict_types=1);';
        }
        // ファイルコメント
        $file_comment = (false === is_null($this->fileComment) ? PHP_EOL . $this->fileComment->toCommentString() : '');
        // ネームスペース
        $with_namespace = (false === is_null($this->namespace) ? PHP_EOL . sprintf('namespace %s;', $this->namespace) : '');
        // 継承
        $with_extends = '';
        if (false === is_null($this->extends_name))
        {
            $with_extends = sprintf(' extends %s', $this->extends_name);
        }
        // 実装
        $with_implements = '';
        if (0 < count($this->implements_names))
        {
            $with_implements = sprintf(' implements %s', implode(', ', $this->implements_names));
        }
        // プロパティ
        $each_properties = '';
        foreach ($this->properties as $property)
        {
            $property->setFormat($this->callFormat());
            $each_properties .= $format->blankAroundProperty($property, $this->properties);
            $each_properties .= $property->toString();
        }
        // メソッド
        $each_methods = '';
        foreach ($this->methods as $method)
        {
            $each_methods .= $format->blankAroundMethod($method, $this->methods);
            $method->setFormat($format);
            $each_methods .= ($method->toCommentString() . PHP_EOL . $method->toMethodString());
        }

        // プロパティとメソッド間の空行
        $each_methods = $format->blankBetweenBlock($this->properties, $this->methods) . $each_methods;

        // 置換パターン
        $replace_patterns = [
            '{{WITH_STRICT_TYPES}}' => $with_strict_types,
            '{{FILE_COMMENT}}' => $file_comment,
            '{{WITH_NAMESPACE}}' => $with_namespace,
            '{{CLASS_COMMENT}}' => $this->toClassCommentString(),
            '{{NAME}}' => $this->name,
            '{{WITH_EXTENDS}}' => $with_extends,
            '{{WITH_IMPLEMENTS}}' => $with_implements,
            '{{EACH_PROPERTIES}}' => $each_properties,
            '{{EACH_METHODS}}' => $each_methods,
        ];

        // 置換して返却
        return Strings::patternReplace($replace_patterns, $this->class_format);
    }



    /**
     * クラスコメントの出力
     *
     * @return string クラスコメント文字列
     */
    public function toClassCommentString()
    {
        // 存在しなければ空文字
        if (true === is_null($this->class_comment))
        {
            return '';
        }

        // 置換パターン
        $replace_patterns = [
            '{{CLASS_COMMENT}}' => $this->class_comment,
        ];

        // 置換して返却
        return PHP_EOL . Strings::patternReplace($replace_patterns, $this->class_comment_format);
    }
}
