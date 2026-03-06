@extends('admin.layouts.master')

@section('content')

<div class="container mx-auto px-6 py-8 max-w-3xl">

    <h2 class="text-2xl font-bold mb-4">
        Chi tiết liên hệ #{{ $contact->id }}
    </h2>

    {{-- CONTACT INFO --}}
    <div class="border p-4 mb-6">

        <p><b>Tên:</b> {{ $contact->name }}</p>

        <p><b>Email:</b> {{ $contact->email }}</p>

        <p><b>Phone:</b> {{ $contact->phone_number }}</p>

        <p class="mt-3">
            <b>Nội dung:</b>
        </p>

        <p class="bg-gray-100 p-3 rounded">
            {!! nl2br(e($contact->message)) !!}
        </p>

    </div>


    {{-- ADMIN REPLY --}}
    <form
        action="{{ route('admin.contacts.reply',$contact->id) }}"
        method="POST"
    >
        @csrf

        <div class="mb-4">

            <label class="block mb-1 font-medium">
                Trạng thái
            </label>

            <select name="status" class="border p-2 w-full">

                <option value="in_progress"
                    {{ $contact->status=='in_progress'?'selected':'' }}>
                    Đang xử lý
                </option>

                <option value="replied"
                    {{ $contact->status=='replied'?'selected':'' }}>
                    Đã trả lời
                </option>

                <option value="closed"
                    {{ $contact->status=='closed'?'selected':'' }}>
                    Đóng
                </option>

            </select>

        </div>


        <div class="mb-4">

            <label class="block mb-1 font-medium">
                Nội dung phản hồi
            </label>

            <textarea
                name="admin_reply"
                rows="6"
                class="border p-3 w-full"
            >{{ old('admin_reply',$contact->admin_reply) }}</textarea>

        </div>


        <button class="bg-blue-600 text-white px-6 py-3 rounded">
            Gửi phản hồi
        </button>

    </form>

</div>

@endsection