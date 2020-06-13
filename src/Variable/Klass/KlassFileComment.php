<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

use Citrus\Variable\Instance;
use Citrus\Variable\Strings;

/**
 * klassファイルコメント
 */
class KlassFileComment
{
    use Instance;

    /** @var string ファイル自体のコメント */
    public const RAW = 'raw';

    /** @var string コピーライト */
    public const COPYRIGHT = 'copyright';

    /** @var string 著作者 */
    public const AUTHOR = 'author';

    /** @var string ライセンス */
    public const LICENSE = 'license';

    /** @var string 引用 */
    public const SEE = 'see';

    /** @var string TYPEスタック用のキー */
    private const STACK_KEY_TYPE = 'type';

    /** @var string CONTEXTスタック用のキー */
    private const STACK_KEY_CONTEXT = 'context';

    /** @var string[] コメント配列[TYPE => CONTEXT] */
    private $comments = [];

    /** @var string コメントフォーマット文字列 */
    private $comment_format = <<<'FORMAT'
/**
{{EACH_COMMENTS}}
 */
FORMAT;

    /** @var string コメント一つ分のフォーマット文字列 */
    private $comment_one_format = <<<'FORMAT'
 * @{{TYPE}} {{CONTEXT}}
FORMAT;

    /** @var string コメント平文のフォーマット文字列 */
    private $comment_row_format = <<<'FORMAT'
 * {{CONTEXT}}
FORMAT;

    /** @var string コメントスペースフォーマット文字列 */
    private $comment_space_format = <<<'FORMAT'
 *
FORMAT;



    /**
     * コメント追加
     *
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
     *
     * @return string
     */
    public function toCommentString(): string
    {
        // コメントが1件もなければ空文字を返却
        if (0 === count($this->comments))
        {
            return '';
        }

        // コメントスペースが必要かどうか
        $is_need_space = $this->isNeedSpace();

        // コメントをスタックしていく
        $comment_contexts = [];
        foreach ($this->comments as $comment)
        {
            // 配列分解
            $type = $comment[self::STACK_KEY_TYPE];
            $context = $comment[self::STACK_KEY_CONTEXT];
            // コメントの分類
            $is_row = (self::RAW === $type);
            // フォーマット
            $comment_contexts[] = Strings::patternReplace([
                '{{TYPE}}' => $type,
                '{{CONTEXT}}' => $context,
            ], (true === $is_row ? $this->comment_row_format : $this->comment_one_format));
            // コメントスペースが必要でタイプが平文の場合はスペースを入れておく
            if (true === $is_need_space and true === $is_row)
            {
                $comment_contexts[] = $this->comment_space_format;
            }
        }

        return str_replace('{{EACH_COMMENTS}}', implode(PHP_EOL, $comment_contexts), $this->comment_format);
    }



    /**
     * 平文コメントを生成して取得
     *
     * @param string $comment
     * @return static
     */
    public static function newRaw(string $comment): self
    {
        return (new self())->addComment(KlassFileComment::RAW, $comment);
    }



    /**
     * 平文コメントと＠コメントの間にスペースが必要かどうか
     *
     * @return bool true:スペースが必要
     */
    private function isNeedSpace(): bool
    {
        $is_need_space = false;
        $is_row = false;
        $is_other = false;
        foreach ($this->comments as $comment)
        {
            $type = $comment[self::STACK_KEY_TYPE];
            // 平文コメントがあるか
            if (false === $is_row)
            {
                $is_row = (self::RAW === $type);
            }
            // 平文以外のコメントがあるか
            if (false === $is_other)
            {
                $is_other = in_array($type, [
                    self::COPYRIGHT,
                    self::AUTHOR,
                    self::LICENSE,
                    self::SEE,
                ], true);
            }
            // 両方あった時点で処理を終わる
            if (true === $is_row and true === $is_other)
            {
                $is_need_space = true;
                break;
            }
        }

        return $is_need_space;
    }
}
