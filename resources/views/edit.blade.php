<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card p-4 shadow-sm" style="max-width: 600px; margin: 0 auto;">
        <h3 class="text-center mb-4">Edit Task</h3>

        <form action="{{ route('todos.updateTitle', $todo->id) }}" method="POST">
            @csrf
            @method('PUT') <div class="mb-3">
                <label class="form-label">Task Name</label>
                <input type="text" name="title" class="form-control" value="{{ $todo->title }}" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Task</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>