<!DOCTYPE html>
<html lang="en">
<head>
    <title>Laravel To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .list-group-item {
            border: none;
            border-radius: 10px;
            margin-bottom: 8px;
            transition: transform 0.2s ease;
        }
        .list-group-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .overdue-item {
            background: linear-gradient(90deg, #fff5f5 0%, #ffeaea 100%);
            border-left: 4px solid #dc3545;
        }
        .completed-item {
            background-color: #f8fff8;
            opacity: 0.8;
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .btn-custom {
            border-radius: 25px;
            padding: 8px 16px;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <h1 class="text-center mb-4 text-primary fw-bold">
                <i class="bi bi-check2-circle me-2"></i>My To-Do List
            </h1>
            
            <!-- Task Count -->
            <div class="text-center mb-4">
                <span class="badge bg-info fs-6 px-3 py-2">
                    Total Tasks: {{ $todos->count() }}
                </span>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="row justify-content-center mb-4">
        <div class="col-lg-8 col-md-10">
            <form action="/" method="GET" class="card p-3">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0" 
                           placeholder="Search tasks by title..." 
                           value="{{ request('search') }}">
                    
                    <button type="submit" class="btn btn-outline-primary btn-custom">
                        <i class="bi bi-search me-1"></i>Search
                    </button>
                    
                    @if(request('search'))
                        <a href="/" class="btn btn-outline-secondary btn-custom">
                            <i class="bi bi-x-circle me-1"></i>Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
    
    <!-- Add Task Form -->
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10 col-md-12">
            <div class="card p-4">
                <form action="{{ route('todos.store') }}" method="POST" class="d-flex flex-wrap gap-2 align-items-end">
                    @csrf
                    
                    <div class="flex-grow-1" style="min-width: 200px;">
                        <label class="form-label fw-bold text-muted small">Task Title</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-list-task"></i>
                            </span>
                            <input type="text" name="title" class="form-control" placeholder="Enter task name..." required>
                        </div>
                    </div>
                    
                    <div style="min-width: 120px;">
                        <label class="form-label fw-bold text-muted small">Priority</label>
                        <select name="priority" class="form-select">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>

                    <div style="min-width: 150px;">
                        <label class="form-label fw-bold text-muted small">Due Date</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-calendar3"></i>
                            </span>
                            <input type="date" name="due_date" class="form-control">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-custom">
                        <i class="bi bi-plus-circle me-1"></i>Add Task
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Todos List -->
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card p-4">
                <ul class="list-group list-group-flush">
                    @forelse ($todos as $todo)
                        @php
                            $isOverdue = !$todo->is_completed && $todo->due_date && $todo->due_date->isPast();
                        @endphp

                        <li class="list-group-item d-flex justify-content-between align-items-start fade-in {{ $isOverdue ? 'overdue-item' : '' }} {{ $todo->is_completed ? 'completed-item' : '' }}">
                            
                            <div class="flex-grow-1 me-3">
                                <!-- Priority Badge -->
                                @if($todo->priority == 'high') 
                                    <span class="badge bg-danger rounded-pill px-3 py-2 me-2">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i>High
                                    </span>
                                @elseif($todo->priority == 'medium') 
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2 me-2">
                                        <i class="bi bi-star-fill me-1"></i>Medium
                                    </span>
                                @else 
                                    <span class="badge bg-success rounded-pill px-3 py-2 me-2">
                                        <i class="bi bi-check-circle-fill me-1"></i>Low
                                    </span>
                                @endif

                                <!-- Title -->
                                <span class="h6 fw-bold {{ $todo->is_completed ? 'text-decoration-line-through text-muted' : 'text-dark' }}">
                                    {{ $todo->title }}
                                </span>

                                <!-- Due Date -->
                                @if($todo->due_date)
                                    <small class="d-block text-muted mt-1">
                                        <i class="bi bi-calendar-event me-1"></i>
                                        {{ $todo->due_date->format('d M, Y') }} 
                                        @if($isOverdue)
                                            <span class="text-danger fw-bold">
                                                <i class="bi bi-clock-history me-1"></i>(Overdue!)
                                            </span>
                                        @endif
                                    </small>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="d-flex gap-2 align-items-center">
                                <form action="{{ route('todos.update', $todo->id) }}" method="POST" style="display: inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $todo->is_completed ? 'btn-outline-secondary' : 'btn-success' }} rounded-pill px-3">
                                        <i class="bi bi-{{ $todo->is_completed ? 'arrow-counterclockwise' : 'check-lg' }}"></i>
                                        {{ $todo->is_completed ? 'Undo' : 'Done' }}
                                    </button>
                                </form>
                                
                                <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-warning btn-sm rounded-pill px-3" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                
                                <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3" onclick="return confirm('Are you sure you want to delete this task?')" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-center py-5 fade-in">
                            <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                            <div class="alert alert-info border-0">
                                <h5 class="mb-2">No tasks yet!</h5>
                                <p class="mb-0">Add your first task above or try searching for something.</p>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="text-center mt-5 py-3">
    <p class="text-muted mb-0">&copy; 2026 Laravel To-Do App. Made by Naveed Mughal.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>