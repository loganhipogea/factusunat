<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComDetcotiManoObra]].
 *
 * @see ComDetcotiManoObra
 */
class ComDetcotiManoObraQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComDetcotiManoObra[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComDetcotiManoObra|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
