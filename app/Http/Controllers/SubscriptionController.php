<?php

namespace App\Http\Controllers;

use App\Http\Middleware\isEmployer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentAmount;

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
                'amout' => PaymentAmount::WEEKLY->amout(),
                'name' => 'Weekly'
            ],
            'monthly' => [
                'price' => PaymentAmount::MONTHLY->amout(),
                'name' => 'Monthly'
            ],
            'yearly' => [
                'price' => PaymentAmount::YEARLY->amout(),
                'name' => 'Yearly'
            ]
        ];



        if ($request->is('weekly-subscriptions')) {
            echo 'Weekly';
        } else if ($request->is('monthly-subscriptions')) {
            echo 'Monthly';
        } else if ($request->is('yearly-subscriptions')) {
            echo 'Yearly';
        }
    }

    public function success(Request $request)
    {
        dd($request->all());
    }

    public function cancel(Request $request)
    {
    }
}
