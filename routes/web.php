<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\TaskRequest;


Route::get('/', function () {
  return redirect()->route('tasks.index');
})->name('home');

Route::get('/tasks', function () {
  $tasks = Task::latest()->paginate(10);
  return view('tasks.index', ['tasks' => $tasks]);
})->name('tasks.index');

Route::get('/tasks/create', function () {
  return view('tasks.create');
})->name('tasks.create');

Route::get('/tasks/{task}/edit', function (Task $task) {
  return view('tasks.edit', ['task' => $task]);
})->name('tasks.edit');

Route::get('/tasks/{task}', function (Task $task) {
  return view('tasks.show', ['task' => $task]);
})->name('tasks.show');

Route::post('/tasks', function (TaskRequest $request) {
  $task = Task::create($request->validated());

  return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Task created successfully!');
})->name('tasks.store');

Route::put('/tasks/{task}', function (Task $task, TaskRequest $request) {
  $task->update($request->validated());

  return redirect()->route('tasks.show', ['task' => $task->id])
    ->with('success', 'Task updated successfully!');
})->name('tasks.update');

Route::delete('/tasks/{task}', function (Task $task) {
  $task->delete();

  return redirect()->route('tasks.index')
    ->with('success', 'Task deleted successfully!');
})->name('tasks.destroy');

Route::put('tasks/{task}/toggle-complete', function (Task $task) {
  $task->toggleComplete();

  return redirect()->back()->with('success', 'Task updated successfully!');
})->name('tasks.toggle-complete');