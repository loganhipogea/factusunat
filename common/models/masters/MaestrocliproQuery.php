<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[Maestroclipro]].
 *
 * @see Maestroclipro
 */
class MaestrocliproQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Maestroclipro[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Maestroclipro|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
