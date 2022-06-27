<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComCajadia]].
 *
 * @see ComCajadia
 */
class ComCajadiaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComCajadia[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComCajadia|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
