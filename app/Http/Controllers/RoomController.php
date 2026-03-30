<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // USER VIEW + SEARCH
    public function index(Request $request)
    {
        $query = Room::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                ->orWhere('address', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->price == 1) {
            $query->where('price', '<', 2000000);
        }

        if ($request->price == 2) {
            $query->whereBetween('price', [2000000, 5000000]);
        }

        if ($request->price == 3) {
            $query->where('price', '>', 5000000);
        }

        if ($request->sort == 'asc') {
            $query->orderBy('price', 'asc');
        }

        if ($request->sort == 'desc') {
            $query->orderBy('price', 'desc');
        }

        $rooms = $query->paginate(9)->withQueryString();

        // 🔥 QUAN TRỌNG
        return view('rooms.index', compact('rooms'));
    }

    // ADMIN VIEW
    public function adminIndex()
    {
        $rooms = Room::latest()->paginate(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    // CREATE
    public function create()
    {
        return view('admin.rooms.form');
    }

    // STORE (AJAX + NORMAL)
    public function store(Request $request)
{
    // 🔥 FIX PRICE TRƯỚC
    $request->merge([
        'price' => str_replace(',', '', $request->price)
    ]);

    // ✅ VALIDATE SAU
    $request->validate([
        'title' => 'required',
        'price' => 'required|numeric',
        'address' => 'required',
        'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    $image = null;

    if ($request->hasFile('image')) {
        $image = $request->file('image')->store('rooms', 'public');
    }

    Room::create([
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price, // đã sạch
        'address' => $request->address,
        'image' => $image
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Thêm thành công!'
    ]);
}
    // EDIT
    public function edit(Room $room)
    {
        return view('admin.rooms.form', compact('room'));
    }

    // UPDATE
    public function update(Request $request, Room $room)
{
    $request->merge([
        'price' => str_replace(',', '', $request->price)
    ]);

    $request->validate([
        'title' => 'required',
        'price' => 'required|numeric',
        'address' => 'required',
        'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    $data = $request->only(['title', 'description', 'address', 'price']);

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('rooms', 'public');
    }

    $room->update($data);

    return response()->json([
        'success' => true,
        'message' => 'Cập nhật thành công!'
    ]);
}

    // DELETE
    public function destroy(Request $request, Room $room)
    {
        $room->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back();
    }
}