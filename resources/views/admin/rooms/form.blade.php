@extends('admin.layout')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">
            {{ isset($room) ? '✏️ Sửa phòng' : '➕ Thêm phòng' }}
        </h2>

        <a href="{{ route('admin.rooms.index') }}" class="text-gray-500 hover:text-black">
            ← Quay lại
        </a>
    </div>

    <div class="bg-white shadow-xl rounded-2xl p-6">
        <form id="room-form" enctype="multipart/form-data">
            @csrf
            @if(isset($room)) @method('PUT') @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div>
                    <label class="block mb-2 font-medium">Ảnh chính</label>

                    <img id="preview-image"
                        src="{{ isset($room) && $room->image ? asset('storage/'.$room->image) : 'https://via.placeholder.com/400x250' }}"
                        class="w-full h-48 object-cover rounded mb-2">

                    <input type="file" name="image" onchange="previewImage(event)" class="w-full border p-2 rounded">
                    <p class="text-red-500 text-sm error" data-error="image"></p>

                    <div class="mt-6">
                        <label class="block mb-2 font-medium">Ảnh chi tiết (tối đa 4 ảnh)</label>
                        <input type="file" name="detail_images[]" id="detail_images" multiple accept="image/*" class="w-full border p-2 rounded">
                        <p class="text-red-500 text-sm error" data-error="detail_images"></p>
                        <p class="text-red-500 text-sm error" data-error="detail_images.0"></p>

                        @if(isset($room) && $room->images->count())
                            <div class="grid grid-cols-2 gap-3 mt-4">
                                @foreach($room->images as $img)
                                    <img src="{{ asset('storage/'.$img->image) }}"
                                         class="w-full h-28 object-cover rounded border">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <div class="mb-3">
                        <label>Tên</label>
                        <input name="title" value="{{ $room->title ?? '' }}" class="w-full border p-2 rounded">
                        <p class="text-red-500 text-sm error" data-error="title"></p>
                    </div>

                    <div class="mb-3">
                        <label>Giá</label>
                        <input
                            name="price"
                            id="price"
                            value="{{ isset($room) && $room->price ? number_format($room->price) : '' }}"
                            class="w-full border p-2 rounded"
                        >
                        <p class="text-red-500 text-sm error" data-error="price"></p>
                    </div>
                    <div class="mb-3">
                        <label>Số điện thoại</label>
                        <input
                            name="phone"
                            value="{{ $room->phone ?? '' }}"
                            class="w-full border p-2 rounded"
                            placeholder="VD: 0901234567"
                        >
                        <p class="text-red-500 text-sm error" data-error="phone"></p>
                    </div>

                    <div class="mb-3">
                        <label>Địa chỉ</label>
                        <input name="address" value="{{ $room->address ?? '' }}" class="w-full border p-2 rounded">
                        <p class="text-red-500 text-sm error" data-error="address"></p>
                    </div>

                    <div class="mb-3">
                        <label>Mô tả</label>
                        <textarea name="description" class="w-full border p-2 rounded" rows="6">{{ $room->description ?? '' }}</textarea>
                    </div>
                </div>

            </div>

            <button class="mt-4 bg-blue-600 text-white px-6 py-2 rounded">
                {{ isset($room) ? 'Cập nhật' : 'Thêm phòng' }}
            </button>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function () {
        document.getElementById('preview-image').src = reader.result;
    };
    reader.readAsDataURL(file);
}

const priceInput = document.getElementById('price');

if (priceInput) {
    let rawInit = "{{ $room->price ?? '' }}";
    priceInput.dataset.raw = rawInit;

    priceInput.addEventListener('input', function(e) {
        let raw = e.target.value.replace(/\D/g, '');
        e.target.dataset.raw = raw;
        e.target.value = raw ? new Intl.NumberFormat('vi-VN').format(raw) : '';
    });
}

document.getElementById('room-form').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    formData.set('price', document.getElementById('price').dataset.raw || 0);

    const detailImages = document.getElementById('detail_images');
    if (detailImages && detailImages.files.length > 4) {
        alert('Chỉ được chọn tối đa 4 ảnh chi tiết');
        return;
    }

    document.querySelectorAll('.error').forEach(el => el.innerText = '');

    fetch("{{ isset($room) ? route('rooms.update', $room) : route('rooms.store') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        },
        body: formData
    })
    .then(async res => {
        let data = await res.json();
        if (!res.ok) throw data;
        return data;
    })
    .then(data => {
        alert(data.message || 'Thành công');
        window.location.href = "{{ route('admin.rooms.index') }}";
    })
    .catch(err => {
        if (err.errors) {
            for (let key in err.errors) {
                let el = document.querySelector(`[data-error="${key}"]`);
                if (el) el.innerText = err.errors[key][0];
            }
        } else {
            alert('Lỗi rồi');
        }
    });
});
</script>

@endsection