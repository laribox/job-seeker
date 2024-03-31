@extends('layouts.app')

@section('content')


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verify Email</div>
                <form action="{{ route('verification.send') }}" method="POST">
                    @csrf
                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    A fresh verification link has been sent to your email address.
                                </div>
                            @endif

                            Before proceeding, please check your email for a verification link.
                            If you did not receive the email, <button type="submit"  class="btn btn-link">click here to request another</button>.
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
