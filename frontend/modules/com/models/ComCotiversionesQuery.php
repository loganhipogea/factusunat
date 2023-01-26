<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[\frontend\modules\coti\models\ComCotiversiones]].
 *
 * @see \frontend\modules\coti\models\ComCotiversiones
 */
class ComCotiversionesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \frontend\modules\coti\models\ComCotiversiones[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\modules\coti\models\ComCotiversiones|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
