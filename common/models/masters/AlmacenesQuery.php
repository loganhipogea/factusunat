<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[Almacenes]].
 *
 * @see Almacenes
 */
class AlmacenesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Almacenes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Almacenes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
