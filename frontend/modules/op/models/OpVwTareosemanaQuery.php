<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[OpVwTareosemana]].
 *
 * @see OpVwTareosemana
 */
class OpVwTareosemanaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return OpVwTareosemana[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OpVwTareosemana|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
