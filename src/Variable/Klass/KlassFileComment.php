<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

use Citrus\Variable\Instance;

/**
 * klassファイルコメント
 */
class KlassFileComment
{
    use Instance;

    /** ファイル自体のコメント */
    public const string RAW = 'raw';

    /** コピーライト */
    public const string COPYRIGHT = 'copyright';

    /** 著作者 */
    public const string AUTHOR = 'author';

    /** ライセンス */
    public const string LICENSE = 'license';

    /** 引用 */
    public const string SEE = 'see';

    /** TYPEスタック用のキー */
    private const string STACK_KEY_TYPE = 'type';

    /** CONTEXTスタック用のキー */
    private const string STACK_KEY_CONTEXT = 'context';

    /** @var array<string, array<string, string>> コメント配列[TYPE => CONTEXT] */
    private array $comments = [];

    /** @var string コメントフォーマット文字列 */
    private string $comment_format = <<<'FORMAT'
/**
{{EACH_COMMENTS}}
 */
FORMAT;

    /**
     * コメント追加
     * @param string $type    コメントタイプ
     * @param string $context コンテキスト
     * @return self
     */
    public function addComment(string $type, string $context): self
    {
        $this->comments[] = [
            self::STACK_KEY_TYPE => $type,
            self::STACK_KEY_CONTEXT => $context,
        ];
        return $this;
    }

    /**
     * コメント文字列の返却
     * @return string
     */
    public function toCommentString(): string
    {
        // コメントが1件もなければ空文字を返却
        if (count($this->comments) === 0)
        {
            return '';
        }

        // コメントスペースが必要かどうか
        $is_need_space = $this->isNeedSpace();

        // コメントをスタックしていく
        $comment_contexts = [];
        foreach ($this->comments as $comment)
        {
            $lines = KlassFileCommentLine::toLines(
                $comment[self::STACK_KEY_TYPE],
                $comment[self::STACK_KEY_CONTEXT],
                $is_need_space
            );
            $comment_contexts = array_merge($comment_contexts, $lines);
        }

        return str_replace('{{EACH_COMMENTS}}', implode(PHP_EOL, $comment_contexts), $this->comment_format);
    }

    /**
     * 平文コメントを生成して取得
     * @param string $comment
     * @return static
     */
    public static function newRaw(string $comment): self
    {
        return (new static())->addComment(KlassFileComment::RAW, $comment);
    }

    /**
     * 平文コメントと＠コメントの間にスペースが必要かどうか
     * @return bool true:スペースが必要
     */
    private function isNeedSpace(): bool
    {
        $types = array_column($this->comments, self::STACK_KEY_TYPE);
        // 平文コメントがあるか
        $is_row = in_array(self::RAW, $types, true);
        // 平文以外のコメントがあるか
        $is_other = (count(array_intersect([
            self::COPYRIGHT,
            self::AUTHOR,
            self::LICENSE,
            self::SEE,
        ], $types)) > 0);

        // 両方あればスペースが必要
        return ($is_row === true and $is_other === true);
    }
}
