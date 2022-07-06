<?php

namespace frontend\modules\sunat\models;

/**
 * This is the ActiveQuery class for [[SunatSendSumary]].
 *
 * @see SunatSendSumary
 */
class SunatSendSumaryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SunatSendSumary[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SunatSendSumary|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
