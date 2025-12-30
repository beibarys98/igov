<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $img_path
 * @property string $desc
 * @property string|null $address_coords
 * @property float|null $money
 * @property string|null $whatsapp_group
 * @property string $created_at
 * @property string $updated_at
 */
class Post extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['file', 'required'],
            ['file', 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
            [['address_coords', 'whatsapp_group'], 'default', 'value' => null],
            [['desc', 'whatsapp_group', 'money'], 'required', 'message' => 'Толтырыңыз!'],
            [['desc'], 'string'],
            [['money'], 'number', 'message' => 'Мысалы: 1000', 'min' => 100, 'tooSmall' => 'Ең азы 100 тг!'],
            [['created_at', 'updated_at'], 'safe'],
            [['img_path', 'whatsapp_group'], 'string', 'max' => 255],
            [['address_coords'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'img_path' => 'Img Path',
            'desc' => 'Desc',
            'address_coords' => 'Address Coords',
            'money' => 'Money',
            'whatsapp_group' => 'Whatsapp Group',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PostQuery(get_called_class());
    }
}
