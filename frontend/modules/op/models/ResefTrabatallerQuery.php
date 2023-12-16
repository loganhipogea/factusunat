<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[ResefTrabataller]].
 *
 * @see ResefTrabataller
 */
class ResefTrabatallerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ResefTrabataller[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ResefTrabataller|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
