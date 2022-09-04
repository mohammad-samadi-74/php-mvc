

@extends('layouts.app')

@section('content')
    <div class="px-3 py-4">
        <form action="{{url('/resetPassword/confirm')}}" class="w-50 mx-auto border p-3 rounded-3" method="post">

            <h4>Reset Password Form </h4>
            <hr size="2">

            {{ showErrors() }}



            <div class="form-group mt-2">
                <label for="email" class="form-label">Email :</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Your Email ..."
                       value="{{old('email')}}">
            </div>

            <div class="form-group my-3 justify-content-center d-flex">
                <button type="submit" class="btn btn-sm btn-success me-2">submit</button>
                <button type="reset" class="btn btn-sm btn-danger">reset</button>
            </div>

        </form>
    </div>
@endsection
