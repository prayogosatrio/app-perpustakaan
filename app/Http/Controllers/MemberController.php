<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private array $members = [
        ['id' => 1, 'nama' => 'Budi Santoso', 'nim' => '3125600001', 'email' => 'budi@student.pens.ac.id', 'nomor_telepon' => '081234567801', 'alamat' => 'Jl. Keputih No. 10, Surabaya', 'status' => 'aktif'],
        ['id' => 2, 'nama' => 'Siti Rahmawati', 'nim' => '3125600002', 'email' => 'siti@student.pens.ac.id', 'nomor_telepon' => '081234567802', 'alamat' => 'Jl. Mulyosari No. 5, Surabaya', 'status' => 'aktif'],
        ['id' => 3, 'nama' => 'Andi Pratama', 'nim' => '3125600003', 'email' => 'andi@student.pens.ac.id', 'nomor_telepon' => null, 'alamat' => null, 'status' => 'nonaktif'],
    ];

    public function index()
    {
        $members = $this->members;

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(StoreMemberRequest $request)
    {
        $validated = $request->validated();

        return redirect()->route('members.index')
            ->with('success', "Anggota \"{$validated['nama']}\" berhasil ditambahkan (data dummy, belum tersimpan ke database).");
    }

    public function show(string $id)
    {
        return "MemberController@show, id: {$id}";
    }

    public function edit(string $id)
    {
        return "MemberController@edit, id: {$id}";
    }

    public function update(Request $request, string $id)
    {
        return "MemberController@update, id: {$id}";
    }

    public function destroy(string $id)
    {
        return "MemberController@destroy, id: {$id}";
    }
}
