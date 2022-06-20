<?php

namespace frontend\modules\logi\models;

/**
 * This is the ActiveQuery class for [[LogiVwStock]].
 *
 * @see LogiVwStock
 */
class LogiVwStockQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return LogiVwStock[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return LogiVwStock|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
