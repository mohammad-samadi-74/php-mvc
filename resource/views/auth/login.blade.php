@extends('layouts.app')

@section('content')
    <div class="px-3 py-4">
        <form action="{{url('confirmLogin')}}" class="w-50 mx-auto border p-3 rounded-3" method="post"  autocomplete="off">

            <h4>Login Form </h4>
            <hr size="2">

           {{ showErrors() }}


            <div class="form-group mt-2">
                <label for="email" class="form-label">Email :</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Your Email ..." value="{{old('email')}}">
            </div>

            <div class="form-group mt-2">
                <label for="password" class="form-label">Password :</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Your Password ...">
            </div>

            <div class="form-group mt-2">
                <label for="confirm" class="form-label">Confirm Password :</label>
                <input type="password" class="form-control" name="confirm" id="confirm" placeholder="Enter Your Confirm Password ..." >
            </div>

            <div class="form-check mt-4">
                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                <label for="remember" class="form-check-label">Remember Me</label>
            </div>

            <div class="form-group mt-5 justify-content-start  d-flex">
                <a href="{{url('resetPassword')}}" class="text-decoration-none text-primary fs-6">Forget Your Password ?</a>
            </div>

            <div class="form-group my-3 justify-content-center d-flex">
                <button type="submit" class="btn btn-sm btn-success me-2">submit</button>
                <button type="reset" class="btn btn-sm btn-danger">reset</button>
            </div>



        </form>
    </div>
@endsection
