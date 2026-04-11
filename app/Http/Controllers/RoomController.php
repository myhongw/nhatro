<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->price == 1) {
            $query->where('price', '<', 2000000);
        } elseif ($request->price == 2) {
            $query->whereBetween('price', [2000000, 5000000]);
        } elseif ($request->price == 3) {
            $query->where('price', '>', 5000000);
        }

        if ($request->sort === 'asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'desc') {
            $query->orderBy('price', 'desc');
        }

        $rooms = $query->paginate(9)->withQueryString();

        return view('rooms.index', compact('rooms'));
    }

    public function show(Room $room)
    {
        $room->load('images');

        return view('rooms.show', compact('room'));
    }

    public function adminIndex()
    {
        $rooms = Room::latest()->paginate(10);

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.form');
    }

    public function store(Request $request)
    {
        $validated = $this->validateRoom($request);

        $room = Room::create($this->buildRoomData($request, $validated));

        $this->syncDetailImages($request, $room);

        return response()->json([
            'success' => true,
            'message' => 'Thêm thành công!',
        ]);
    }

    public function edit(Room $room)
    {
        $room->load('images');

        return view('admin.rooms.form', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $this->validateRoom($request);

        $room->update($this->buildRoomData($request, $validated, $room));

        $this->syncDetailImages($request, $room);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thành công!',
        ]);
    }

    public function destroy(Request $request, Room $room)
    {
        $room->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Xóa thành công!',
            ]);
        }

        return back();
    }

    private function validateRoom(Request $request): array
    {
        $request->merge([
            'price' => str_replace(',', '', $request->price),
        ]);

        return $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'detail_images' => 'nullable|array|max:4',
            'detail_images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    }

    private function buildRoomData(Request $request, array $validated, ?Room $room = null): array
    {
        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('rooms', 'public');
        } elseif ($room) {
            $data['image'] = $room->image;
        }

        return $data;
    }

    private function syncDetailImages(Request $request, Room $room): void
    {
        if (!$request->hasFile('detail_images')) {
            return;
        }

        $room->images()->delete();

        foreach ($request->file('detail_images') as $detailImage) {
            $path = $detailImage->store('rooms/details', 'public');

            $room->images()->create([
                'image' => $path,
            ]);
        }
    }
}