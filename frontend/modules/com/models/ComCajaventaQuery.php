<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComCajaventa]].
 *
 * @see ComCajaventa
 */
class ComCajaventaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComCajaventa[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComCajaventa|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
