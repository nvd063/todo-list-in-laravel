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
            <input type="text" name="title" class="form-control" placeholder="Enter new task..." required>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>

    <div class="card mt-4 p-3 shadow-sm">
        <ul class="list-group list-group-flush">
    @foreach ($todos as $todo)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="{{ $todo->is_completed ? 'text-decoration-line-through text-muted' : '' }}">
                {{ $todo->title }}
            </span>
            
            <div class="d-flex gap-2">
                <form action="{{ route('todos.update', $todo->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm {{ $todo->is_completed ? 'btn-secondary' : 'btn-success' }}">
                        {{ $todo->is_completed ? 'Undo' : 'Done' }}
                    </button>
                </form>

                <form action="{{ route('todos.destroy', $todo->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
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