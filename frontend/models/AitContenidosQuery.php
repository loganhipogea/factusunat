<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[AitContenidos]].
 *
 * @see AitContenidos
 */
class AitContenidosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AitContenidos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AitContenidos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
