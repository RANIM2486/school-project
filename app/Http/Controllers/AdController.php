<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use Illuminate\Support\Facades\Auth;

class AdController extends Controller
{
    //  إنشاء إعلان جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $ad = Ad::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        return response()->json([
            'message' => 'تم إنشاء الإعلان بنجاح',
            'ad' => $ad
        ], 201);
    }

    //  عرض جميع الإعلانات
    public function index()
    {
        $ads = Ad::with('user:id,name')->latest()->get();

        return response()->json($ads);
    }

    // عرض إعلان محدد
    public function show($id)
    {
        $ad = Ad::with('user:id,name')->findOrFail($id);

        return response()->json($ad);
    }

    //  تعديل إعلان
    public function update(Request $request, $id)
    {
        $ad = Ad::findOrFail($id);

        // التأكد أن المستخدم هو صاحب الإعلان
        if ($ad->user_id !== Auth::id()) {
            return response()->json(['error' => 'غير مسموح بالتعديل'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
        ]);

        $ad->update($validated);

        return response()->json([
            'message' => 'تم تعديل الإعلان',
            'ad' => $ad
        ]);
    }

    //  حذف إعلان
    public function destroy($id)
    {
        $ad = Ad::findOrFail($id);

        // التأكد أن المستخدم هو صاحب الإعلان
        if ($ad->user_id !== Auth::id()) {
            return response()->json(['error' => 'غير مسموح بالحذف'], 403);
        }

        $ad->delete();

        return response()->json(['message' => 'تم حذف الإعلان']);
    }

}
