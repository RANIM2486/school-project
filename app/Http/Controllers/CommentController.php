<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // عرض كل الملاحظات مع الطالب المرتبط
    public function index()
    {
        return Comment::with('student')->get();
    }

    // إضافة ملاحظة جديدة
    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create($request->validated());
        return response()->json($comment, 201);
    }

    // عرض ملاحظة واحدة
    public function show($id)
    {
        return Comment::with('student')->findOrFail($id);
    }

    // تعديل ملاحظة
    public function update(UpdateCommentRequest $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update($request->validated());
        return response()->json($comment);
    }

    // حذف ملاحظة
    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();
        return response()->json(['message' => 'تم حذف الملاحظة بنجاح']);
    }
}
