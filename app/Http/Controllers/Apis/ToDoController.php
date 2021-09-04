<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ToDoRepository;
use App\Http\Requests\TodoRequest;
use App\Http\Resources\ToDoResource;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ToDoController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $todo = (new ToDoRepository())->userTodo($request);
            return $this->responseWithSuccess('Todo List', $todo);

        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request)
    {
        try {
            $request->request->add(['user_id' => auth()->user()->id]);
            $todo = (new ToDoRepository())->create($request->all());
            return $this->responseWithSuccess('Todo created successfully.', (new ToDoResource($todo)));
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       try {
            $todo = (new ToDoRepository())->show($id);
            return $this->responseWithSuccess('Todo Detail',(new ToDoResource($todo)));
       } catch (\Exception $exception) {
           return $this->responseWithError($exception->getMessage());
       }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $todo = (new ToDoRepository())->update($request->all(),$id);
            return $this->responseWithSuccess('Todo updated successfully', (new ToDoResource($todo)));
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            (new ToDoRepository())->delete($id);
            return $this->responseWithSuccess('Todo deleted successfully');
        } catch (\Exception $exception) {
            $this->responseWithError($exception->getMessage());
        }
    }
}
