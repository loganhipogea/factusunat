<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatDetpetServicio]].
 *
 * @see MatDetpetServicio
 */
class MatDetpetServicioQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatDetpetServicio[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatDetpetServicio|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
