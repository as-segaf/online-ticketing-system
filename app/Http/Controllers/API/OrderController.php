<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Models\Ticket;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Order::where('user_id', auth()->user()->id)->get();
        } catch (\Exception $exception) {
            return response()->json([
                'code' => 500,
                'message' => $exception->getMessage()
            ],);
        }

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request)
    {
        try {
            $ticketPrice = Ticket::findOrFail(1)->price;

            $data = Order::create([
                'user_id' => auth()->id(),
                'ticket_id' => 1,
                'quantity' => $request->quantity,
                'total_price' => $request->quantity * $ticketPrice,
            ]);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'code' => 404,
                'message' => $exception->getModel()." Resource not found",
            ],404);
        } catch (Exception $exception) {
            return response()->json([
                'code' => 500,
                'message' => $exception->getMessage()
            ],500);
        }

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $data
        ],200);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $order = Order::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'code' => 404,
                'message' => 'Order not found'
            ], 404);
        } catch (Exception $exception) {
            return response()->json([
                'code' => 500,
                'message' => $exception->getMessage()
            ],500);
        }

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $order
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
