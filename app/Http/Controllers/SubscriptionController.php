<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\PaymentAmount;
use Illuminate\Support\Facades\URL as FacadesURL;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class SubscriptionController extends Controller
{

    public function __construct()
    {
    }
    public function index()
    {
        return view('subscriptions.index');
    }

    public function payment(Request $request)
    {
        $plan = [
            'weekly' => [
                'amout' => PaymentAmount::WEEKLY->amount(),
                'name' => 'Weekly',
                'description' => 'Weekly Subscription',
                'currency' => 'usd',
                'quantity' => 1
            ],
            'monthly' => [
                'amout' => PaymentAmount::MONTHLY->amount(),
                'name' => 'Monthly',
                'description' => 'Monthly Subscription',
                'currency' => 'usd',
                'quantity' => 1
            ],
            'yearly' => [
                'amout' => PaymentAmount::YEARLY->amount(),
                'name' => 'Yearly',
                'description' => 'Yearly Subscription',
                'currency' => 'usd',
                'quantity' => 1
            ]
        ];



        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $selectedPlan = null;
            if ($request->is('weekly-subscriptions')) {
                $selectedPlan = $plan['weekly'];
                $billingEnd = now()->addDays(7)->startOfDay()->toDateString();
            } else if ($request->is('monthly-subscriptions')) {
                $selectedPlan = $plan['monthly'];
                $billingEnd = now()->addMonth()->startOfDay()->toDateString();
            } else if ($request->is('yearly-subscriptions')) {
                $selectedPlan = $plan['yearly'];
                $billingEnd = now()->addYear()->startOfDay()->toDateString();
            }
            if ($selectedPlan != null) {
                $successUrl = FacadesURL::signedRoute(
                    'success',
                    [
                        'plan' => $selectedPlan['name'],
                        'billingEnd' => $billingEnd
                    ]
                );
                $session = \Stripe\Checkout\Session::create([
                    'line_items' => [[
                        'price_data' => [
                            'currency' => 'usd',
                            'unit_amount' =>  $selectedPlan['amout'] * 100,
                            'product_data' => [
                                'name' =>  $selectedPlan['name'],
                                'description' =>  $selectedPlan['description'],
                                'images' => ['https://example.com/t-shirt.png'],
                            ],
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    'success_url' => $successUrl,
                    'cancel_url' => route('cancel'),
                ]);

                return redirect($session->url);
            }
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function success(Request $request)
    {
        $plan = $request->plan;
        $billingEnds = $request->billingEnd;
        User::where('id', auth()->user()->id)->update([
            'billing_end' => $billingEnds,
            'plan' => $plan,
            'trial' => null,
            'status' => 'paid'
        ]);
        return redirect()->route('dashboard')->with('success', 'Subscription successful');
    }

    public function cancel(Request $request)
    {
        return redirect()->route('dashboard')->with('error', 'Subscription unsuccessful');
    }
}
