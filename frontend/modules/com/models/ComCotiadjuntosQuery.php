<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComCotiadjuntos]].
 *
 * @see ComCotiadjuntos
 */
class ComCotiadjuntosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComCotiadjuntos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComCotiadjuntos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
