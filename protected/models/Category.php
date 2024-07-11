<?php

class Category extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'category';
    }

    public function rules()
    {
        return array(
            array('name', 'required'),
            array('name, icon', 'length', 'max' => 255),
            array('id, name, icon, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        return array(
            'blogPosts' => array(self::HAS_MANY, 'BlogPost', 'category_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        );
    }
}
