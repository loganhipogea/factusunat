<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatReserva]].
 *
 * @see MatReserva
 */
class MatReservaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatReserva[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatReserva|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
