<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatVwActivoceco]].
 *
 * @see MatVwActivoceco
 */
class MatVwActivocecoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatVwActivoceco[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatVwActivoceco|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
