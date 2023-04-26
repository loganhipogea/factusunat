<?php
//namespace frontend\modules\bigitems\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
use common\models\config\Config;
use common\models\masters\Combovalores;
use common\models\masters\Centros;

/**
 * Class m190630_143815_create_table_docbotellas
 */
class m190630_143815_create_table_docbotellas extends baseMigration
{
     const NAME_TABLE='{{%bigitems_docbotellas}}';
 const NAME_TABLE_CLIPRO='{{%clipro}}';
 const NAME_TABLE_CENTROS='{{%centros}}';
 const NAME_TABLE_DIRECCIONES='{{%direcciones}}';
 const NAME_TABLE_TRABAJADORES='{{%trabajadores}}';
  const NAME_TABLE_DOCUMENTOS='{{%documentos}}';
//const NAME_TABLE_UM='{{%ums}}';
 //const NAME_TABLE_DOCUMENTOS='{{%documentos}}';
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table, [
             'id'=>$this->primaryKey(),
        'codestado' => $this->char(2)->notNull()->append($this->collateColumn()),
           'codpro' => $this->char(6)->notNull()->append($this->collateColumn()),
        'codocu' => $this->char(3)->notNull()->append($this->collateColumn()),
              'numero' => $this->char(10)->notNull()->append($this->collateColumn()),
              'codcen' => $this->string(5)->notNull()->append($this->collateColumn()),
              'descripcion' => $this->string(40)->notNull()->append($this->collateColumn()),
             'codenvio' => $this->char(2)->notNull()->append($this->collateColumn()),
             'fecdocu' => $this->char(10)->notNull()->append($this->collateColumn()),
             'fectran' => $this->char(10)->append($this->collateColumn()),
              'codtra' => $this->string(6)->append($this->collateColumn()),//7TRANSPORTITISTA
             'codven' => $this->string(6)->append($this->collateColumn()),//vendedor
            'codplaca' => $this->string(15)->append($this->collateColumn()),//placa de rodaje
           'ptopartida_id' => $this->integer(11)->notNull(),//punto partida
            'ptollegada_id' => $this->integer(11)->notNull(),//punto llegada
            'comentario'=>$this->text()->append($this->collateColumn()),
            'essalida'=>$this->char(1)->notNull()->append($this->collateColumn()),
            ],$this->collateTable());
             
                $this->addForeignKey($this->generateNameFk($table), $table,
              'codpro', static::NAME_TABLE_CLIPRO,'codpro');
                  $this->addForeignKey($this->generateNameFk($table), $table,
              'codcen', static::NAME_TABLE_CENTROS,'codcen');
                 $this->addForeignKey($this->generateNameFk($table), $table,
              'codtra', static::NAME_TABLE_TRABAJADORES,'codigotra');
                 $this->addForeignKey($this->generateNameFk($table), $table,
              'codven', static::NAME_TABLE_TRABAJADORES,'codigotra');
                 $this->addForeignKey($this->generateNameFk($table), $table,
              'ptopartida_id', static::NAME_TABLE_DIRECCIONES,'id');
                    $this->addForeignKey($this->generateNameFk($table), $table,
              'ptollegada_id', static::NAME_TABLE_DIRECCIONES,'id');
                    $this->fillEnvios();
                    $this->fillEstados();
            }
         $this->putCombo($table, 'codenvio', 'ALQUILER');
         $this->putCombo($table, 'essalida', 'INGRESO');
         $this->putCombo($table, 'codestado', 'CREADO');
 }

public function safeDown()
    {
       $table=static::NAME_TABLE;
    if($this->existsTable($table)) {
            $this->dropTable($table);
            $this->deleteEnvios();
             $this->deleteEstados();
        }
     
    }

  
    
 
}
