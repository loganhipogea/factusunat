<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatVwStock]].
 *
 * @see MatVwStock
 */
class MatVwStockQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatVwStock[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatVwStock|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
