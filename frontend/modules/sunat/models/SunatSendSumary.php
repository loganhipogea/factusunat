<?php

namespace frontend\modules\sunat\models;

use Yii;

/**
 * This is the model class for table "{{%sunat_send_sumary}}".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $ticket Numero de ticket de respuesta de la SUNAT
 * @property string|null $codopera Tipo de operacion: EMISION DE BOLETA, ANULACION BOLETA, ANULACION FACRURA
 * @property string|null $motivo USAR SOLO EN EL CASO DE ANULACION DE UNA FACTURA O DOCUMENTO; ERROR EN RUC, ERROR EN MONTO ETC 
 * @property string|null $femision
 * @property string|null $cuando F hora de envio posteo
 * @property string|null $resultado
 * @property string|null $mensaje
 * @property int|null $caja_id Uso solo para enviar boletas del resumen diario,colocar el id de la caja diaria
 */
class SunatSendSumary extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sunat_send_sumary}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'caja_id'], 'integer'],
            [['mensaje'], 'string'],
            [['ticket'], 'string', 'max' => 100],
            [['codopera'], 'string', 'max' => 3],
            [['motivo'], 'string', 'max' => 25],
            [['femision'], 'string', 'max' => 10],
            [['cuando'], 'string', 'max' => 19],
            [['resultado'], 'string', 'max' => 1],
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
            'ticket' => Yii::t('base.names', 'Ticket'),
            'codopera' => Yii::t('base.names', 'Codopera'),
            'motivo' => Yii::t('base.names', 'Motivo'),
            'femision' => Yii::t('base.names', 'Femision'),
            'cuando' => Yii::t('base.names', 'Cuando'),
            'resultado' => Yii::t('base.names', 'Resultado'),
            'mensaje' => Yii::t('base.names', 'Mensaje'),
            'caja_id' => Yii::t('base.names', 'Caja ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return SunatSendSumaryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SunatSendSumaryQuery(get_called_class());
    }
}
