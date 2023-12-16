<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[ResefParteDetPlan]].
 *
 * @see ResefParteDetPlan
 */
class ResefPartesDetPlanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ResefParteDetPlan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ResefParteDetPlan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
