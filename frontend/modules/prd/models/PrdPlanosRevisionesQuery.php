<?php

namespace frontend\modules\prd\models;

/**
 * This is the ActiveQuery class for [[PrdPlanosRevisiones]].
 *
 * @see PrdPlanosRevisiones
 */
class PrdPlanosRevisionesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PrdPlanosRevisiones[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PrdPlanosRevisiones|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
