<!DOCTYPE html>
<html>
<head>
    <title>Laravel To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="text-center mb-4">My To-Do List</h1>
    
    <div class="card p-4 shadow-sm">
        <form action="{{ route('todos.store') }}" method="POST" class="d-flex gap-2">
    @csrf
    
    <input type="text" name="title" class="form-control" placeholder="Task Name..." required style="width: 50%;">
    
    <select name="priority" class="form-select" style="width: 20%;">
        <option value="low">Low</option>
        <option value="medium" selected>Medium</option>
        <option value="high">High</option>
    </select>

    <input type="date" name="due_date" class="form-control" style="width: 20%;">

    <button type="submit" class="btn btn-primary" style="width: 10%;">Add</button>
</form>
    </div>

    <div class="card mt-4 p-3 shadow-sm">
        <ul class="list-group list-group-flush">
            @foreach ($todos as $todo)
    @php
        $isOverdue = !$todo->is_completed && $todo->due_date && $todo->due_date->isPast();
    @endphp

    <li class="list-group-item d-flex justify-content-between align-items-center {{ $isOverdue ? 'border border-danger bg-light-danger' : '' }}">
        
        <div>
            @if($todo->priority == 'high') <span class="badge bg-danger">High</span>
            @elseif($todo->priority == 'medium') <span class="badge bg-warning text-dark">Medium</span>
            @else <span class="badge bg-success">Low</span>
            @endif

            <span class="ms-2 fw-bold {{ $todo->is_completed ? 'text-decoration-line-through text-muted' : '' }}">
                {{ $todo->title }}
            </span>

            @if($todo->due_date)
                <small class="d-block text-muted ms-1">
                    📅 {{ $todo->due_date->format('d M, Y') }} @if($isOverdue)
                        <span class="text-danger fw-bold">(Overdue!)</span>
                    @endif
                </small>
            @endif
        </div>

        <div class="d-flex gap-2">
            <form action="{{ route('todos.update', $todo->id) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-sm {{ $todo->is_completed ? 'btn-secondary' : 'btn-success' }}">
                    {{ $todo->is_completed ? 'Undo' : 'Done' }}
                </button>
            </form>
            
            <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-warning btn-sm">Edit</a>
            
            <form action="{{ route('todos.destroy', $todo->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </div>
    </li>
@endforeach
        </ul>
    </div>
</div>

</body>
</html>