<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[OpOsdespiece]].
 *
 * @see OpOsdespiece
 */
class OpOsdespieceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return OpOsdespiece[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OpOsdespiece|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
