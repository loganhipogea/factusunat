<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[Modelosbase]].
 *
 * @see Modelosbase
 */
class ModelosbaseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Modelosbase[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Modelosbase|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
