<?php

namespace common\models;
use common\models\masters\VwSociedades;
use common\models\masters\VwSucursales;
use Yii;

/**
 * This is the model class for table "{{%user_sociedades}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $codsoc
 * @property string $codcen
 * @property string|null $activo
 *
 * @property User $user
 */
class UserSociedades extends \common\models\base\modelBase
{
    
    private $_cache=null;
    private $dependency_cache=null;
    public $booleanFields=['activo'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_sociedades}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'codsoc', 'codcen'], 'required'],
            [['user_id'], 'integer'],
            [['codsoc'], 'string', 'max' => 3],
            [['codcen'], 'string', 'max' => 5],
            //[['activo'], 'string', 'max' => 1],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => masters\Centros::className(), 'targetAttribute' => ['codcen' => 'codcen']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'user_id' => Yii::t('base.names', 'User ID'),
            'codsoc' => Yii::t('base.names', 'Codsoc'),
            'codcen' => Yii::t('base.names', 'Codcen'),
            'activo' => Yii::t('base.names', 'Activo'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getSocio()
    {
        return $this->hasOne(VwSociedades::className(), ['codsoc' => 'codsoc']);
    }
    
    public function getCentro()
    {
        return $this->hasOne(masters\Centros::className(), ['codcen' => 'codcen']);
    }

    /**
     * {@inheritdoc}
     * @return UserSociedadesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserSociedadesQuery(get_called_class());
    }
    
    
    /*
     * Actualiza registros
     * con nuevos centros y nuevas sociedades
     */
    /*public static function refreshWithNewData(){
        
    }*/
    
    /*
     * Crea todos los registros permisos centros
     * a un usario pero no asigna el estado aun
     */
    public static function createCentersForUser($user_id){
        $existe=(new \yii\db\Query())->select(['id'])->from('{{%user}}')
              ->where(['id'=>$user_id,'status'=>User::STATUS_ACTIVE])->exists();
         if($existe){
             $rows=VwSucursales::find()->select(['codcen','codsoc'])->asArray()->all();
             //echo count($rows);die();
            foreach($rows as $row){
               $row['user_id']=$user_id;
               self::firstOrCreateStatic($row, null, $row); 
            }
             return true;
         }else{
             return false;
         }
        
    }
    /*
     * Asigna el privilegio Dios al usuario 
     */
    public static function assignGodToUser($user_id){
        $existe=(new \yii\db\Query())->select(['id'])->from('{{%user}}')
              ->where(['id'=>$user_id,'status'=>User::STATUS_ACTIVE])->exists();
         if($existe){
             self::createCentersForUser($user_id);
             self::updateAll(['activo'=>'1'],['user_id'=>$user_id]);             
            }       
    }
    
    public static function revokeAllToUser($user_id){
        $existe=(new \yii\db\Query())->select(['id'])->from('{{%user}}')
              ->where(['id'=>$user_id,'status'=>User::STATUS_ACTIVE])->exists();
         if($existe){
             self::createCentersForUser($user_id);
             self::updateAll(['activo'=>'0'],['user_id'=>$user_id]);             
            }       
    }
    
    /*
     * Asigna el privilegio de una sucursal al usuario
     * AL tener el permiso de un centro i sucursal yab tiene
     * de la sociedad respectiva
     */
    public static function assignCenterToUser($user_id,$sucursal){
        $existe=(new \yii\db\Query())->select(['id'])->from('{{%user}}')
              ->where(['id'=>$user_id,'status'=>User::STATUS_ACTIVE])->exists();
         if($existe){
             $codsoc=VwSucursales::find([
                           'codcen'=>$sucursal
                               ])->one()->codsoc;
            self::firstOrCreateStatic([
                      'user_id'=>$user_id,
                       'codsoc'=>$codsoc ,
                        'codcen'=>$sucursal,
                    ], null,
                    [
                      'user_id'=>$user_id,
                       'codsoc'=>$codsoc ,
                        'codcen'=>$sucursal,
                    ]);  
            self::updateAll([
                      'activo'=>'1',
                       
                    ], 
                    [
                      'user_id'=>$user_id,
                       'codsoc'=>$codsoc ,
                        'codcen'=>$sucursal,
                    ]); 
            }       
    }
    
    public static function revokeCenterToUser($user_id,$sucursal){
        $existe=(new \yii\db\Query())->select(['id'])->from('{{%user}}')
              ->where(['id'=>$user_id,'status'=>User::STATUS_ACTIVE])->exists();
         if($existe){
             $codsoc=VwSucursales::findOne([
                           'codcen'=>$sucursal
                               ])->one()->codsoc;
            self::updateAll([
                      'activo'=>'0',
                       
                    ], 
                    [
                      'user_id'=>$user_id,
                       'codsoc'=>$codsoc ,
                        'codcen'=>$sucursal,
                    ]);             
            }       
    }
    
   
    public static function dataFilterForUser($user_id){
        $dependency=new  \yii\caching\DbDependency([
            'sql'=>'SELECT COUNT(*) FROM {{%centros}}',
        ]);
        $result = self::getDb()->cache(function ($db) {
           return self::find()->select(['codcen','codsoc'])->where(['user_id' => $user_id,'activo'=>'1'])->all();
                
            },60*60*24*30,$dependency);
        return [
            'centers'=>array_column($result,'codcen'),
             'companies'=>array_column($result,'codsoc'),
            ];
    }
    public static function centersFilterForUser($user_id){
        
        return self::dataFilterForUser($user_id)['centers'];
    }
    public static function companiesFilterForUser($user_id){
        
        return self::dataFilterForUser($user_id)['companies'];
    }
    
}
