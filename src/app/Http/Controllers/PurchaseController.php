<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Services\StripeService;
use Stripe\Stripe;
use Stripe\Checkout\Session;




class PurchaseController extends Controller
{



    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }



    public function getPurchase($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $profile = $user->profile;

        return view('purchase', compact('item', 'user', 'profile'));
    }




    public function postPurchase(PurchaseRequest $request)
    {
        $item = Item::findOrFail($request->item_id);


        if ($item->sold) {
        return redirect("/item/{$item->id}")->with('error', 'sold');
        }

        $payment_method = $request->payment_method;

        if ($payment_method === 'カード払い') {
        return $this->handleStripePayment($item);
    } elseif ($payment_method === 'コンビニ払い') {
        return $this->handleConvenienceStorePayment($item);
    } else {
        return redirect("/item/{$item->id}")->with('error', '支払い方法が無効です。');
    }
}



    public function handleStripePayment($item)
{
    // Stripe APIキーを設定
    Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

    // Stripeのチェックアウトセッションを作成
    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'jpy', // 日本円
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ],
        ],
        'mode' => 'payment',
        'success_url' => url("/purchase/success/{$item->id}") . "?session_id={CHECKOUT_SESSION_ID}",
        'cancel_url' =>  url("/purchase/cancel/{$item->id}"),
    ]);

    // 決済画面にリダイレクト
    return redirect($session->url);
}

    public function handleConvenienceStorePayment($item)
{
    $amount = $item->price;
    Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

     $session = Session::create([
        'payment_method_types' => ['konbini'],
        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'jpy', // 日本円
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ],
        ],
        'mode' => 'payment',
        'success_url' => url("/purchase/success/{$item->id}") . "?session_id={CHECKOUT_SESSION_ID}",
        'cancel_url' => url("/purchase/cancel/{$item->id}"),
    ]);

    // コンビニ払い用の決済画面へリダイレクト
    return redirect($session->url);


}




    public function getAddress($item_id)
    {
        $item = Item::findOrFail($item_id);


        return view('address-change', compact('item'));
    }




    public function postAddress(AddressRequest $request, $item_id)
    {
        $user = auth()->user();

        $user->profile->update([
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect("/purchase/{$item_id}");
    }







    public function createPaymentIntent(Request $request, $itemId)
    {
        $item = Item::findOrFail($itemId);


        $amount = $item->price;
        return \Stripe\PaymentIntent::create([
        'amount' => $amount,
        'currency' => 'jpy',
        ]);



    }



    public function paymentSuccess(Request $request, $itemId)
{

    $sessionId = $request->query('session_id');

    if (!$sessionId) {
        return redirect("/item/{$itemId}")->with('error', '決済セッションIDが見つかりませんでした。');
    }

    $session = \Stripe\Checkout\Session::retrieve($sessionId);



    $paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);

    $paymentMethodType = $session->payment_method_types[0];

    $paymentMethodMap = [
        'card' => 'クレジットカード',
        'konbini' => 'コンビニ払い'
    ];
    $paymentMethod = $paymentMethodMap[$paymentMethodType] ?? '不明';

    $item = Item::findOrFail($itemId);
        $user = Auth::user();

        // 購入情報を保存
        $order = new Order();
        $order->user_id = $user->id;
        $order->item_id = $item->id;
        $order->payment_method = $paymentMethod;
        $order->status = 'completed';
        $order->stripe_transaction_id = $paymentIntent->id;
        $order->save();

        $item->sold = true;
        $item->save();

        return redirect("/mypage?page=buy")->with('error', '購入が完了しました！');
}




    public function paymentCancel(Request $request, $itemId)
    {

        return redirect("/item/{$itemId}")->with('error', '購入処理がキャンセルされました。');
    }

}
