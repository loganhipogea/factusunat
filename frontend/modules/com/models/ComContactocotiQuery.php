<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComContactocoti]].
 *
 * @see ComContactocoti
 */
class ComContactocotiQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComContactocoti[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComContactocoti|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
