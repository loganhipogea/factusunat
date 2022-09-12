<?php

namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComCotizacion]].
 *
 * @see ComCotizacion
 */
class ComCotizacionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComCotizacion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComCotizacion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
