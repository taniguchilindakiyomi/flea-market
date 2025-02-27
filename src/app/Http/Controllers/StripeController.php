<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function showPaymentPage(Request $request, $paymentIntentId)
    {

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));


        $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);


        $session = Session::create([


            'payment_method_types' => ['card', 'konbini'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'jpy',  // 日本円
                        'product_data' => [
                            'name' => 'Sample Product',  // 商品名を指定
                        ],
                        'unit_amount' => 1000,  // 商品価格を指定（1000円など）
                    ],
                    'quantity' => 1,  // 数量（1個）
                ],
            ],
            'mode' => 'payment',
            'payment_intent_data' => [
                'setup_future_usage' => 'off_session',
            ],

            'success_url' => url("/purchase/success/{$paymentIntent->id}") . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => url("/purchase/cancel/{$paymentIntent->id}"),
        ]);


        return redirect($session->url);
    }
}
