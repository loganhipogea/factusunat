<?php

namespace frontend\modules\sunat\models;

/**
 * This is the ActiveQuery class for [[SunatAccess]].
 *
 * @see SunatAccess
 */
class SunatAccessQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SunatAccess[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SunatAccess|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
