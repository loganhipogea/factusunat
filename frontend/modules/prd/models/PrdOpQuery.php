<?php

namespace frontend\modules\prd\models;

/**
 * This is the ActiveQuery class for [[PrdOp]].
 *
 * @see PrdOp
 */
class PrdOpQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PrdOp[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PrdOp|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
