<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatDetGuia]].
 *
 * @see MatDetGuia
 */
class MatDetNeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatDetGuia[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatDetGuia|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
