<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "{{%mat_vw_req}}".
 *
 * @property int $id
 * @property string|null $codtra
 * @property string $numero
 * @property string|null $fechaprog
 * @property string|null $fechasol
 * @property string|null $descripcion
 * @property string|null $tipo
 * @property int|null $req_id
 * @property string|null $codart
 * @property string|null $descridetalle
 * @property float|null $cant
 * @property string|null $um
 * @property string|null $imptacion
 * @property string|null $tipim
 * @property string|null $item
 * @property int|null $proc_id
 * @property int|null $os_id
 * @property int|null $detos_id
 * @property string|null $fprog
 * @property string|null $ap
 * @property string|null $am
 * @property string|null $nombres
 * @property string|null $despro
 */
class MatVwReqServ extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_vw_req}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'req_id', 'proc_id', 'os_id', 'detos_id'], 'integer'],
            [['numero'], 'required'],
            [['cant'], 'number'],
            [['codtra'], 'string', 'max' => 6],
            [['numero', 'fechaprog', 'fechasol', 'fprog'], 'string', 'max' => 10],
            [['descripcion', 'descridetalle', 'ap', 'am', 'nombres'], 'string', 'max' => 40],
            [['tipo'], 'string', 'max' => 3],
            [['codart', 'imptacion'], 'string', 'max' => 14],
            [['um', 'item'], 'string', 'max' => 4],
            [['tipim'], 'string', 'max' => 1],
            [['despro'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'codtra' => Yii::t('base.names', 'Codtra'),
            'numero' => Yii::t('base.names', 'Numero'),
            'fechaprog' => Yii::t('base.names', 'Fechaprog'),
            'fechasol' => Yii::t('base.names', 'Fechasol'),
            'descripcion' => Yii::t('base.names', 'Descripcion'),
            'tipo' => Yii::t('base.names', 'Tipo'),
            'req_id' => Yii::t('base.names', 'Req ID'),
            'codart' => Yii::t('base.names', 'Codart'),
            'descridetalle' => Yii::t('base.names', 'Descripción'),
            'cant' => Yii::t('base.names', 'Cant'),
            'um' => Yii::t('base.names', 'Um'),
            'imptacion' => Yii::t('base.names', 'Imputacion'),
            'tipim' => Yii::t('base.names', 'Tipim'),
            'item' => Yii::t('base.names', 'Item'),
            'proc_id' => Yii::t('base.names', 'Proc ID'),
            'os_id' => Yii::t('base.names', 'Os ID'),
            'detos_id' => Yii::t('base.names', 'Op.'),
            'fprog' => Yii::t('base.names', 'Fprog'),
            'ap' => Yii::t('base.names', 'Ap'),
            'am' => Yii::t('base.names', 'Am'),
            'nombres' => Yii::t('base.names', 'Nombres'),
            'despro' => Yii::t('base.names', 'Proveedor'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatVwReqServQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatVwReqServQuery(get_called_class());
    }
}
