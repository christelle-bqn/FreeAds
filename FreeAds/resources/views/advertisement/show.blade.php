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
                    <div class="card-header card-header-ad">
                        Advertisement
                        <div class="card-header-buttons">
                            <button type="submit" class="btn" style="background-color:#8BDAD1">
                                <a href="{{ route('advertisements.user', ['id' => Auth::id()]) }}">My advertisements</a>
                            </button>
                            <button type="submit" class="btn" style="background-color:#8BDAD1">
                                <a href="{{ route('advertisements.create') }}">Create an advertisement</a>
                            </button>
                        </div>
                    </div>
                    <div class="card-body card-body-ad">
                        <div class="col-md-4">
                            @if (strpos($advertisement->photos, ', ') == false)
                                <div class="text-center">
                                    <img class="card-img-top" src="{{URL::asset('photos/').'/'.$advertisement->photos}}">
                                </div>
                            @else 
                                @foreach($array_photos as $array_photo)
                                    <div class="text-center">
                                        <img class="card-img-top" src="{{URL::asset('photos/').'/'.$array_photo}}">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    PRODUCT DETAILS
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Title : {{ $advertisement->title }}</li>
                                    <li class="list-group-item">Description : {{ $advertisement->description }}</li>
                                    <li class="list-group-item">Price : {{ $advertisement->price }} €</li>
                                    <li class="list-group-item">Created at : {{ $advertisement->created_at }}</li>
                                    <li class="list-group-item">Updated at : {{ $advertisement->updated_at }}</li>
                                </ul>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    SELLER DETAILS
                                </div>
                                <ul class="list-group list-group-flush">
                                    @foreach ($user as $row)
                                    <li class="list-group-item">Name : {{ $row->name }}</li>
                                    <li class="list-group-item">E-mail : {{ $row->email }}</li>
                                    <li class="list-group-item">City : {{ $row->city }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection