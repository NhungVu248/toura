@extends('admin.layouts.master')

@section('content')

<div class="container mx-auto px-6 py-8">

    <h1 class="text-2xl font-bold mb-6">
        Quản lý liên hệ
    </h1>

    {{-- SEARCH }}
    <form method="GET" class="flex gap-3 mb-6">

        <input
            type="text"
            name="q"
            placeholder="Tìm theo tên / email / phone"
            value="{{ request('q') }}"
            class="border p-2 rounded"
        >

        <select name="status" class="border p-2 rounded">

            <option value="">Trạng thái</option>

            <option value="new"
                {{ request('status')=='new'?'selected':'' }}>
                Mới
            </option>

            <option value="in_progress"
                {{ request('status')=='in_progress'?'selected':'' }}>
                Đang xử lý
            </option>

            <option value="replied"
                {{ request('status')=='replied'?'selected':'' }}>
                Đã trả lời
            </option>

            <option value="closed"
                {{ request('status')=='closed'?'selected':'' }}>
                Đã đóng
            </option>

        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Tìm
        </button>

    </form>


    {{-- TABLE --}}
    <table class="w-full border">

        <thead class="bg-gray-100">

            <tr>
                <th class="p-3 border">ID</th>
                <th class="p-3 border">Tên</th>
                <th class="p-3 border">Email</th>
                <th class="p-3 border">Phone</th>
                <th class="p-3 border">Status</th>
                <th class="p-3 border">Ngày gửi</th>
                <th class="p-3 border">Action</th>
            </tr>

        </thead>

        <tbody>

            @foreach($contacts as $contact)

            <tr>

                <td class="border p-2">
                    {{ $contact->id }}
                </td>

                <td class="border p-2">
                    {{ $contact->name }}
                </td>

                <td class="border p-2">
                    {{ $contact->email }}
                </td>

                <td class="border p-2">
                    {{ $contact->phone_number }}
                </td>

                <td class="border p-2">
                    {{ $contact->status }}
                </td>

                <td class="border p-2">
                    {{ $contact->created_at->format('d/m/Y H:i') }}
                </td>

                <td class="border p-2">

                    <a
                        href="{{ route('admin.contacts.show',$contact->id) }}"
                        class="text-blue-600"
                    >
                        Xem
                    </a>

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

    <div class="mt-6">
        {{ $contacts->links() }}
    </div>

</div>

@endsection