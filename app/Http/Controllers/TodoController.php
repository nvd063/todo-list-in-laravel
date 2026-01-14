<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return view('todos', compact('todos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date'
        ]);

        Todo::create([
            'title' => $request->title,
            'priority' => $request->priority,
            'due_date'=> $request->due_date
        ]);

        return redirect()->back();
    }
    public function destory($id)
    {
        Todo::destory($id);
        return redirect()->back();
    }

    // Is function ko TodoController class ke andar add karein

    public function update($id)
    {
        $todo = Todo::find($id);

        // Agar complete hai to incomplete kardo, aur agar nahi hai to complete kardo
        $todo->is_completed = !$todo->is_completed;
        $todo->save();

        return redirect()->back();
    }

    public function edit($id){
        $todo = Todo::find($id);
        return view('edit',compact('todo'));
    }

    public function updateTitle(Request $request, $id){
        $request->validate([
            'title'=>'required'
        ]);
        $todo = Todo::find($id);
        $todo->title = $request->title;
        $todo->save();

        return redirect('/');
    }
}
