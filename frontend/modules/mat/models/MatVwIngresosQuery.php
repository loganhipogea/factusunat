<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatVwIngresos]].
 *
 * @see MatVwIngresos
 */
class MatVwIngresosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatVwIngresos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatVwIngresos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
