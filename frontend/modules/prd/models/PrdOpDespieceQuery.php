<?php

namespace frontend\modules\prd\models;

/**
 * This is the ActiveQuery class for [[PrdOpDespiece]].
 *
 * @see PrdOpDespiece
 */
class PrdOpDespieceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PrdOpDespiece[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PrdOpDespiece|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
