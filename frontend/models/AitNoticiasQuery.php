<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[AitNoticias]].
 *
 * @see AitNoticias
 */
class AitNoticiasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AitNoticias[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AitNoticias|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
