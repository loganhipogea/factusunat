<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[ServiciosTarifados]].
 *
 * @see ServiciosTarifados
 */
class ServiciosTarifadosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ServiciosTarifados[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ServiciosTarifados|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
