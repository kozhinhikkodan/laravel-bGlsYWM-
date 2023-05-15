<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        try {
            $users = User::all();
            return view('welcome', compact('users'));
        } catch (Exception $exception) {
            return response()->json(['message' => 'An error occurred.'], 500);
        }
    }


    public function search(Request $request)
    {
        try {
            // $users = User::all();
            $searchText = $request->input('search');
            $users = User::with('department', 'designation')->where(function ($query) use ($searchText) {
                $query->where('name', 'like', '%' . $searchText . '%')
                    ->orWhereHas('designation', function ($query) use ($searchText) {
                        $query->where('name', 'like', '%' . $searchText . '%');
                    })
                    ->orWhereHas('department', function ($query) use ($searchText) {
                        $query->where('name', 'like', '%' . $searchText . '%');
                    });
            })->get();

            return response()->json($users);
        } catch (Exception $exception) {
            return response()->json(['message' => 'An error occurred.'], 500);
        }
    }
}
