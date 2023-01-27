<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComCotienvios]].
 *
 * @see ComCotienvios
 */
class ComCotienviosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComCotienvios[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComCotienvios|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
