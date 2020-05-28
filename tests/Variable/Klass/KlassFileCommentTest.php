<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable\Klass;

use Citrus\Variable\Klass\KlassFileComment;
use PHPUnit\Framework\TestCase;

/**
 * klassファイルコメントのテスト
 */
class KlassFileCommentTest extends TestCase
{
    /**
     * @test
     */
    public function toCommentString_想定通り()
    {
        // パターン1
        $fileComment = KlassFileComment::getInstance();
        $expected = <<<'EXPECTED'
EXPECTED;
        $this->assertSame($expected, $fileComment->toCommentString());

        // パターン2
        $fileComment = KlassFileComment::getInstance()
            ->addComment(KlassFileComment::COPYRIGHT, 'Copyright 2020, CitrusVariables. All Rights Reserved.')
            ->addComment(KlassFileComment::AUTHOR, 'take64 <take64@citrus.tk>')
            ->addComment(KlassFileComment::LICENSE, 'http://www.citrus.tk/')
            ->addComment(KlassFileComment::SEE, 'https://github.com/citrus-framework')
            ->addComment(KlassFileComment::SEE, 'https://github.com/take64');
        $expected = <<<'EXPECTED'
/**
 * @copyright Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author take64 <take64@citrus.tk>
 * @license http://www.citrus.tk/
 * @see https://github.com/citrus-framework
 * @see https://github.com/take64
 */
EXPECTED;
        $this->assertSame($expected, $fileComment->toCommentString());

        // パターン3
        $fileComment = KlassFileComment::getInstance()
            ->addComment(KlassFileComment::ROW, 'generated Citrus Migration file at 2018-02-10 04:51:29');
        $expected = <<<'EXPECTED'
/**
 * generated Citrus Migration file at 2018-02-10 04:51:29
 */
EXPECTED;
        $this->assertSame($expected, $fileComment->toCommentString());

        // パターン4
        $fileComment = KlassFileComment::getInstance()
            ->addComment(KlassFileComment::ROW, 'generated Citrus Migration file at 2018-02-10 04:51:29')
            ->addComment(KlassFileComment::COPYRIGHT, 'Copyright 2020, CitrusVariables. All Rights Reserved.')
            ->addComment(KlassFileComment::AUTHOR, 'take64 <take64@citrus.tk>')
            ->addComment(KlassFileComment::LICENSE, 'http://www.citrus.tk/')
            ->addComment(KlassFileComment::SEE, 'https://github.com/citrus-framework')
            ->addComment(KlassFileComment::SEE, 'https://github.com/take64');
        $expected = <<<'EXPECTED'
/**
 * generated Citrus Migration file at 2018-02-10 04:51:29
 *
 * @copyright Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author take64 <take64@citrus.tk>
 * @license http://www.citrus.tk/
 * @see https://github.com/citrus-framework
 * @see https://github.com/take64
 */
EXPECTED;
        $this->assertSame($expected, $fileComment->toCommentString());
    }
}
