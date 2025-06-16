<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;

class AdController extends Controller
{
    public function index()
    {
        return Ad::with('user')->get();
    }
    public function store(Request $request)
    {

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',  // التحقق من وجود المستخدم
            'title' => 'required|string|max:255',    // التحقق من العنوان
            'content' => 'required|string',          // التحقق من المحتوى
        ]);

        // إنشاء الإعلان وتخزينه في قاعدة البيانات
        $ad = Ad::create($validated);

        // إرجاع الرد مع الإعلان الذي تم إنشاؤه
        return response()->json($ad, 201); // رمز الحالة 201 يعني أن المورد تم إنشاؤه بنجاح
    }
     public function update(Request $request)
    {
        $ad = Ad::findOrFail($request->id);
        $ad->update($request->only(['title', 'content']));
        return response()->json($ad);
    }
     public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:ads,id'
        ]);

        $ad = Ad::findOrFail($request->id);
        $ad->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
