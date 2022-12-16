<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComCotigrupos]].
 *
 * @see ComCotigrupos
 */
class ComCotigruposQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComCotigrupos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComCotigrupos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
