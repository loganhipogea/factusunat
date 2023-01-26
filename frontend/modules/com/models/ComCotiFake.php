<?php

namespace frontend\modules\com\models;
use common\models\masters\Clipro;
use common\models\masters\Trabajadores;
use common\models\masters\Centros;
use Yii;

/**
 * This is the model class for table "{{%com_cotizaciones}}".
 *
 * @property int $id
 * @property string|null $numero
 * @property string|null $serie
 * @property string|null $codsoc
 * @property string|null $codcen
 * @property string|null $codcli
 * @property string|null $codcli1
 * @property string|null $estado
 * @property string|null $descripcion
 * @property string|null $detalle_interno
 * @property string|null $detalle_externo
 * @property string|null $femision
 * @property int|null $validez
 * @property string|null $codtra
 * @property int|null $n_direcc
 * @property string|null $codmon
 * @property float|null $monto
 * @property float|null $igv
 * @property float|null $montoneto
 * @property float|null $montocargo
 * @property float|null $version
 * @property string|null $filtro
 *
 * @property Centros $codcen0
 * @property Clipro $codcli0
 * @property Clipro $codcli10
 * @property Trabajadores $codtra0
 * @property ComCargoscoti[] $comCargoscotis
 * @property ComContactocoti[] $comContactocotis
 * @property ComCoticeco[] $comCoticecos
 * @property ComDetcoti[] $comDetcotis
 */
class ComCotiFake extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%com_cotizaciones}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detalle_interno', 'detalle_externo'], 'string'],
            [['validez', 'n_direcc'], 'integer'],
            [['monto', 'igv', 'montoneto', 'montocargo', 'version'], 'number'],
            [['numero', 'codcli', 'codcli1', 'femision'], 'string', 'max' => 10],
            [['serie', 'codmon'], 'string', 'max' => 3],
            [['codsoc', 'filtro'], 'string', 'max' => 1],
            [['codcen'], 'string', 'max' => 5],
            [['estado'], 'string', 'max' => 2],
            [['descripcion'], 'string', 'max' => 40],
            [['codtra'], 'string', 'max' => 6],
            [['codcen'], 'exist', 'skipOnError' => true, 'targetClass' => Centros::className(), 'targetAttribute' => ['codcen' => 'codcen']],
            [['codcli1'], 'exist', 'skipOnError' => true, 'targetClass' => Clipro::className(), 'targetAttribute' => ['codcli1' => 'codpro']],
            [['codcli'], 'exist', 'skipOnError' => true, 'targetClass' => Clipro::className(), 'targetAttribute' => ['codcli' => 'codpro']],
            [['codtra'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajadores::className(), 'targetAttribute' => ['codtra' => 'codigotra']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'numero' => Yii::t('app', 'Numero'),
            'serie' => Yii::t('app', 'Serie'),
            'codsoc' => Yii::t('app', 'Codsoc'),
            'codcen' => Yii::t('app', 'Codcen'),
            'codcli' => Yii::t('app', 'Codcli'),
            'codcli1' => Yii::t('app', 'Codcli1'),
            'estado' => Yii::t('app', 'Estado'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle_interno' => Yii::t('app', 'Detalle Interno'),
            'detalle_externo' => Yii::t('app', 'Detalle Externo'),
            'femision' => Yii::t('app', 'Femision'),
            'validez' => Yii::t('app', 'Validez'),
            'codtra' => Yii::t('app', 'Codtra'),
            'n_direcc' => Yii::t('app', 'N Direcc'),
            'codmon' => Yii::t('app', 'Codmon'),
            'monto' => Yii::t('app', 'Monto'),
            'igv' => Yii::t('app', 'Igv'),
            'montoneto' => Yii::t('app', 'Montoneto'),
            'montocargo' => Yii::t('app', 'Montocargo'),
            'version' => Yii::t('app', 'Version'),
            'filtro' => Yii::t('app', 'Filtro'),
        ];
    }

    /**
     * Gets query for [[Codcen0]].
     *
     * @return \yii\db\ActiveQuery|CentrosQuery
     */
    public function getCodcen0()
    {
        return $this->hasOne(Centros::className(), ['codcen' => 'codcen']);
    }

    /**
     * Gets query for [[Codcli0]].
     *
     * @return \yii\db\ActiveQuery|CliproQuery
     */
    public function getCodcli0()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codcli']);
    }

    /**
     * Gets query for [[Codcli10]].
     *
     * @return \yii\db\ActiveQuery|CliproQuery
     */
    public function getCodcli10()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codcli1']);
    }

    /**
     * Gets query for [[Codtra0]].
     *
     * @return \yii\db\ActiveQuery|TrabajadoresQuery
     */
    public function getCodtra0()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }

    /**
     * Gets query for [[ComCargoscotis]].
     *
     * @return \yii\db\ActiveQuery|ComCargoscotiQuery
     */
    public function getComCargoscotis()
    {
        return $this->hasMany(ComCargoscoti::className(), ['coti_id' => 'id']);
    }

    /**
     * Gets query for [[ComContactocotis]].
     *
     * @return \yii\db\ActiveQuery|ComContactocotiQuery
     */
    public function getComContactocotis()
    {
        return $this->hasMany(ComContactocoti::className(), ['coti_id' => 'id']);
    }

    /**
     * Gets query for [[ComCoticecos]].
     *
     * @return \yii\db\ActiveQuery|ComCoticecoQuery
     */
    public function getComCoticecos()
    {
        return $this->hasMany(ComCoticeco::className(), ['coti_id' => 'id']);
    }

    /**
     * Gets query for [[ComDetcotis]].
     *
     * @return \yii\db\ActiveQuery|ComDetcotiQuery
     */
    public function getComDetcotis()
    {
        return $this->hasMany(ComDetcoti::className(), ['coti_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ComCotiFakeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComCotiFakeQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        $this->filtro='0';
        return parent::beforeSave($insert);
    }
}
