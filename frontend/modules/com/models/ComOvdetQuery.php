<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComOvdet]].
 *
 * @see ComOvdet
 */
class ComOvdetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComOvdet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComOvdet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
