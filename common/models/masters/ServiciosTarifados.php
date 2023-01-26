<?php

namespace common\models\masters;

use Yii;
use common\models\masters\Monedas;
use common\models\masters\Ums;
use common\helpers\h;
/**
 * This is the model class for table "servicios_tarifados".
 *
 * @property int $id
 * @property string|null $codserv
 * @property string|null $descripcion
 * @property string|null $detalle
 * @property string|null $codum
 * @property float|null $precio
 * @property string|null $codmon
 *
 * @property Moneda $codmon0
 * @property Um $codum0
 */
class ServiciosTarifados extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servicios_tarifados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detalle'], 'string'],
            [['precio'], 'number'],
            [['codserv', 'codmon'], 'string', 'max' => 5],
            [['descripcion'], 'string', 'max' => 40],
            [['codum'], 'string', 'max' => 4],
            [['codmon'], 'exist', 'skipOnError' => true, 'targetClass' => Monedas::className(), 'targetAttribute' => ['codmon' => 'codmon']],
            [['codum'], 'exist', 'skipOnError' => true, 'targetClass' => Ums::className(), 'targetAttribute' => ['codum' => 'codum']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codserv' => Yii::t('app', 'Codserv'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle' => Yii::t('app', 'Detalle'),
            'codum' => Yii::t('app', 'Codum'),
            'precio' => Yii::t('app', 'Precio'),
            'codmon' => Yii::t('app', 'Codmon'),
        ];
    }

    /**
     * Gets query for [[Codmon0]].
     *
     * @return \yii\db\ActiveQuery|MonedaQuery
     */
    public function getMoneda()
    {
        return $this->hasOne(Monedas::className(), ['codmon' => 'codmon']);
    }

    /**
     * Gets query for [[Codum0]].
     *
     * @return \yii\db\ActiveQuery|UmQuery
     */
    public function getUm()
    {
        return $this->hasOne(Ums::className(), ['codum' => 'codum']);
    }

    /**
     * {@inheritdoc}
     * @return ServiciosTarifadosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ServiciosTarifadosQuery(get_called_class());
    }
    
    
     public function valorTarifa($codmon=null){
        if(is_null($codmon))$codmon= Tipocambio::COD_MONEDA_BASE;
          if($codmon===$this->codmon){
                return $this->precio;
                yii::error('no hay cambio',__FUNCTION__);
            }else{//PUEDE SER QUE ESTE EN OTRA MONEDA
                if($cambio=h::tipoCambio($codmon)['compra']>0){
                    yii::error('okio',__FUNCTION__);
                    return $this->precio/$cambio;
                }else{
                    yii::error('no agarro nada',__FUNCTION__);
                }
                
            }
            
        
    
      }
}
