<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Stripe\PromotionCode;
use Stripe\Stripe;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $data['intent']     = auth()->user()->createSetupIntent();

        return view('subscriptions.index', $data);
    }

    public function premium()
    {
        if (!Auth::user()->subscribed('default')) return Redirect::route('subscriptions.checkout');

        return view('subscriptions.premium');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        try {
            if (!$request->coupon) {
                $user->newSubscription('default', 'price_1KZGFYBOYMHClJEAMzjVbcu9')->create($request->token);
            }
            $user->newSubscription('default', 'price_1KZGFYBOYMHClJEAMzjVbcu9')->withCoupon($request->coupon)->create($request->token);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['status' => $e->getMessage()]);
        }
        return redirect()->route('subscriptions.premium');
    }

    public function account(Request $request)
    {
        $data['title']          = 'Minha Assinatura';
        $data['invoices']       = $request->user()->invoices();
        $data['subscription']   = $request->user()->subscription('default');
        $data['user']           = $request->user();
        return view('subscriptions.account', $data);
    }

    public function downloadInvoice($invoiceId)
    {
        return Auth::user()->downloadInvoice($invoiceId, [
            'vendor' => config('app.name'),
            'product' => 'Assinatura VIP'
        ]);
    }

    public function cancel(Request $request)
    {
        try {
            $request->user()->subscription('default')->cancel();
            return Redirect::route('subscriptions.account');
        } catch (\Exception $e) {
            return redirect()->route('subscriptions.account')->with('error', 'Erro on operation');
        }
    }

    public function resume(Request $request)
    {
        try {
            $request->user()->subscription('default')->resume();
            return Redirect::route('subscriptions.account')->with('success', 'Subscription activated success');
        } catch (\Exception $e) {
            return redirect()->route('subscriptions.account')->with('error', 'Error on operation');
        }
    }
}
