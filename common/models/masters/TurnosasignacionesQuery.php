<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[Turnosasignaciones]].
 *
 * @see Turnosasignaciones
 */
class TurnosasignacionesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Turnosasignaciones[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Turnosasignaciones|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
