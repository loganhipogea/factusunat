<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComFactura]].
 *
 * @see ComFactura
 */
class ComFacturaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComFactura[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComFactura|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
