<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use Auth;

class UserTodoModel extends Model
{
	protected $table = 'user_todo';

	public static function call()
	{
		return new UserTodoModel;
	}

	public function todo()
	{
		$result = $this->belongsTo('App\Models\B2bApp\ToDoModel', 'todo_id');
		$result->where([['status', '<>', 'deleted']]);
		return $result; 
	}


	public function todoByJoin()
	{
		$auth = Auth::user();
		
		return $this->select('todos.id', 'todos.text', 'todos.status')
									->leftjoin('todos', $this->table.'.todo_id', '=', 'todos.id')
										->where([
													['user_id', '=', $auth->id],
													['status', '<>', 'deleted']
												])
											->get();
	}
}
