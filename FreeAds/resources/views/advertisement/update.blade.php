@extends('layouts.app')

@section('content')
<div class="container-main">
    <div class="row d-flex justify-content-around">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">{{ __('Edit advertisement') }}</div>

                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('advertisements.update', $ad->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        <input name="_method" type="hidden" value="PUT">

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" autocomplete="description">

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}</label>

                            <div class="col-md-6">
                                <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" autocomplete="price">

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="photo" class="col-md-4 col-form-label text-md-right">{{ __('Photos') }}</label>

                            <div class="col-md-6">
                                <input id="photos" type="file" class="form-control @error('photos') is-invalid @enderror" name="photos[]" value="{{ old('photos') }}" autocomplete="photos" multiple>
                                @error('photos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Categories') }}</label>

                            <div class="col-md-6 select">
                                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                    <option value="" disabled selected>Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn" style="background-color:#8BDAD1">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5 text-center">
            <div class="card">
                <div class="card-body">
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
                            Description : {{ $ad->description }} <br>
                            Price : {{ $ad->price }} € <br>
                            Category : {{ $ad_category }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
