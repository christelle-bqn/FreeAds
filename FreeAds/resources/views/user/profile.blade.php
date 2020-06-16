@extends('layouts.app')

@section('content')
@if(session()->has('info'))
    <div class="alert alert-success" role="alert">
        {{ session('info') }}
    </div>
@endif
<div class="container-main">
    <div class="container-profile">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        My profile
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Name : {{ $user->name }}</li>
                        <li class="list-group-item">City : {{ $user->city }}</li>
                        <li class="list-group-item">E-mail : {{ $user->email }}</li>
                    </ul>
                    <button type="button" class="btn" style="background-color:#8BDAD1">
                        <a class="nav-link" href="{{ url('users/'.$user->id.'/edit') }}">{{ __('Modify') }}</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-profile-categories">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Add your favorite categories for customized advertisements') }}
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" method="POST" action="{{ route('users.store', Auth::id()) }}">
                        {{ csrf_field() }}
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    @foreach($categories as $category)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $category->id }}" id="{{ $category->id }}" name="categories[]">
                                            <label class="form-check-label" for="{{ $category->id }}">
                                                {{ $category->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </li>
                                <button type="submit" class="btn" style="background-color:#8BDAD1">
                                    {{ __('Add') }}
                                </button>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-userdelete">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <form class="form-horizontal" method="POST" action="{{ url('users/'.$user->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn" style="background-color:#8BDAD1">
                        Delete my account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection