<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatMatAlmacen]].
 *
 * @see MatMatAlmacen
 */
class MatMatAlmacenQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatMatAlmacen[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatMatAlmacen|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
