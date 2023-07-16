<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatReservaDet]].
 *
 * @see MatReservaDet
 */
class MatReservaDetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatReservaDet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatReservaDet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
