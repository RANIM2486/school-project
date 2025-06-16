<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
        public function index()
    {
        return Notification::with('user')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $notification = Notification::create($validated);
        return response()->json($notification, 201);
    }
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:notifications,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $notification = Notification::findOrFail($request->id);
        $notification->update($request->only(['title', 'content']));
        return response()->json($notification);
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:notifications,id'
        ]);

        $notification = Notification::findOrFail($request->id);
        $notification->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
