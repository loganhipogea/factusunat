<?php

namespace frontend\modules\com\models;
use frontend\modules\com\components\ActiveQueryCotiPadre;
/**
 * This is the ActiveQuery class for [[ComCotiDet]].
 *
 * @see ComCotiDet
 */
class ComCotiDetQuery extends ActiveQueryCotiPadre
{
    
    public function all($db = null)
    {
        return parent::all($db);
    }

    
    public function one($db = null)
    {
        return parent::one($db);
    }
    
}
