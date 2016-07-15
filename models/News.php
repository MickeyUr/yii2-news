<?php

namespace mickey\news\models;

//use Yii;
use mickey\news\models\query\NewsQuery;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use common\behaviors\ImageBehavior;
use common\base\LibraryRecord;
use Yii;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $annotation
 * @property string $content
 * @property string $tags
 * @property string $image
 * @property integer $status
 * @property integer $visibility
 * @property string $publish_date
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $updated_at
 */
class News extends LibraryRecord
{
    const VISIBILITY_DIRECT_ONLY = 1;
    const VISIBILITY_ARCHIVE = 2;

//    public $visibility = self::VISIBILITY_ARCHIVE;

    private $_oldTags;

    public $search_tag;

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                // 'slugAttribute' => 'slug',
                'immutable' => true, //keep the slug the same after it's first created—even if the message is updated
                'ensureUnique'=>true, //automatically append a unique suffix to duplicates
            ],
            [
                'class' => BlameableBehavior::className(),
            ],
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
            ],
            'image' => [
                'class' => ImageBehavior::className(),
                'fileAttribute' => 'image',
                'sizes' => [
                    'thumb' => [75, 75, 'resize' => 'outbound', 'required' => '@web/img/75x75-required.jpg'],
                    'default' => [1024, 768, 'required' => '@web/img/1024x768-required.jpg'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tags','title'], 'filter', 'filter'=>'strip_tags'],
//            array('annotation, content', 'filter', 'filter' => array($obj = new EHtmlPurifier(), 'purify')), //TODO HtmlPurifier
            [['publish_date','visibility','annotation','content','status','title'], 'required'],
            [['visibility', 'status'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['image'], 'file', 'extensions'=>'jpg, jpeg, gif, png'],
            ['status', 'in', 'range' => [self::STATUS_ENABLED, self::STATUS_DISABLED]],
            [['tags'], 'string', 'max' => 1024],
            ['tags', 'match', 'pattern' => '/^[a-zа-я\s,0-9-_]+$/iu', 'message' => 'Теги могут содержать только символы и цифры.'],
            [['annotation', 'content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('News', 'ID'),
            'title' => Yii::t('News', 'Заглавие'),
            'annotation' => Yii::t('News', 'Аннотация'),
            'content' => Yii::t('News', 'Содержание'),
            'tags' => Yii::t('News', 'Теги (через запятую)'),
            'image' => Yii::t('News', 'Изображение'),
            'status' => Yii::t('News', 'Опубликована'),
            'visibility' => Yii::t('News', 'Показывать'),
            'publish_date' => Yii::t('News', 'Дата публикации'),
            'created_at' => Yii::t('News', 'Добавлена'),
            'created_by' => Yii::t('News', 'Добавлена'),
            'updated_by' => Yii::t('News', 'Изменена'),
            'updated_at' => Yii::t('News', 'Изменена'),
        ];
    }

    public function init()
    {
        $this->publish_date = date('Y-m-d');
    }

    /**
     * @inheritdoc
     * @return NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsQuery(get_called_class());
    }

    public function getUri($params=[])
    {
        switch(Yii::$app->id) {
            case 'app-backend':
                $urlManager = Yii::$app->get('frontendUrlManager');
                break;
            default:
                $urlManager = Yii::$app->urlManager;
                break;
        }
//        $urlManager = Yii::$app->urlManager; //разобраться с frontendUrlManager
        $route=strtolower(Yii::$app->controller->id.'/'.$this->slug);
//        $params = ArrayHelper::merge($params, [$this->owner->slug]);
        return $urlManager->createAbsoluteUrl([$route] + $params);

        return \yii\helpers\Url::to('news/'.$this->slug);
    }
}
