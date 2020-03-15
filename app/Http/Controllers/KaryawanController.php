<?php

namespace App\Http\Controllers;

use App\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
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
    public function create()
    {
        //
        return view('manajemen.karyawan.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $rules = [
            'no_identitas' => 'required|digits_between:1,20', 
            'nama' => 'required|max:50', 
            'tempat_lahir' => 'required|max:50', 
            'alamat' => 'required|max:100', 
            'no_hp' => 'required|digits_between:1,15', 
            'tgl_lahir' => 'required|date', 
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan', 
            
        ];
        $customMessages = [
            'no_identitas.max' => 'NIP maksimal 20 karakter', 
            'nama.max' => 'Nama maksimal 50 karakter', 
            'tempat_lahir.max' => 'Tempat Lahir maksimal 50 karakter', 
            'alamat.max' => 'Alamat maksimal 100 karakter', 
            'no_hp.max' => 'Nomor HP maksimal 15 digit',
            'no_identitas.digits_between' => 'NIP harus angka',
            'no_hp.digits_between' => 'Nomor HP harus angka',
            'jenis_kelamin.in' => 'Jenis Kelamin harus dipilih', 
        ];
        $this->validate($request, $rules, $customMessages);

        $karyawan = new Karyawan();
        $karyawan->no_identitas = $request->no_identitas;
        $karyawan->nama = $request->nama;
        $karyawan->tempat_lahir = $request->tempat_lahir;
        $karyawan->tgl_lahir = $request->tgl_lahir;
        $karyawan->no_hp = $request->no_hp;
        $karyawan->jenis_kelamin = $request->jenis_kelamin;
        $karyawan->alamat = $request->alamat;
        $karyawan->save();
        return redirect()->route('admin.karyawan')->with('success','Berhasil menambah data');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $karyawan = Karyawan::find($id);
        return view('manajemen.karyawan.show',compact('karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $karyawan = Karyawan::find($id);
        return view('manajemen.karyawan.edit',compact('karyawan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rules = [
            'no_identitas' => 'required|digits_between:1,20', 
            'nama' => 'required|max:50', 
            'tempat_lahir' => 'required|max:50', 
            'alamat' => 'required|max:100', 
            'no_hp' => 'required|digits_between:1,15', 
            'tgl_lahir' => 'required|date', 
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan', 
        ];
        $customMessages = [
            'no_identitas.max' => 'NIP maksimal 20 karakter', 
            'nama.max' => 'Nama maksimal 50 karakter', 
            'tempat_lahir.max' => 'Tempat Lahir maksimal 50 karakter', 
            'alamat.max' => 'Alamat maksimal 100 karakter', 
            'no_hp.max' => 'Nomor HP maksimal 15 digit',
            'no_identitas.digits_between' => 'NIP harus angka',
            'no_hp.digits_between' => 'Nomor HP harus angka', 
            'jenis_kelamin.in' => 'Jenis Kelamin harus dipilih', 
        ];
        $this->validate($request, $rules, $customMessages);
        $karyawan = Karyawan::find($id);
        $karyawan->no_identitas = $request->no_identitas;
        $karyawan->nama = $request->nama;
        $karyawan->tempat_lahir = $request->tempat_lahir;
        $karyawan->tgl_lahir = $request->tgl_lahir;
        $karyawan->no_hp = $request->no_hp;
        $karyawan->jenis_kelamin = $request->jenis_kelamin;
        $karyawan->alamat = $request->alamat;
        $karyawan->update();
        return redirect()->route('admin.karyawan')->with('success','Berhasil merubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $karyawan = Karyawan::find($id);
        $karyawan->delete();
        return redirect()->route('admin.karyawan')->with('success','Berhasil menghapus data');
    }

    public function res_teleg(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);
        $karyawan->id_telegram = Null;
        $karyawan->update();
        return redirect()->route('karyawan.edit',$karyawan->id)->with('success','Berhasil Reset Data Telegram');
    }
}
