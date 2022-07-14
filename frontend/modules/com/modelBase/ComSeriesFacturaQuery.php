<?php

namespace frontend\modules\com\modelBase;

/**
 * This is the ActiveQuery class for [[ComSeriesFactura]].
 *
 * @see ComSeriesFactura
 */
class ComSeriesFacturaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComSeriesFactura[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComSeriesFactura|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
