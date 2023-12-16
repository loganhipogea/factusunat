<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatGuia]].
 *
 * @see MatGuia
 */
class MatGuiaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatGuia[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatGuia|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
