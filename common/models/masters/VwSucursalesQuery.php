<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[VwSucursales]].
 *
 * @see VwSucursales
 */
class VwSucursalesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwSucursales[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwSucursales|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
