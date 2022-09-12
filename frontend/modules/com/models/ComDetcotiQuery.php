<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComDetcoti]].
 *
 * @see ComDetcoti
 */
class ComDetcotiQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComDetcoti[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComDetcoti|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
