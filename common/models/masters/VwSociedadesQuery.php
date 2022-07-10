<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[VwSociedades]].
 *
 * @see VwSociedades
 */
class VwSociedadesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwSociedades[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwSociedades|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
