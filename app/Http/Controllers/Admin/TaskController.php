<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\TaskDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateTaskRequest;
use App\Http\Requests\Admin\UpdateTaskRequest;
use App\Models\Role;
use App\Repositories\Admin\RoleRepository;
use App\Repositories\Admin\TaskRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\UserRepository;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;

class TaskController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  TaskRepository */
    private $taskRepository;
    private $userRepository;
    private $roleRepository;

    public function __construct(TaskRepository $taskRepo, UserRepository $userRepo, RoleRepository $roleRepo)
    {
        $this->taskRepository = $taskRepo;
        $this->userRepository = $userRepo;
        $this->roleRepository = $roleRepo;
        $this->ModelName = 'tasks';
        $this->BreadCrumbName = 'Tasks';
    }

    /**
     * Display a listing of the Task.
     *
     * @param TaskDataTable $taskDataTable
     * @return Response
     */
    public function index(TaskDataTable $taskDataTable)
    {

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $taskDataTable->render('admin.tasks.index', ['title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for creating a new Task.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);

//        $user  = $this->userRepository->whereHas( 'roles',  function ($q){
//           $q->where('role_id', Role::ROLE_USER)->get();
//        });
//        dd($user);
        return view('admin.tasks.create')->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Store a newly created Task in storage.
     *
     * @param CreateTaskRequest $request
     *
     * @return Response
     */
    public function store(CreateTaskRequest $request)
    {
        $task = $this->taskRepository->saveRecord($request);

        Flash::success($this->BreadCrumbName . ' saved successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.tasks.create'));
        } elseif (isset($request->translation)) {
            $redirect_to = redirect(route('admin.tasks.edit', $task->id));
        } else {
            $redirect_to = redirect(route('admin.tasks.index'));
        }
        return $redirect_to->with([
            'title' => $this->BreadCrumbName
        ]);
    }

    /**
     * Display the specified Task.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $task = $this->taskRepository->findWithoutFail($id);

        if (empty($task)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.tasks.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $task);
        return view('admin.tasks.show')->with(['task' => $task, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Show the form for editing the specified Task.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $task = $this->taskRepository->findWithoutFail($id);

        if (empty($task)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.tasks.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $task);
        return view('admin.tasks.edit')->with(['task' => $task, 'title' => $this->BreadCrumbName]);
    }

    /**
     * Update the specified Task in storage.
     *
     * @param  int              $id
     * @param UpdateTaskRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTaskRequest $request)
    {
        $task = $this->taskRepository->findWithoutFail($id);

        if (empty($task)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.tasks.index'));
        }

        $task = $this->taskRepository->updateRecord($request, $task);

        Flash::success($this->BreadCrumbName . ' updated successfully.');
        if (isset($request->continue)) {
            $redirect_to = redirect(route('admin.tasks.create'));
        } else {
            $redirect_to = redirect(route('admin.tasks.index'));
        }
        return $redirect_to->with(['title' => $this->BreadCrumbName]);
    }

    /**
     * Remove the specified Task from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $task = $this->taskRepository->findWithoutFail($id);

        if (empty($task)) {
            Flash::error($this->BreadCrumbName . ' not found');
            return redirect(route('admin.tasks.index'));
        }

        $this->taskRepository->deleteRecord($id);

        Flash::success($this->BreadCrumbName . ' deleted successfully.');
        return redirect(route('admin.tasks.index'))->with(['title' => $this->BreadCrumbName]);
    }
}
