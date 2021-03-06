<?php

namespace App\Http\Controllers;

use App\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    private $validationRules = [
        'typeId' => 'required|numeric|exists:types,id',
        'brandId' => 'required|numeric|exists:brands,id',
        'quantity' => 'required|numeric',
        'price' => 'required|numeric',
        'value' => 'required|numeric'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bills = Bill::with('type', 'brand')->get();
        return response()->json($bills);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bills = $this->validate($request, [
            '*.typeId' => 'required|integer|exists:types,id',
            '*.brandId' => 'required|integer|exists:brands,id',
            '*.state' => 'required|string|in:hot,cold',
            '*.quantity' => 'required|numeric',
            '*.price' => 'required|numeric',
            '*.value' => 'required|numeric',
        ]);

        foreach ($bills['*'] as $b) {
            Bill::create($b);
        }

        return response()->json(['saved' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $rq = (object) $this->validate($request, $this->validationRules);

        $b = Bill::findOrFail($id);
        $b->quantity = $rq->quantity;
        $b->price = $rq->price;
        $b->value = $rq->value;

        $b->update();

        return response()->json($b);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $b = Bill::findOrFail($id);

        $b->delete();

        return response()->json(['delete' => true]);
    }
}
