@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    @if(session('posted', false))
                      posted
                    @endif
                    <h1>{{ \Carbon\Carbon::now() }}</h1>
                    {!! Form::open([
                        'route' => 'home',
                        'method' => 'post',
                        ]) !!}
                    {!! Form::hidden('timetravel', request()->get('timetravel')) !!}
                    {!! Form::submit('submit') !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
