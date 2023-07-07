<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[AitColumnas]].
 *
 * @see AitColumnas
 */
class AitColumnasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AitColumnas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AitColumnas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
