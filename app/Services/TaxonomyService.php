<?php

namespace App\Services;

use PDO;
use App\Database\DB;
use App\Support\Singleton;
use TeamTNT\TNTSearch\TNTSearch;

class TaxonomyService
{
    use Singleton;

    /**
     * TNTSearch instance.
     *
     * @var TNTSearch
     */
    private TNTSearch $tnt;

    /**
     * Config.
     * 
     * @var array
     */
    private array $config = [];

    /**
     * Constructor.
     */
    private function __construct(array $config)
    {
        $this->tnt = new TNTSearch;
        $this->tnt->loadConfig([
            'driver'    => 'mysql',
            'host'      => $config['host'],
            'database'  => $config['database'],
            'username'  => $config['username'],
            'password'  => $config['password'],
            'storage'   => $config['storage'],
            'stemmer'   => \TeamTNT\TNTSearch\Stemmer\NoStemmer::class//optional
        ]);
    }

    /**
     * Store taxonomy to the database.
     *
     * @param  string $taxonomyFilePath
     * @param  DB $pdo
     * @return void
     */
    public function storeTaxonomy($taxonomyFilePath, $db)
    {
        if ($file = fopen($taxonomyFilePath, 'r')) {

            // read file line by line
        }
    }

    /**
     * Store the taxonomy.
     *
     * @param  DB $db
     * @param  int $id
     * @param  string $category
     * @param  string $categoryAr
     * @return void
     */
    private function addTaxonomy($db, $id, $category, $categoryAr)
    {
        $pdo = $db->pool()->get();

        // insert record

        $db->pool()->put($pdo);
    }

    /**
     * Search about the taxonomy by the given query.
     *
     * @param  string $query
     * @param  DB $db
     * @return array
     */
    public function search($content, $db)
    {
        $pdo = $db->pool()->get();

        // Search query

        $db->pool()->put($pdo);

        // return $items;
    }

    /**
     * Create indexing for the data.
     *
     * @return void
     */
    public function createIndex()
    {
        // create index query
    }

    /**
     * Delete all records from taxonomy table.
     *
     * @param  DB $db
     * @return void
     */
    public function deleteTable($db)
    {
        $pdo = $db->pool()->get();

        // drop the table

        $db->pool()->put($pdo);
    }

    /**
     * Create taxonomy table.
     *
     * @param  DB $db
     * @return void
     */
    public function createTable($db)
    {
        $pdo = $db->pool()->get();

        // create table

        $db->pool()->put($pdo);
    }
}
