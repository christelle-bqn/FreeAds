<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User, Category};
use App\Http\Requests\User as UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        return view('user/profile', compact('user', 'categories'));
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
