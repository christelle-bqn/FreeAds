<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User, Category};
use App\Http\Requests\User as UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $userRequest)
    {
        /* User::create([
            'name' => $userRequest['name'],
            'email' => $userRequest['email'],
            'password' => Hash::make($userRequest['password']),
        ]); */

        $user = User::findOrFail(Auth::id());
        $user_categories = $user->categories()->count();
        if($user_categories == null) {
            $user->categories()->attach($userRequest->categories);
            return redirect('users/'.Auth::id())->with('info', 'Favorite categories added !');
        } else {
            $user->categories()->sync($userRequest->categories);
            return redirect('users/'.Auth::id())->with('info', 'Favorite categories updated !');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = Category::all();
        $user = User::findOrFail($id);
        $user_categories = User::leftJoin('category_user', 'users.id', '=', 'category_user.user_id')->rightJoin('categories', 'category_user.category_id', '=', 'categories.id')->where('users.id', $id)->pluck('categories.name');
        $array_categories = [];
        foreach($user_categories as $category) {
            array_push($array_categories, $category);
        }
        return view('user/profile', compact('user', 'categories', 'array_categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user/update', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $array_inputs = $request->all();
        /* $array_inputs = $request->all();
        if ($array_inputs['name'] != null) {
            $validator = Validator::make($array_inputs, [
                'name' => ['string', 'min:3', 'max:255'],
            ]);
        } else if ($array_inputs['city'] != null) {
            $validator = Validator::make($array_inputs, [
                'city' => ['string', 'min:3', 'max:255'],
            ]);
        } else if ($array_inputs['email'] != null) {
            $validator = Validator::make($array_inputs, [
                'email' => ['string', 'email', 'max:255', 'unique:users'],
            ]);
        }
        if ($validator->fails()) {
            return redirect('users/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }$*/
        if (empty($array_inputs['name'])) {
            $array_inputs['name'] = $user->name;
        }
        if (empty($array_inputs['email'])) {
            $array_inputs['email'] = $user->email;
        }
        if (empty($array_inputs['city'])) {
            $array_inputs['city'] = $user->city;
        }
        $user->fill($array_inputs)->save();
        return redirect()->route('users.update', ['user' => $id])->with('info', 'Successfully modified !');      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('register');
    }
}
