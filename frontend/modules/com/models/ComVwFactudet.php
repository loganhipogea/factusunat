<?php

namespace frontend\modules\com\models;

use Yii;

/**
 * This is the model class for table "{{%com_vw_factudet}}".
 *
 * @property int $id
 * @property string|null $codsoc
 * @property string|null $numero
 * @property string|null $femision
 * @property string|null $codum
 * @property float|null $cant
 * @property string|null $descripcion
 * @property string|null $item
 * @property string|null $codart
 * @property string|null $sunat_tipodoc
 * @property string|null $codmon
 * @property string|null $tipopago
 * @property string|null $rucpro
 * @property string|null $codcen
 * @property string|null $serie
 * @property string|null $codestado
 * @property string|null $nombre_cliente
 * @property float|null $total
 */
class ComVwFactudet extends \common\models\base\modelBase
{
    
     public $femision1=null;
    public $fvencimiento1=null;
     public $total1=null;
    public $dateorTimeFields=[
          'femision'=>self::_FDATE,
        'femision1'=>self::_FDATE,
          'fvencimiento'=>self::_FDATE,
        'fvencimiento1'=>self::_FDATE,
        
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%com_vw_factudet}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['cant', 'total'], 'number'],
            [['codsoc'], 'string', 'max' => 1],
            [['numero'], 'string', 'max' => 13],
            [['femision'], 'string', 'max' => 10],
            [['codum', 'codmon', 'serie'], 'string', 'max' => 4],
            [['descripcion'], 'string', 'max' => 200],
            [['item'], 'string', 'max' => 3],
            [['codart', 'rucpro'], 'string', 'max' => 14],
            [['sunat_tipodoc', 'tipopago', 'codestado'], 'string', 'max' => 2],
            [['codcen'], 'string', 'max' => 5],
            [['nombre_cliente'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'codsoc' => Yii::t('base.names', 'Codsoc'),
            'numero' => Yii::t('base.names', 'Numero'),
            'femision' => Yii::t('base.names', 'Femision'),
            'codum' => Yii::t('base.names', 'Codum'),
            'cant' => Yii::t('base.names', 'Cant'),
            'descripcion' => Yii::t('base.names', 'Descripcion'),
            'item' => Yii::t('base.names', 'Item'),
            'codart' => Yii::t('base.names', 'Codart'),
            'sunat_tipodoc' => Yii::t('base.names', 'Sunat Tipodoc'),
            'codmon' => Yii::t('base.names', 'Codmon'),
            'tipopago' => Yii::t('base.names', 'Tipopago'),
            'rucpro' => Yii::t('base.names', 'Rucpro'),
            'codcen' => Yii::t('base.names', 'Codcen'),
            'serie' => Yii::t('base.names', 'Serie'),
            'codestado' => Yii::t('base.names', 'Codestado'),
            'nombre_cliente' => Yii::t('base.names', 'Nombre Cliente'),
            'total' => Yii::t('base.names', 'Total'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ComVwFactudetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComVwFactudetQuery(get_called_class());
    }
}
