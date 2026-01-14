<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Task - Laravel To-Do List</title>
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
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #e9ecef;
            transition: border-color 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.25);
        }
        .btn-custom {
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 500;
            transition: transform 0.2s ease;
        }
        .btn-custom:hover {
            transform: translateY(-1px);
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <!-- Header -->
            <div class="text-center mb-4 fade-in">
                <h2 class="text-primary fw-bold mb-2">
                    <i class="bi bi-pencil-square me-2"></i>Edit Task
                </h2>
                <p class="text-muted">Update your task details below.</p>
            </div>

            <!-- Edit Form Card -->
            <div class="card p-4 fade-in">
                <form action="{{ route('todos.updateTitle', $todo->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Task Title Field -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark mb-2">
                            <i class="bi bi-list-task me-1"></i>Task Name
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-tag text-muted"></i>
                            </span>
                            <input type="text" 
                                   name="title" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $todo->title) }}" 
                                   placeholder="Enter task name..." 
                                   required>
                        </div>
                        @error('title')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Priority Field -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark mb-2">
                            <i class="bi bi-star me-1"></i>Priority
                        </label>
                        <select name="priority" class="form-select @error('priority') is-invalid @enderror">
                            <option value="low" {{ old('priority', $todo->priority) == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', $todo->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority', $todo->priority) == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Due Date Field -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark mb-2">
                            <i class="bi bi-calendar3 me-1"></i>Due Date
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-calendar-event text-muted"></i>
                            </span>
                            <input type="date" 
                                   name="due_date" 
                                   class="form-control @error('due_date') is-invalid @enderror" 
                                   value="{{ old('due_date', $todo->due_date ? $todo->due_date->format('Y-m-d') : '') }}">
                        </div>
                        @error('due_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="/" class="btn btn-secondary btn-custom">
                            <i class="bi bi-arrow-left me-1"></i>Cancel & Back to List
                        </a>
                        <button type="submit" class="btn btn-primary btn-custom">
                            <i class="bi bi-check-circle me-1"></i>Update Task
                        </button>
                    </div>
                </form>
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