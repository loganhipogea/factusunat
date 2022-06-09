<?php
/**
 * This view is used by console/controllers/MigrateController.php.
 *
 * The following variables are available in this view:
 */
/* @var $className string the new migration class name without namespace */
/* @var $namespace string the new migration class namespace */
/* @var $table string the name table */
/* @var $fields array the fields */

echo "<?php\n";
if (!empty($namespace)) {
    echo "\nnamespace {$namespace};\n";
}
?>

use common\migrations\baseMigration;

/**
 * Handles the dropping of table `<?= $table ?>`.
<?= $this->render('_foreignTables', [
    'foreignKeys' => $foreignKeys,
]) ?>
 */
class <?= $className ?> extends baseMigration
{
    /**
     * {@inheritdoc}
     */
     
     public $myvista='{{%mivista}}';
     public function safeUp()
    {
              if($this->existsTable($this->myvista))
                $this->dropView($this->myvista);
                $comando= $this->db->createCommand();       
                $comando->createView($vista,
                    (new \yii\db\Query())
                    ->select([
                'a.id', 'a.fecha', 'a.descripcion','a.direcc_id',
                'b.os_id', 'b.proc_id','b.detos_id','b.descripcion as descridetalle','b.detalle','b.tipo',
   
                 ])
         ->from(['a'=>'{{%op_tareo}}'])->
        innerJoin('{{%op_libro}} b', 'b.tareo_id=a.id')
    
                )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    
       if($this->existsTable($this->myvista))
                $this->dropView($this->myvista);
    }
}
