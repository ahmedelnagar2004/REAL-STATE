<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->get();
        return view('admin.clients.index', compact('clients'));
    }

    public function show($id)
    {
        $client = Client::findOrFail($id);
        return view('admin.clients.show', compact('client'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,accepted,rejected'
            ]);

            $client = Client::findOrFail($id);
            $client->request_status = $request->status;
            $client->save();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الحالة بنجاح'
            ]);
        } catch (\Exception $e) {
            \Log::error('Client status update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث الحالة'
            ], 500);
        }
    }
}