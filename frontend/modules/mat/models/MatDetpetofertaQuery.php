<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatDetpetoferta]].
 *
 * @see MatDetpetoferta
 */
class MatDetpetofertaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatDetpetoferta[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatDetpetoferta|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
