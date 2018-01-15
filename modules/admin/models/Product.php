<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property integer $category_id
 * @property integer $code
 * @property double $price
 * @property integer $availability
 * @property string $description
 * @property integer $is_new
 * @property integer $is_recommended
 * @property string $img
 * @property string $content
 * @property string $keywords
 * @property string $hit
 * @property string $new
 * @property string $sale
 */
class Product extends \yii\db\ActiveRecord
{
    public $image;
    public $gallery;

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'category_id', 'code', 'price', 'availability', 'description', 'img'], 'required'],
            [['category_id', 'code', 'availability', 'is_new', 'is_recommended'], 'integer'],
            [['price'], 'number'],
            [['description', 'content', 'hit', 'new', 'sale'], 'string'],
            [['name', 'img', 'keywords'], 'string', 'max' => 255],
            [['image'], 'file', 'extensions' => 'png, jpg'],
            [['gallery'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 4],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID товара',
            'name' => 'Название',
            'category_id' => 'Категория',
            'code' => 'Код товара',
            'price' => 'Цена',
//            'availability' => 'Ключевые слова',
            'description' => 'Мета-описание',
//            'is_new' => 'Is New',
//            'is_recommended' => 'Is Recommended',
            'image' => 'Фото',
            'gallery' => 'Галерея',
            'content' => 'Контент',
            'keywords' => 'Ключевые слова',
            'hit' => 'Хит',
            'new' => 'Новинка',
            'sale' => 'Распродажа',
        ];
    }

    public function upload() {
        if ($this->validate()) {
            $path = 'upload/store/' . $this->image->baseName . '.' . $this->image->extension;
            $this->image->saveAs($path);
            $this->attachImage($path, true);
            @unlink($path);
            return true;
        }else{
            return false;
        }
    }

    public function uploadGallery() {
        if ($this->validate()) {
            foreach ($this->gallery as $file) {
                $path = 'upload/store/' . $file->baseName . '.' . $file->extension;
                $file->saveAs($path);
                $this->attachImage($path);
                @unlink($path);
            }
            return true;
        }else{
            return false;
        }
    }
}
