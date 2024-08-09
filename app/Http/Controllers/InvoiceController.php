<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('items')->get();
        return InvoiceResource::collection($invoices);
    }

    public function store(InvoiceRequest $request)
    {
        try {
            $invoice = Invoice::create(
                [
                    'client_id' => $request->client_id,
                    'invoice_number' => $request->invoice_number,
                    'issue_date' => $request->issue_date,
                    'subtotal' => $request->subtotal,
                    'igv' => $request->igv,
                    'total' => $request->total
                ]
            );

            foreach ($request->items as $key => $value) {
                InvoiceItem::create([
                    'invoice_id' => $invoice['id'],
                    'description' => $value['description'],
                    'quantity' => $value['quantity'],
                    'unit_price' => $value['unit_price'],
                    'total_price' => $value['total_price']
                ]);
            }

            return new InvoiceResource($invoice);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function update(InvoiceRequest $request, $id)
    {
        try {
            $invoice = Invoice::find($id);

            InvoiceItem::where('invoice_id', $invoice->id)->delete();

            foreach ($request->items as $key => $value) {
                InvoiceItem::create([
                    'invoice_id' => $invoice['id'],
                    'description' => $value['description'],
                    'quantity' => $value['quantity'],
                    'unit_price' => $value['unit_price'],
                    'total_price' => $value['total_price']
                ]);
            }

            $invoice->update([
                'client_id' => $request->client_id,
                'issue_date' => $request->issue_date,
                'subtotal' => $request->subtotal,
                'igv' => $request->igv,
                'total' => $request->total
            ]);

            return new InvoiceResource($invoice);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $invoice = Invoice::find($id);
            InvoiceItem::where('invoice_id', $invoice->id)->delete();
            $invoice->delete();

            return response()->json([
                null
            ], 204);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
