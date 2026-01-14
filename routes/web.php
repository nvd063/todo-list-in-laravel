<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TodoController::class, 'index']);
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::delete('/todos/{id}', [TodoController::class, 'destroy'])->name('todos.destroy');
Route::patch('/todos/{id}', [TodoController::class, 'update'])->name('todos.update');
// Edit form kholne ke liye
Route::get('/todos/{id}/edit', [TodoController::class, 'edit'])->name('todos.edit');

// Edit hone ke baad data update karne ke liye
Route::put('/todos/{id}/update-title', [TodoController::class, 'updateTitle'])->name('todos.updateTitle');