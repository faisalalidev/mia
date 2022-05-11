<?php

namespace App\Repositories\Admin;

use App\Models\Task;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TaskRepository
 * @package App\Repositories\Admin
 * @version May 11, 2022, 10:08 pm UTC
 *
 * @method Task findWithoutFail($id, $columns = ['*'])
 * @method Task find($id, $columns = ['*'])
 * @method Task first($columns = ['*'])
*/
class TaskRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'user_id',
        'name',
        'detail'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Task::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $task = $this->create($input);
        return $task;
    }

    /**
     * @param $request
     * @param $task
     * @return mixed
     */
    public function updateRecord($request, $task)
    {
        $input = $request->all();
        $task = $this->update($input, $task->id);
        return $task;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $task = $this->delete($id);
        return $task;
    }
}
