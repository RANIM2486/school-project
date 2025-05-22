<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fee;
use App\Http\Requests\StoreFeeRequest;

class FeeController extends Controller
{
       public function index()
    {
        return Fee::all();
    }

    public function store(StoreFeeRequest $request)
    {
        $validated = $request->validate();

        $fee = Fee::create($validated);
        return response()->json($fee, 201);
    }

    public function update(Request $request, $id)
    {
        $fee = Fee::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:paid,unpaid',
        ]);

        $fee->update($validated);
        return response()->json($fee);
    }

    public function destroy($id)
    {
        $fee = Fee::findOrFail($id);
        $fee->delete();
        return response()->json(['message' => 'Fee deleted successfully']);
    }
}
