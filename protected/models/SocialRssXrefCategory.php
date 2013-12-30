<?php

/**
 * This is the model class for table "xz_social_rss_xref_category".
 *
 * The followings are the available columns in table 'xz_social_rss_xref_category':
 * @property string $id
 * @property string $rss_master_id
 * @property string $rss_category_id
 */
class SocialRssXrefCategory extends xzModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'xz_social_rss_xref_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rss_master_id, rss_category_id', 'required'),
			array('rss_master_id, rss_category_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, rss_master_id, rss_category_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'rss_master_id' => 'Rss Master',
			'rss_category_id' => 'Rss Category',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('rss_master_id',$this->rss_master_id,true);
		$criteria->compare('rss_category_id',$this->rss_category_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SocialRssXrefCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
     * 因为可以多选category，所以我们选择使用一次性插入
     * @return [type] [description]
     */
    public static function insertMultipleRows($inputArray)
    {
        // 检查表里是否已经存在此rss_master_id的记录，存在就删掉
        $xref_id = self::model()->getColumn('id', 'rss_master_id='.$inputArray['rss_master_id']);
        if(count($xref_id)>0)
        {
            self::model()->deleteAll('rss_master_id='.$inputArray['rss_master_id']);
        }

        // 如果存在数据
        if(!empty($inputArray['category_id']))
        {
            // 将数据插入，使用一次性的插入
            $sql="INSERT INTO xz_social_rss_xref_category(rss_master_id, rss_category_id) VALUES";
            foreach ($inputArray['category_id'] as $key => $val) 
            {
                $sql .= " (".$inputArray['rss_master_id'].", ".$val."),";
            }

            $sql = rtrim($sql, ',');
            
            return Yii::app()->db->createCommand($sql)->execute();
        }
    }
}
