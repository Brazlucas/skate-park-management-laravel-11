<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        return Invoice::where('user_id', Auth::id())->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'due_date' => 'required|date',
        ]);

        $data['user_id'] = Auth::id();

        return Invoice::create($data);
    }

    public function show($id)
    {
        return Invoice::where('user_id', Auth::id())->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::where('user_id', Auth::id())->findOrFail($id);

        $invoice->update($request->only(['description', 'amount', 'status', 'due_date']));

        return $invoice;
    }

    public function destroy($id)
    {
        $invoice = Invoice::where('user_id', Auth::id())->findOrFail($id);
        $invoice->delete();

        return response()->json(['message' => 'Fatura excluída com sucesso']);
    }
}
