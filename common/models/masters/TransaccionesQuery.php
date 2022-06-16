<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[Transacciones]].
 *
 * @see Transacciones
 */
class TransaccionesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Transacciones[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Transacciones|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
