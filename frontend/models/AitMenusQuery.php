<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[AitMenus]].
 *
 * @see AitMenus
 */
class AitMenusQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AitMenus[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AitMenus|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
