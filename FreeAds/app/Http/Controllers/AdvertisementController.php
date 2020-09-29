<?php

namespace App\Http\Controllers;

use App\{Advertisement, User, Category};
use Illuminate\Http\Request;
use App\Http\Requests\Advertisement as AdvertisementRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Facades\Storage;
//use Intervention\Image\Facades\Image as InterventionImage;

class AdvertisementController extends Controller
{
    use SoftDeletes;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $params = null)
    {
        $categories = Category::all();
        $users = User::all();
        $user = User::findOrFail(Auth::id()); 
        $ads_cities = Advertisement::select('city')->distinct()->pluck('city');
        $array_photos = "";
        if (empty($params)) {
            $ads = Advertisement::all();
        } elseif ($params == 'latest') {
            $ads = Advertisement::orderBy('updated_at', 'desc')->get();
        } elseif ($params == 'custom') {
            $user_categories = User::leftJoin('category_user', 'users.id', '=', 'category_user.user_id')->rightJoin('categories', 'category_user.category_id', '=', 'categories.id')->where('users.id', Auth::id())->pluck('category_user.category_id');
            $user_city = User::where('id', '=', Auth::id())->pluck('city');
            $ads = Advertisement::whereIn('category_id', $user_categories)->where('user_id', '!=', $user->id)->get();
        } else if ($params == 'search') {
            $search_input = $request->get('search');
            $ads = Advertisement::where('title', 'like', "%$search_input%")
                ->orWhere('title', 'like', "$search_input%")
                ->orWhere('title', 'like', "%$search_input")
                ->get();
        }
        $ads_photos = Advertisement::select('photos')->get();
        foreach ($ads as $ad) {
            if (strpos($ad['photos'], ', ') === false) {
                $array_photos = $ad['photos'];
            } else {
                $array_photos = explode(', ', $ad['photos']);
            }
        }
        return view('advertisement/index', compact('ads', 'users', 'array_photos', 'params', 'categories', 'ads_cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('advertisement/create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertisementRequest $advertisementRequest)
    {
        $user = User::findOrFail(Auth::id());
        $ad = new Advertisement();
        $ad->title = $advertisementRequest->input('title');
        $ad->description = $advertisementRequest->input('description');
        $str_photo = "";
        foreach($advertisementRequest->file('photos') as $photo)
        {
            $path = $photo->store('photos');
            $str_photo .= basename($path . ', ');
        }
        $str_photos = substr($str_photo, 0, -2);
        $ad->photos = $str_photos;
        $ad->category_id = $advertisementRequest->input('category_id');
        $ad->price = $advertisementRequest->input('price');
        $ad->city = $user->city;
        $user->advertisements()->save($ad);
        return redirect()->route('advertisements.user', ['id' => Auth::id()])->with('info', 'Advertisement created !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Advertisement $advertisement)
    {
        if (strpos($advertisement->photos, ', ') === false) {
            $array_photos = $advertisement->photos;
        } else {
            $array_photos = explode(', ', $advertisement->photos);
        }
        $ad_id = $advertisement->id;
        $user = User::where('id', $advertisement['user_id'])->get();
        $ad_category = Advertisement::leftJoin('category_user', 'advertisements.category_id', '=', 'category_user.category_id')->join('categories', 'advertisements.category_id', '=', 'categories.id')->where('advertisements.id', $ad_id)->first()->name;
        return view('advertisement/show', compact('advertisement', 'user', 'array_photos', 'ad_category'));
    }

    public function showUser($id)
    {
        $ads = User::find($id)->advertisements()->orderBy('updated_at', 'desc')->get();
        $ads_photos = User::find($id)->advertisements()->select('photos')->get();
        foreach ($ads_photos as $photo) {
            if (strpos($photo, ', ') === false) {
                $array_photos = $photo['photos'];
            } else {
                $array_photos = explode(', ', $photo['photos']);
            }
        } 
        return view('advertisement/showUser', compact('ads', 'array_photos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ad = Advertisement::findOrFail($id);
        $categories_ad = Category::all();
        $ad_category = Advertisement::leftJoin('category_user', 'advertisements.category_id', '=', 'category_user.category_id')->join('categories', 'advertisements.category_id', '=', 'categories.id')->where('advertisements.id', $id)->first()->name;
        $ad_photos = Advertisement::select('photos')->get();
        foreach ($ad_photos as $photo) {
            if (strpos($photo, ', ') != false) {
                $array_photos = explode(', ', $photo['photos']);
            }
        } 
        return view('advertisement/update', compact('ad', 'categories', 'array_photos', 'ad_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ad = Advertisement::findOrFail($id);
        $array_inputs = $request->all();
        if ($request->filled('title')) {
            $validator = Validator::make($request->input('title'), [
                'title' => ['string', 'min:4', 'max:100'],
            ]);
        } else if ($request->filled('description')) {
            $validator = Validator::make($request->input('description'), [
                'description' => ['string', 'string', 'min:20', 'max:500'],
            ]);
        } else if ($request->filled('photos')) {
            $photos = count($request->file('photos'));
            foreach(range(0, $photos) as $index) {
                $rules['photos.' . $index] = 'image|mimes:jpg,jpeg,bmp,png|max:2000';
            }
            $validator = Validator::make($array_inputs, $rules);
            $str_photo = "";
            foreach($request->file('photos') as $photo)
            {
                $path = $photo->store('photos');
                $str_photo .= basename($path . ', ');
            }
            $str_photos = substr($str_photo, 0, -2);
            $array_inputs['photos'] = $str_photos;
        } else if ($request->filled('price')) {
            $validator = Validator::make($request->input('price'), [
                'price' => ['numeric', 'min:1', 'max:100000'],
            ]);
        } else if ($request->filled('category_id')) {
            $validator = Validator::make($request->category_id, [
                'category_id' => 'required',
            ]);
        }
        if (!isset($validator)) {
            return redirect('advertisements/'.$id.'/edit');
        }
        if ($validator->fails()) {
            return redirect('advertisements/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }
        if (empty($array_inputs['title'])) {
            $array_inputs['title'] = $ad->title;
        }
        if (empty($array_inputs['description'])) {
            $array_inputs['description'] = $ad->description;
        }
        if (empty($array_inputs['photos'])) {
            $array_inputs['photos'] = $ad->photos;
        }
        if (empty($array_inputs['price'])) {
            $array_inputs['price'] = $ad->price;
        }
        if (empty($array_inputs['category_id'])) {
            $array_inputs['category_id'] = $ad->category_id;
        }
        $ad->fill($array_inputs)->save();
        return redirect()->route('advertisements.update', ['advertisement' => $id])->with('info', 'Successfully modified !');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ad = Advertisement::findOrFail($id);
        $ad->delete();
        return redirect()->route('advertisements.user', ['id' => Auth::id()])->with('info', 'Ad successfully deleted !');    
    }

    public function filterAds(Request $request)
    {
        $users = User::all();
        $categories = Category::all();
        $ads_cities = Advertisement::select('city')->distinct()->pluck('city');
        $ads = Advertisement::leftJoin('category_user', 'advertisements.category_id', '=', 'category_user.category_id')->join('categories', 'advertisements.category_id', '=', 'categories.id')->get();
        $query = "";

        if ($request->filled('cats') && empty($request->min_price) && empty($request->max_price)) {
            $query = '1';
        } if ($request->filled('cities') && empty($request->min_price) && empty($request->max_price)) {
            $query = '2';
        } if ($request->filled('min_price') && $request->filled('max_price') && $request->missing('cats') && $request->missing('cities')) {
            $query = '3';
        } if ($request->filled('cats') && $request->filled('cities') && empty($request->min_price) && empty($request->max_price)) {
            $query = '4';
        } if ($request->filled('cats') && $request->filled('min_price') && $request->filled('max_price') && $request->missing('cities')) {
            $query = '5';
        } if ($request->filled('cities') && $request->filled('min_price') && $request->filled('max_price') && $request->missing('cats')) {
            $query = '6';
        } if ($request->filled('cities') && $request->filled('cats') && $request->filled('min_price') && $request->filled('max_price')) {
            $query = '7';
        }

        if ($request->filled('cats')) {
            $str_category = "";
            $categories_ad = $request->cats;
            foreach($categories_ad as $category) {
                $str_category .= $category . ', ';
            }
            $str_category = substr($str_category, 0, -2);
        }
        if ($request->filled('cities')) {
            $str_cities = "";
            $cities = $request->cities;
            foreach($cities as $city) {
                $str_cities .= $city . ', ';
            }
            $str_cities = substr($str_cities, 0, -2);
        }
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $min_price = $request->min_price;
            $max_price = $request->max_price;
        }
  
        if (isset($query) && $query === '1') {
            $ads = Advertisement::select('*')->leftJoin('category_user', 'advertisements.category_id', '=', 'category_user.category_id')->join('categories', 'advertisements.category_id', '=', 'categories.id')->whereIn('advertisements.category_id', $request->cats)->get();
        } elseif (isset($query) && $query === '2') {
            $ads = Advertisement::select('*')->leftJoin('category_user', 'advertisements.category_id', '=', 'category_user.category_id')->join('categories', 'advertisements.category_id', '=', 'categories.id')->whereIn('city', $request->cities)->get();
        } elseif (isset($query) && $query === '3') {
            $ads = Advertisement::select('*')->leftJoin('category_user', 'advertisements.category_id', '=', 'category_user.category_id')->join('categories', 'advertisements.category_id', '=', 'categories.id')->whereBetween('price', [$min_price, $max_price])->get();
        } elseif (isset($query) && $query === '4') {
            $ads = Advertisement::select('*')->leftJoin('category_user', 'advertisements.category_id', '=', 'category_user.category_id')->join('categories', 'advertisements.category_id', '=', 'categories.id')->whereIn('advertisements.category_id', $request->cats)->whereIn('city', $request->cities)->get();
        } elseif (isset($query) && $query === '5') {
            $ads = Advertisement::select('*')->leftJoin('category_user', 'advertisements.category_id', '=', 'category_user.category_id')->join('categories', 'advertisements.category_id', '=', 'categories.id')->whereIn('advertisements.category_id', $request->cats)->whereBetween('price', [$min_price, $max_price])->get();
        } elseif (isset($query) && $query === '6') {
            $ads = Advertisement::select('*')->leftJoin('category_user', 'advertisements.category_id', '=', 'category_user.category_id')->join('categories', 'advertisements.category_id', '=', 'categories.id')->whereIn('city', $request->cities)->whereBetween('price', [$min_price, $max_price])->get();
        } elseif (isset($query) && $query === '7') {
            $ads = Advertisement::select('*')->leftJoin('category_user', 'advertisements.category_id', '=', 'category_user.category_id')->join('categories', 'advertisements.category_id', '=', 'categories.id')->whereIn('advertisements.category_id', $request->cats)->whereIn('city', $request->cities)->whereBetween('price', [$min_price, $max_price])->get();
        } 

        $ads_photos = Advertisement::select('photos')->get();
        foreach ($ads_photos as $photo) {
            if (strpos($photo, ', ') != false) {
                $array_photos = explode(', ', $photo['photos']);
            }
        } 

        if (isset($ads)) {
            return view('advertisement/index', compact('ads', 'users', 'array_photos', 'categories', 'ads_cities'));
        } else {
            return view('advertisement/index', compact('ads', 'users', 'array_photos', 'categories', 'ads_cities'));
        }
    }
}
