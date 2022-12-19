<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComCoticeco]].
 *
 * @see ComCoticeco
 */
class ComCoticecoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComCoticeco[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComCoticeco|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
