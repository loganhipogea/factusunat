<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[ResefParteDet]].
 *
 * @see ResefParteDet
 */
class ResefPartesDetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ResefParteDet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ResefParteDet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
