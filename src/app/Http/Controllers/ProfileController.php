<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function getMypage()
    {
        $firstLogin = Session::pull('first_login', false);

        $user = Auth::user();


        $sellItems = $user->items;

        $purchasedItems = $user->orders->map(function ($order) {
        return $order->item;
    });

        return view('profile', compact('user', 'sellItems', 'purchasedItems'));
    }


    public function getProfile()
    {
        $user = Auth::user();


        return view('profile-edit', compact('user'));
    }




    public function postProfile(ProfileRequest $request)
    {
        $user = Auth::user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        if ($request->hasFile('profile_image')) {
        $path = $request->file('profile_image')->store('profile_images', 'public');
        $profile->profile_image = $path;

        }

        $profile->name = $user->name;
        $profile->postal_code = $request->postal_code;
        $profile->address = $request->address;
        $profile->building = $request->building;


        $isProfileComplete = $profile->name;

        $profile->save();


        return redirect('/')->with('success', 'プロフィールを更新しました');
    }

}
