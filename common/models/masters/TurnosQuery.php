<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[Turnos]].
 *
 * @see Turnos
 */
class TurnosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Turnos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Turnos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
