<?php
/**
 * 一个数据库数据行为
 * 可以在model里面加载这个behavior来增加动作
 */
class xzModelBehavior extends CActiveRecordBehavior
{
	public $del_column_name  = 'is_deleted';

	/**
	 * 将一个model的is_deleted列设置为1
	 * 删除数据
	 * @return [type] [description]
	 */
	public function deleteData()
	{
		$this->owner->{$this->del_column_name} = 1;
		if( $this->owner->save() )
		{
			return true;
		}
		return false;
	}

	/**
	 * 将一个model的is_deleted列设置为0
	 * 恢复数据
	 * @return [type] [description]
	 */
	public function restoreData()
	{
		$this->owner->{$this->del_column_name} = 0;
		$this->owner->save();
	}

	/**
	 * 得到指定的列的所有数据
	 * @param  string $column    [description]
	 * @param  string $condition [description]
	 * @param  array  $params    [description]
	 * @return [type]            [description]
	 */
	public function getColumn($column="*", $condition='', $params=array())
	{
		$criteria = $this->owner->getCommandBuilder()->createCriteria($condition, $params);
		$criteria->select = $column;
		$this->owner->applyScopes($criteria);

		$command = $this->owner->getCommandBuilder()->createFindCommand($this->owner->tableSchema->name ,$criteria);
		return $command->queryColumn();
	}
}
?>