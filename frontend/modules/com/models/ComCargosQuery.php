<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComCargos]].
 *
 * @see ComCargos
 */
class ComCargosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComCargos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComCargos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
