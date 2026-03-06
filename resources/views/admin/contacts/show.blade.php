@extends('admin.layouts.master')

@section('content')

<div class="container mx-auto px-6 py-8 max-w-5xl">

{{-- HEADER --}}
<div class="flex items-center justify-between mb-8">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Contact Detail
        </h1>

        <p class="text-gray-500 text-sm">
            Contact #{{ $contact->id }}
        </p>
    </div>

    <span class="px-4 py-2 rounded-full text-white text-sm font-medium
        {{ $contact->status == 'replied' ? 'bg-green-500' :
           ($contact->status == 'closed' ? 'bg-gray-500' : 'bg-yellow-500') }}">

        {{ ucfirst($contact->status ?? 'new') }}

    </span>

</div>


<div class="grid md:grid-cols-3 gap-6">

{{-- USER INFO --}}
<div class="bg-white shadow-lg rounded-xl p-6">

    <div class="flex items-center gap-4 mb-6">

        <div class="w-14 h-14 rounded-full bg-blue-500 text-white flex items-center justify-center text-xl font-bold">
            {{ strtoupper(substr($contact->name,0,1)) }}
        </div>

        <div>
            <div class="font-semibold text-lg">
                {{ $contact->name }}
            </div>

            <div class="text-gray-500 text-sm">
                Customer
            </div>
        </div>

    </div>


    <div class="space-y-4 text-gray-700">

        <div>
            <div class="text-sm text-gray-500">Email</div>
            <div>{{ $contact->email }}</div>
        </div>

        <div>
            <div class="text-sm text-gray-500">Phone</div>
            <div>{{ $contact->phone_number }}</div>
        </div>

        <div>
            <div class="text-sm text-gray-500">Sent at</div>
            <div>
                {{ $contact->created_at->format('d/m/Y H:i') }}
            </div>
        </div>

    </div>

</div>


{{-- MESSAGE --}}
<div class="md:col-span-2 bg-white shadow-lg rounded-xl p-6">

    <h3 class="text-lg font-semibold mb-4">
        Customer Message
    </h3>

    <div class="bg-gray-100 rounded-lg p-4 text-gray-700 leading-relaxed">

        {!! nl2br(e($contact->message)) !!}

    </div>

</div>

</div>


{{-- ADMIN REPLY --}}
<div class="bg-white shadow-lg rounded-xl p-6 mt-8">

<h3 class="text-lg font-semibold mb-6">
Admin Reply
</h3>

<form action="{{ route('admin.contacts.reply',$contact->id) }}" method="POST">

@csrf

<div class="grid md:grid-cols-2 gap-6">

<div>

<label class="block text-sm text-gray-600 mb-1">
Status
</label>

<select name="status"
class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500">

<option value="in_progress"
{{ $contact->status=='in_progress'?'selected':'' }}>
In Progress
</option>

<option value="replied"
{{ $contact->status=='replied'?'selected':'' }}>
Replied
</option>

<option value="closed"
{{ $contact->status=='closed'?'selected':'' }}>
Closed
</option>

</select>

</div>

</div>


<div class="mt-6">

<label class="block text-sm text-gray-600 mb-1">
Reply message
</label>

<textarea
name="admin_reply"
rows="6"
class="w-full border rounded-lg p-4 focus:ring-2 focus:ring-blue-500"
placeholder="Write your reply here..."
>{{ old('admin_reply',$contact->admin_reply) }}</textarea>

</div>


<div class="flex justify-between mt-8">

<a href="{{ route('admin.contacts.index') }}"
class="px-5 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">

← Back

</a>


<button
class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">

Send Reply

</button>

</div>

</form>

</div>

</div>

@endsection