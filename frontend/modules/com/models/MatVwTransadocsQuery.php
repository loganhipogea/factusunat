<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[MatVwTransadocs]].
 *
 * @see MatVwTransadocs
 */
class MatVwTransadocsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatVwTransadocs[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatVwTransadocs|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
