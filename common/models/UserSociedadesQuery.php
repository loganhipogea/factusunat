<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[UserSociedades]].
 *
 * @see UserSociedades
 */
class UserSociedadesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserSociedades[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserSociedades|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
