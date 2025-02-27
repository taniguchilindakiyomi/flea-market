<?php
namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;
use Stripe\Checkout\Session;

class StripeService
{

    public function __construct()
    {

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    }

    /**
     * 支払いインテントを作成する
     *
     * @param float $amount 支払い金額（単位: セント）
     * @param string $currency 通貨（例: 'jpy'）
     * @return PaymentIntent
     */
    public function createPaymentIntent($amount)
    {
        return PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'jpy',
            'payment_method_types' => ['card'],

        ]);

    }

    public function createConvenienceStoreCheckoutSession($amount)
    {
        return Session::create([
            'payment_method_types' => ['konbini'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'jpy', // 日本円
                        'product_data' => [
                            'name' => '商品名', // 商品名（実際のアイテム名に置き換えてください）
                        ],
                        'unit_amount' => $amount,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => url("/purchase/success/"), // 成功時のURL
            'cancel_url' => url("/purchase/cancel/"),   // キャンセル時のURL
        ]);
    }
}