<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Response]].
 *
 * @see Response
 */
class ResponseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Response[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Response|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
