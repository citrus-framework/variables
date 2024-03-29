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
use Citrus\Variable\Klass\KlassMethod;
use Citrus\Variable\Klass\KlassProperty;
use Citrus\Variable\Klass\KlassTrait;

/**
 * クラスジェネレータ
 */
class Klass
{
    use Formatable;

    /** @var string クラス名 */
    private string $name;

    /** @var string|null クラスコメント */
    private string|null $class_comment;

    /** @var string|null ネームスペース */
    private string|null $namespace;

    /** @var string|null 継承親クラス名 */
    private string|null $extends_name;

    /** @var string[] インターフェース名 */
    private array $implements_names = [];

    /** @var KlassFileComment|null ファイルコメント */
    private KlassFileComment|null $fileComment;

    /** @var KlassTrait[] トレイト配列 */
    private array $traits = [];

    /** @var KlassProperty[] プロパティ配列 */
    private array $properties = [];

    /** @var KlassMethod[] メソッド配列 */
    private array $methods = [];

    /** @var bool 厳密な型検査 */
    private bool $is_strict_types = true;

    /** @var string クラスコメントのフォーマット */
    private string $class_comment_format = <<<'FORMAT'
/**
 * {{CLASS_COMMENT}}
 */
FORMAT;

    /** @var string クラス出力用フォーマット、最終行には空行を入れておく */
    private string $class_format = <<<'FORMAT'
<?php
{{WITH_STRICT_TYPES}}
{{FILE_COMMENT}}
{{WITH_NAMESPACE}}
{{CLASS_COMMENT}}
class {{NAME}}{{WITH_EXTENDS}}{{WITH_IMPLEMENTS}}
{
{{EACH_TRAITS}}{{EACH_PROPERTIES}}{{EACH_METHODS}}
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
     * トレイトの追加
     *
     * @param KlassTrait $trait
     * @return $this
     */
    public function addTrait(KlassTrait $trait): self
    {
        $this->traits[] = $trait;
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
        $format = $this->callFormat();
        // 厳密な型検査
        $with_strict_types = (true === $this->is_strict_types)
            ? PHP_EOL . 'declare(strict_types=1);'
            : '';
        // ファイルコメント
        $file_comment = (false === is_null($this->fileComment))
            ? PHP_EOL . $this->fileComment->toCommentString()
            : '';
        // ネームスペース
        $with_namespace = (false === is_null($this->namespace))
            ? PHP_EOL . sprintf('namespace %s;', $this->namespace)
            : '';
        // 継承
        $with_extends = (false === is_null($this->extends_name))
            ? sprintf(' extends %s', $this->extends_name)
            : '';
        // 実装
        $with_implements = (0 < count($this->implements_names))
            ? sprintf(' implements %s', implode(', ', $this->implements_names))
            : '';
        // トレイト
        $each_traits = KlassTrait::eachToString($this->traits, $format);
        // プロパティ
        $each_properties = KlassProperty::eachToString($this->properties, $format);
        // メソッド
        $each_methods = KlassMethod::eachToString($this->methods, $format);
        // トレイトとプロパティ間の空行
        $each_properties = $format->blankBetweenBlock($this->traits, $this->properties) . $each_properties;
        // プロパティとメソッド間の空行
        $each_methods = $format->blankBetweenBlock($this->properties, $this->methods) . $each_methods;

        // 置換パターン
        $replace_patterns = [
            '{{WITH_STRICT_TYPES}}' => $with_strict_types,
            '{{FILE_COMMENT}}'      => $file_comment,
            '{{WITH_NAMESPACE}}'    => $with_namespace,
            '{{CLASS_COMMENT}}'     => $this->toClassCommentString(),
            '{{NAME}}'              => $this->name,
            '{{WITH_EXTENDS}}'      => $with_extends,
            '{{WITH_IMPLEMENTS}}'   => $with_implements,
            '{{EACH_TRAITS}}'       => $each_traits,
            '{{EACH_PROPERTIES}}'   => $each_properties,
            '{{EACH_METHODS}}'      => $each_methods,
        ];
        // 置換して返却
        return Strings::patternReplace($replace_patterns, $this->class_format);
    }

    /**
     * クラスコメントの出力
     *
     * @return string クラスコメント文字列
     */
    public function toClassCommentString(): string
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
