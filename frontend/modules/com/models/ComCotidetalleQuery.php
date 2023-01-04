<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComCotidetalle]].
 *
 * @see ComCotidetalle
 */
class ComCotidetalleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComCotidetalle[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComCotidetalle|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
