<?php

declare(strict_types=1);

/**
 * generated Citrus Migration file at 2018-02-10 04:51:29
 */

namespace Test\Sample;

/**
 * Migrations
 */
class Citrus_20180210045129_CreateTableUsers extends \Citrus\Migration\Item
{
    use \Citrus\Variable\Instance;
    use \Citrus\Variable\Singleton;



    /** @var string テーブル|ビュー名 */
    public $object_name = 'users';

    /** @var string スキーマ名 */
    public $schema = 'citrus';



    /**
     * up query
     *
     * @return string SQL文字列
     */
    public function up(): string
    {
        return <<<SQL
SQL;
    }



    /**
     * down query
     *
     * @return string SQL文字列
     */
    public function down(): string
    {
        return <<<SQL
SQL;
    }
}
