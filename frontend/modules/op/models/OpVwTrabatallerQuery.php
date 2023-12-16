<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[OpVwTrabataller]].
 *
 * @see OpVwTrabataller
 */
class OpVwTrabatallerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return OpVwTrabataller[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OpVwTrabataller|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
