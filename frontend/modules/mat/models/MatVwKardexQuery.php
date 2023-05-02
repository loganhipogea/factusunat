<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatVwKardex]].
 *
 * @see MatVwKardex
 */
class MatVwKardexQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatVwKardex[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatVwKardex|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
