<?php

namespace frontend\modules\prd\models;
use common\helpers\h;
use common\models\masters\Maestrocompo;
use Yii;

/**
 
 */
class PrdOp extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    
    public $dateOrTimeFields=[
        'finicio'=>self::_FDATE, 
        'finiciop'=>self::_FDATE, 
        'ftermino'=>self::_FDATE, 
        'fterminop'=>self::_FDATE, 
        'fcrea'=>self::_FDATETIME, 
    ];
    
    
    public static function tableName()
    {
        return '{{%prd_op}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'cant','numero','descripcion','codart'], 'required'],
            [['parent_id', 'avance'], 'integer'],
            [['textodetalle', 'textocomercial'], 'string'],
            [['cant'], 'number'],
            [['numero'], 'string', 'max' => 12],
            [['codart'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 80],
            [['username'], 'string', 'max' => 20],
            [['finicio', 'finiciop', 'ftermino', 'fterminop'], 'string', 'max' => 10],
            [['fcrea'], 'string', 'max' => 19],
            [['tipo', 'codestado'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'numero' => Yii::t('app', 'Numero'),
            'codart' => Yii::t('app', 'Producto'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'textodetalle' => Yii::t('app', 'Textodetalle'),
            'textocomercial' => Yii::t('app', 'Textocomercial'),
            'cant' => Yii::t('app', 'Cant'),
            'username' => Yii::t('app', 'Username'),
            'finicio' => Yii::t('app', 'F. In'),
            'finiciop' => Yii::t('app', 'F In Pr'),
            'ftermino' => Yii::t('app', 'F termino'),
            'fterminop' => Yii::t('app', 'F termino p'),
            'fcrea' => Yii::t('app', 'Fcrea'),
            'avance' => Yii::t('app', 'Avance'),
            'tipo' => Yii::t('app', 'Tipo'),
            'codestado' => Yii::t('app', 'Codestado'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PrdOpQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PrdOpQuery(get_called_class());
    }
    
    public function getMaterial()
    {
        return $this->hasOne(Maestrocompo::class, ['codart' => 'codart']);
    }
    
    public function beforeSave($insert) {
        if($insert){
            $this->fcrea=$this->currentDateInFormat(true);
            $this->username=h::userName();
        }
        return parent::beforeSave($insert);
    }
}
