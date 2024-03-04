<?php

namespace frontend\modules\prd\models;

/**
 * This is the ActiveQuery class for [[PrdPlanos]].
 *
 * @see PrdPlanos
 */
class PrdPlanosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PrdPlanos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PrdPlanos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
