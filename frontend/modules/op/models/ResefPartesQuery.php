<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[ResefAreas]].
 *
 * @see ResefAreas
 */
class ResefPartesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ResefAreas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ResefAreas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
