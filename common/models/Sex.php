<?php

namespace common\models;
use Yii;
use yii\db\ActiveRecord;
use common\models\User;


/**
 * This is the model class for table "sex".
 *
 * @property integer $idGroups
 * @property string $groupsName
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class Sex extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sex';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

        ];
    }

    public function getUser()
    {

        return $this->hasMany(User::className(), ['sex_id' => 'id']);
    }

}
