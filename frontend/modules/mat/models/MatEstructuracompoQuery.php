<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatEstructuracompo]].
 *
 * @see MatEstructuracompo
 */
class MatEstructuracompoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatEstructuracompo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatEstructuracompo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
