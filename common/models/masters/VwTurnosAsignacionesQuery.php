<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[VwTurnosAsignaciones]].
 *
 * @see VwTurnosAsignaciones
 */
class VwTurnosAsignacionesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwTurnosAsignaciones[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwTurnosAsignaciones|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
