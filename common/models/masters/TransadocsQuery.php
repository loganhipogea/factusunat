<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[Transadocs]].
 *
 * @see Transadocs
 */
class TransadocsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Transadocs[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Transadocs|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
