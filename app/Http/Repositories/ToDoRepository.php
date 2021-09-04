<?php

namespace App\Http\Repositories;

use App\Models\Todo;

class ToDoRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(new Todo());
    }

    public function userTodo($request)
    {
        return Todo::where('user_id', auth()->user()->id)
            ->when($request->search, function($query) use($request){
                $query->where('title', 'like', '%'.$request->search);
            })->cursorPaginate(10);
    }
}
