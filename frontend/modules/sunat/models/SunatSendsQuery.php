<?php

namespace frontend\modules\sunat\models;

/**
 * This is the ActiveQuery class for [[SunatSends]].
 *
 * @see SunatSends
 */
class SunatSendsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SunatSends[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SunatSends|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
