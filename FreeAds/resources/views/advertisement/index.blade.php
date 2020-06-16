@extends('layouts.app')

@section('content')
<div class="container-main">
    <div class="card">
        <header class="card-header card-header-ad">
            <div class="card-header-main">
                <p class="card-header-title">
                    @if (empty($params))
                        {{ __('All advertisements') }}
                    @elseif ($params == 'latest')
                        {{ __('Latest advertisements') }}
                    @elseif ($params == 'custom')
                        {{ __('Custom advertisements') }}
                    @elseif ($params == 'search')
                    {{ __('Search advertisements') }}
                    @endif
                </p>
                <select class="card-header-select" onchange="window.location.href = this.value">
                    <option value="">{{ __('Selection options') }}</option>
                    <option value="{{ route('advertisements.index') }}">{{ __('All advertisements') }}</option>
                    <option value="{{ route('advertisements.index', 'latest') }}">{{ __('Latest advertisements') }}</option>
                    <option value="{{ route('advertisements.index', 'custom') }}">{{ __('Custom advertisements') }}</option>
                </select>
                <div class="card-header-search">
                    <form method="POST" role="search" action="{{ route('advertisements.index', 'search') }}">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search advertisements">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-header-buttons">
                <a class="button" href="{{ route('advertisements.user', ['id' => Auth::id()]) }}"><div>{{ __('My advertisements') }}</div></a>
                <a class="button" href="{{ route('advertisements.create') }}"><div>{{ __('Create an advertisement') }}</div></a>
            </div>
        </header>
        <section id="wrapper_search">
                <form method="POST" action="{{ route('advertisements.filter') }}">
                {{ csrf_field() }}
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label text-md-right">{{ __('Categories') }}</label>
                        <div class="col-md-4 select is-multiple">
                            <select name="cats[]" multiple>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ in_array($category->id, old('cats') ?: []) ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="city" class="col-md-2 col-form-label text-md-right">{{ __('Cities') }}</label>
                        <div class="col-md-4 select is-multiple">
                            <select name="cities[]" multiple>
                                @foreach($ads_cities as $city)
                                    <option value="{{ $city }}">{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label text-md-right">{{ __('Price') }}</label>
                        <div class="col-md-2">
                            <input type="number" id="min_price" name="min_price" class="form-control" placeholder="Min Price">
                            <input type="number" id="max_price" name="max_price" class="form-control" placeholder="Max Price">
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-2">
                            <button type="submit" class="btn btn_search">
                                <div>{{ __('Search') }}</div>
                            </button>
                        </div>
                    </div>
                </form>
        </section>
    </div>
    <div class="card-deck">
        @if (count($ads) == 0)
            <div class="card card_ads">
                <h6>NO ADVERTISEMENTS FOUND !</h6> 
            </div>
        @else
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
                        </p>
                        <div>
                            <a class="button" href="{{ url('advertisements/'.$ad->id) }}"><div>{{ __('See') }}</div></a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                            Created at : {{ $ad->created_at }}<br>
                            Updated at : {{ $ad->updated_at }}<br>
                        </small>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection