<?php

namespace frontend\modules\prd\models;
use common\behaviors\FileBehavior;
use Yii;

/**
 * This is the model class for table "{{%prd_planos_revisiones}}".
 *
 * @property int $id
 * @property int|null $plano_id
 * @property string|null $cambio descricion de la modificacion
 * @property string|null $texto descricion de la modificacion
 * @property string|null $fecha
 * @property string|null $rev CODIGO DE REVISION
 */
class PrdPlanosRevisiones extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%prd_planos_revisiones}}';
    }
   public function behaviors() {
        return [
           
            'fileBehavior' => [
                'class' => FileBehavior::className()
            ],
            'auditoriaBehavior' => [
                'class' => '\common\behaviors\AuditBehavior',
            ],
            
        ];
    }
    public $booleanFields=['final'];
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['plano_id'], 'integer'],
            [['texto'], 'string'],
            [['cambio'], 'string', 'max' => 100],
            [['fecha'], 'string', 'max' => 10],
            [['rev'], 'string', 'max' => 3],
            [['final'], 'safe'],
        ];
    }
 public function getPlano()
    {
        return $this->hasOne(PrdPlanos::className(), ['id' => 'plano_id']);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'plano_id' => Yii::t('app', 'Plano ID'),
            'cambio' => Yii::t('app', 'Cambio'),
            'texto' => Yii::t('app', 'Texto'),
            'fecha' => Yii::t('app', 'Fecha'),
            'rev' => Yii::t('app', 'Rev'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PrdPlanosRevisionesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PrdPlanosRevisionesQuery(get_called_class());
    }
    
    private function iAmLastRevision(){
        if(is_null($rev=$this->plano->maxRevision())){
            return true;
        }else{
            return $rev->id==$this->id;
        }
    }
    
    public function setFinal(){
        if(!$this->hasAttachments()){
            $this->addError('final',yii::t('base.errors','Esta revisión no tiene planos adjuntos'));
            return false;
        }
        
        if(!is_null($rev=$this->plano-getRevisiones()->andWhere(['<>','id',$this->id])->andWhere(['final'=>'1'])->one())){
            $this->addError('final',yii::t('base.errors','Ya existe la revisión {rev}-{fecha}marcada como final',['rev'=>$rev->rev,'fecha'=>$rev->fecha]));
            return false;
        }else{
            if($this->iAmLastRevision()){
               
                $this->final=true;
                return true;
            }else{
              $this->addError('final',yii::t('base.errors','Existe una revisión posterior a esta verifique'));
                return false;
            }
        }
    }
    
}
