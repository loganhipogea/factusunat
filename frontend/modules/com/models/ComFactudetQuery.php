<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComFactudet]].
 *
 * @see ComFactudet
 */
class ComFactudetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComFactudet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComFactudet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
