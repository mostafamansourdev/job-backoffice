<?php

namespace App\Http\Controllers;

use App\Http\Requests\userUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->input('archive') == 'true') {
            $query->onlyTrashed();
        }

        $users = $query->paginate(10)->onEachSide(1);

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(userUpdateRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User Password updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', "User Deleted Successfully");
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('users.index', ['archive' => 'true'])->with('success', "User Restored Successfully");
    }
}
