@extends('layouts.app')

@section('content')
    <div class="px-3 py-4">
        <form action="{{url('/resetPassword/newPasswordVerify')}}" class="w-50 mx-auto border p-3 rounded-3" method="post" autocomplete="off">

            <h4>Reset Password Verify Form </h4>
            <hr size="2">

            {{ showErrors() }}


            <div class="form-group mt-2">
                <label for="password" class="form-label">Password :</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Your Password ...">
            </div>

            <div class="form-group mt-2">
                <label for="confirm" class="form-label">Confirm Password :</label>
                <input type="password" class="form-control" name="confirm" id="confirm" placeholder="Enter Your Confirm Password ..." >
            </div>

            <div class="form-group my-3 justify-content-center d-flex">
                <button type="submit" class="btn btn-sm btn-success me-2">submit</button>
                <button type="reset" class="btn btn-sm btn-danger">reset</button>
            </div>

        </form>
    </div>
@endsection
