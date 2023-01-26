<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComCotiFake]].
 *
 * @see ComCotiFake
 */
class ComCotiFakeQuery extends \frontend\modules\com\components\ActiveQueryCotiFake
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComCotiFake[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComCotiFake|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
