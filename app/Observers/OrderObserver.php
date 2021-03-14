<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\User_ticket;
use Exception;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        try {
            for ($i=0; $i < $order->quantity ; $i++) { 
                User_ticket::create([
                    'user_id' => auth()->id(),
                    'order_id' => $order->id,
                    'status' => 'unused'
                ]);
            }
        } catch (Exception $exception) {
            return response()->json([
                'code' => 500,
                'message' => $exception->getMessage()
            ],500);
        }
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        //
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
