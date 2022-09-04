@extends('layouts.app')

@section('content')
    <div class="px-3 py-4">
        <form action="{{url('/resetPassword/tokenVerify')}}" class="w-50 mx-auto border p-3 rounded-3" method="post"
              autocomplete="off">
            <h4>Reset Password Verify Form </h4>
            <hr size="2">

            {{ showErrors() }}


            <div class="alert alert-success">
                <p>We Send An Email To <b class="mx-2">{{$email}}</b>. Please Enter Your Token ...</p>
            </div>

            <div class="form-group mt-2 d-none">
                <input type="hidden" class="form-control" name="email" id="email" value="{{$email}}">
            </div>

            <div class="timer-container d-flex justify-content-center align-items-center">
                <div>
                    <span id="timer">
                        {{\Carbon\Carbon::make($expiredAt)->diffInSeconds(\Carbon\Carbon::now())}}
                    </span> seconds
                </div>
            </div>
            <div class="form-group mt-2">
                <label for="token" class="form-label">Token :</label>
                <input type="string" class="form-control" name="token" id="token" placeholder="Enter Your token ...">
            </div>

            <div class="form-group my-3 justify-content-center d-flex">
                <button type="submit" class="btn btn-sm btn-success me-2">submit</button>
                <button type="reset" class="btn btn-sm btn-danger">reset</button>
            </div>

        </form>
    </div>
@endsection
