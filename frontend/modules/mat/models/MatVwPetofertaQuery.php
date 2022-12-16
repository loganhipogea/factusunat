<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatVwPetoferta]].
 *
 * @see MatVwPetoferta
 */
class MatVwPetofertaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatVwPetoferta[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatVwPetoferta|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
