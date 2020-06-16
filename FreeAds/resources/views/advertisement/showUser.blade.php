@extends('layouts.app')

@section('content')
<div class="container-main">
    @if(session()->has('info'))
        <div class="alert alert-success" role="alert">
            {{ session('info') }}
        </div>
    @endif
    <div class="card">
        <header class="card-header card-header-ad">
            <div class="card-header-main">
                <p class="card-header-title">My advertisements</p>
            </div>
            <div class="card-header-buttons">
                <button type="submit" class="btn" style="background-color:#8BDAD1">
                    <a href="{{ route('advertisements.create') }}">Create an advertisement</a>
                </button>
            </div>
        </header>
    </div>
    <div class="card-deck">
        @foreach($ads as $ad)
            <div class="card card_ads">
                @if (strpos($ad->photos, ', ') == false)
                    <div class="text-center">
                        <img class="card-img-top" src="{{URL::asset('photos/').'/'.$ad->photos}}">
                    </div>
                @else 
                    @foreach($array_photos as $array_photo)
                        <div class="text-center">
                            <img class="card-img-top" src="{{URL::asset('photos/').'/'.$array_photo}}">
                        </div>
                    @endforeach
                @endif
                <div class="card-body d-flex flex-column justify-content-end">
                    <h5 class="card-title">{{ $ad->title }}</h5>
                    <p class="card-text">
                        Price : {{ $ad->price }} € <br>
                        City : {{ $ad->city }}<br>
                        <div class="card-text-buttons">
                            <a class="button" href="{{ url('advertisements/'.$ad->id) }}"><div>{{ __('See') }}</div></a>
                            @if ($ad->user_id === Auth::id())
                                <a class="button button-edit" href="{{ url('advertisements/'.$ad->id.'/edit') }}"><div>{{ __('Edit') }}</div></a>
                                <form class="form-horizontal" method="POST" action="{{ url('advertisements/'.$ad->id) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn_delete"><div>{{ __('Delete') }}</div></button>
                                </form>
                            @endif
                        </div>
                    </p>
                </div>
                <div class="card-footer">
                <small class="text-muted">
                    Created at : {{ $ad->created_at }}<br>
                    Updated at : {{ $ad->updated_at }}<br>
                </small>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection