@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div id="app">

                <form role="form" action="{{ route('status.post') }}" method="post" @submit="event1">
                    <div class="form-group{{ $errors->has('status') ? 'has-error' : '' }}">
                        <textarea placeholder="What's up {{ Auth::user()->getFirstNameOrUsername() }}?" name="status" class="form-control" rows="2"></textarea>
                        @if($errors->has('status'))
                            <span class="help-block">{{ $errors->first('status') }}</span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-default">Update status</button>
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                </form>
                <hr>
            </div>
        </div>
    </div>

    <div class="row">
        @include('templates.partials.status')
    </div>
@stop