<?php

namespace frontend\modules\cc\models;

/**
 * This is the ActiveQuery class for [[CcCostos]].
 *
 * @see CcCostos
 */
class CcCostosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CcCostos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CcCostos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
