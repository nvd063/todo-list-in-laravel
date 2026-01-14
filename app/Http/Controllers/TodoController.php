<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
class TodoController extends Controller
{
    // Request class ko use karne ke liye function mein inject karein
    public function index(Request $request)
    {

        $todos = Todo::query();

        if ($request->has('search')) {
            $todos->where('title', 'like', '%' . $request->search . '%');
        }

        $todos = $todos->orderBy('created_at', 'desc')->get();

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
            'due_date' => $request->due_date
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

    public function edit($id)
    {
        $todo = Todo::find($id);
        return view('edit', compact('todo'));
    }

    public function updateTitle(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date'
        ]);

        $todo = Todo::find($id);

        // Sab cheezein update kar rahe hain
        $todo->title = $request->title;
        $todo->priority = $request->priority;
        $todo->due_date = $request->due_date;

        $todo->save();

        return redirect('/');
    }
}
