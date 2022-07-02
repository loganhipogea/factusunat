<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComVwFactudet]].
 *
 * @see ComVwFactudet
 */
class ComVwFactudetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComVwFactudet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComVwFactudet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
