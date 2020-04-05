<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Variable;

use Citrus\Variable\Directory;
use Citrus\Variable\Strings;
use PHPUnit\Framework\TestCase;

/**
 * ディレクトリ処理のテスト
 */
class DirectoryTest extends TestCase
{
    /**
     * @test
     */
    public function 親参照が入るデレクトリパスを適切な形にする()
    {
        // 親参照が入るパス
        $source_path = '/var/www/html/public/app/src/../src/citrus-configure.php';
        // 期待するパス
        $expected_path = '/var/www/html/public/app/src/citrus-configure.php';
        // 適切な形に変換
        $suitable_path = Directory::suitablePath($source_path);
        // 検算
        $this->assertSame($expected_path, $suitable_path);


        // 親参照が入るパス、自参照
        $source_path = '/var/www/html/public/app/src/./../src/citrus-configure.php';
        // 期待するパス
        $expected_path = '/var/www/html/public/app/src/citrus-configure.php';
        // 適切な形に変換
        $suitable_path = Directory::suitablePath($source_path);
        // 検算
        $this->assertSame($expected_path, $suitable_path);


        // 親参照が複数入るパス
        $source_path = '/var/www/html/public/app/src/../../app/src/citrus-configure.php';
        // 期待するパス
        $expected_path = '/var/www/html/public/app/src/citrus-configure.php';
        // 適切な形に変換
        $suitable_path = Directory::suitablePath($source_path);
        // 検算
        $this->assertSame($expected_path, $suitable_path);
    }



    /**
     * @test
     */
    public function pathUpperFirst_想定通り()
    {
        // 先頭スラッシュ無し
        $this->assertSame('Hoge/Fuga', Directory::pathUpperFirst('hoge/fuga'));

        // 先頭スラッシュ有り
        $this->assertSame('/Hoge/Fuga', Directory::pathUpperFirst('/hoge/fuga'));

        // 先頭以外は小文字化する
        $this->assertSame('/Hoge/Fuga', Directory::pathUpperFirst('/HOGE/FUGA'));
    }
}
