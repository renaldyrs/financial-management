<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(10);
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'role' => 'required',
        ]);

        // Create user first
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Create member associated with the user
        Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'user_id' => $user->id, // Assuming there's a user_id foreign key
        ]);

        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil ditambahkan');
    }

    public function show(Member $member)
    {
        $incomes = $member->incomes()->latest()->paginate(5);
        return view('members.show', compact('member', 'incomes'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,'.$member->id.'|unique:users,email,'.$member->user_id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'role' => 'sometimes|required', // Only required when present
        ]);

        // Update member
        $member->update($request->only(['name', 'email', 'phone', 'address']));

        // Update associated user
        if ($member->user) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            
            if ($request->filled('role')) {
                $userData['role'] = $request->role;
            }
            
            $member->user->update($userData);
        }

        return redirect()->route('members.index')
            ->with('success', 'Data anggota berhasil diperbarui');
    }

    public function destroy(Member $member)
    {
        // Delete associated user if exists
        if ($member->user) {
            $member->user->delete();
        }
        
        $member->delete();
        
        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil dihapus');
    }
}