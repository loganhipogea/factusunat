<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[Usercentros]].
 *
 * @see Usercentros
 */
class UsercentrosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Usercentros[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Usercentros|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
