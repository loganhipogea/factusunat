<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[Tipocambio]].
 *
 * @see Tipocambio
 */
class TipocambioQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Tipocambio[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tipocambio|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
