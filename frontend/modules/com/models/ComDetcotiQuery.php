<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComDetcoti]].
 *
 * @see ComDetcoti
 */
class ComDetcotiQuery extends \frontend\modules\com\components\ActiveQueryCotiHijo
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
