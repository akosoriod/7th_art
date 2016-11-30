<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property integer $id
 * @property string $comment
 * @property string $date
 * @property integer $user_id
 * @property integer $category_id
 * @property integer $parent_id
 * @property integer $audio_id
 * @property integer $step_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Category $category
 * @property Comment $parent
 * @property Comment[] $comments
 * @property Audio $audio
 * @property Step $step
 */
class Comment extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user_comment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('comment, date, user_id, category_id, step_id', 'required',
                'message' => 'Por favor escribe un {attribute}.'),
            array('user_id, category_id, parent_id, audio_id, step_id', 'numerical', 'integerOnly' => true),
            array('comment', 'length', 'max' => 140),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, comment, date, user_id, category_id, parent_id, step_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'parent' => array(self::BELONGS_TO, 'Comment', 'parent_id'),
            'comments' => array(self::HAS_MANY, 'Comment', 'parent_id'),
            'audio' => array(self::BELONGS_TO, 'Audio', 'audio_id'),
            'step' => array(self::BELONGS_TO, 'Step', 'step_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'comment' => 'Comentario',
            'date' => 'Fecha',
            'user_id' => 'Usuario',
            'category_id' => 'Categor&iacute;a',
            'parent_id' => 'Parent',
            'audio_id' => 'Audio',
            'step_id' => 'Step',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('audio_id', $this->audio_id);
        $criteria->compare('step_id', $this->step_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Comment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}