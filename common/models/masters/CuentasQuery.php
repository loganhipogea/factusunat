<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[SigiCuentas]].
 *
 * @see SigiCuentas
 */
class CuentasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiCuentas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiCuentas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
