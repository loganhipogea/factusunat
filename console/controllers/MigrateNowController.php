<?php
namespace console\controllers;
use Yii;
use yii\console\controllers\MigrateController;
/**
 * CliproController implements the CRUD actions for Clipro model.
 */
class MigrateNowController extends MigrateController
{
   public $templateFile = '@yii/views/migration.php';
    /**
     * @var array a set of template paths for generating migration code automatically.
     *
     * The key is the template type, the value is a path or the alias. Supported types are:
     * - `create_table`: table creating template
     * - `drop_table`: table dropping template
     * - `add_column`: adding new column template
     * - `drop_column`: dropping column template
     * - `create_junction`: create junction template
     *
     * @since 2.0.7
     */
    public $generatorTemplateFiles = [
        //'create_table' => '@common/views/migrations',
        'create_table' => '@common/views/migrations/createTableMigration.php',
        'drop_table' => '@common/views/migrations/dropTableMigration.php',
        'add_column' => '@common/views/migrations/addColumnMigration.php',
        'drop_column' => '@common/views/migrations/dropColumnMigration.php',
        'create_junction' => '@common/views/migratiodtns/createViewMigration.php',
         //'create_menu' => '@common/views/createTableMigration.php',
    ];
            
}
 