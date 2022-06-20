<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComOv]].
 *
 * @see ComOv
 */
class ComOvQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComOv[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComOv|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
