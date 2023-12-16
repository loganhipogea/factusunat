<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[Familia]].
 *
 * @see Familia
 */
class FamiliaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Familia[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Familia|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
