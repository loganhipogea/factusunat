<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[OpTareosemana]].
 *
 * @see OpTareosemana
 */
class OpTareosemanaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return OpTareosemana[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OpTareosemana|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
