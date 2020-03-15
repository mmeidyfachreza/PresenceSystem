<?php

namespace App\Http\Controllers;

use App\Karyawan;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $karyawan = Karyawan::find($id);
        return view('manajemen.user.add',compact('karyawan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        //

        $rules = [
            'email' => 'required|max:50|email|unique:users',
            'password' => 'required|min:3',
            'role' => 'required|in:admin,karyawan',
        ];
        $customMessages = [
            'email.max' => 'Email maksimal 50 karakter',
            'email.unique' => 'Email sudah pernah digunakan',
            'password.min' => 'Passwowrd min 3 karakter',
            'role.in' => 'Role harus dipilih',

        ];
        $this->validate($request, $rules, $customMessages);
        $karyawan = Karyawan::find($id);
        $user = new User();
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->role = $request->role;
        $karyawan->user()->save($user);
        return redirect()->route('admin.user')->with('success','Berhasil Membuat User');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('manajemen.user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('manajemen.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $user = User::find($id);
        $rules = [
            'email' => 'required|max:50|email|unique:users,email,'.$user->id,
            'role' => 'required|in:admin,karyawan',

        ];
        $customMessages = [
            'email.max' => 'Email maksimal 50 karakter',
            'email.unique' => 'Email sudah pernah digunakan',
            'role.in' => 'Role harus dipilih',

        ];
        $this->validate($request, $rules, $customMessages);


        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->role = $request->role;
        $user->update();
        return redirect()->route('admin.user')->with('success','Berhasil Merubah Data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        if ($id==Auth::user()->id) {
            return back()->withErrors(['Tidak Bisa Menghapus Akun yang sedang digunakan']);
        }
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.user')->with('success','Berhasil menghapus data');
    }
}
