<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatActivoscecos]].
 *
 * @see MatActivoscecos
 */
class MatActivoscecosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatActivoscecos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatActivoscecos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
