<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    public function index()
    {
        // Ambil data milik user yang sedang login saja
        $userId = auth()->id();

        $todos = Todo::where('user_id', $userId)
                     ->where('is_done', false)
                     ->latest()
                     ->get();

        $dones = Todo::where('user_id', $userId)
                     ->where('is_done', true)
                     ->latest()
                     ->get();

        return view('todolist', compact('todos', 'dones'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo = Todo::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'is_done' => false,
            'type' => 'note'
        ]);

        return response()->json([
            'success' => true,
            'data' => $todo
        ]);
    }

    public function toggle($id)
    {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);
        $todo->update(['is_done' => !$todo->is_done]);

        return response()->json(['success' => true]);
    }
    // Mengupdate isi konten/detail catatan
    public function update(Request $request, $id)
    {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);
        $todo->update([
            'content' => $request->content
        ]);

        return response()->json(['success' => true]);
    }

    // Menghapus catatan secara permanen
    public function destroy($id)
    {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);
        $todo->delete();

        return response()->json(['success' => true]);
    }
    // Menambah sub-item ke dalam checklist
    public function addSubTask(Request $request, $id) {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);
        $checklists = $todo->checklists ?? [];
        
        $checklists[] = [
            'id' => uniqid(),
            'text' => $request->text,
            'completed' => false
        ];

        $todo->update(['checklists' => $checklists]);
        return back();
    }

    // Menandai sub-item selesai/belum
    public function toggleSubTask(Request $request, $id) {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);
        $checklists = $todo->checklists;

        foreach ($checklists as &$item) {
            if ($item['id'] == $request->subtask_id) {
                $item['completed'] = !$item['completed'];
            }
        }

        $todo->update(['checklists' => $checklists]);
        return response()->json(['success' => true]);
    }
    // Update Judul Project
    public function updateTitle(Request $request, $id) {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);
        $todo->update(['title' => $request->title]);
        return response()->json(['success' => true]);
    }

    // Update Teks Sub-task/Checklist
    public function updateSubTask(Request $request, $id) {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);
        $checklists = $todo->checklists;

        foreach ($checklists as &$item) {
            if ($item['id'] == $request->subtask_id) {
                $item['text'] = $request->text;
            }
        }

        $todo->update(['checklists' => $checklists]);
        return response()->json(['success' => true]);
    }
}