@extends('layouts.app')

@section('title', 'Admin Settings')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">Admin Settings</h1>
            <p class="text-slate-600 mt-1">Manage store details, support contact information, and M-Pesa integration values.</p>
        </div>
    </div>

    @if(session('status'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid gap-6 md:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-slate-900 mb-4">Store information</h2>
            <form method="POST" action="{{ route('admin.settings.save') }}">
                @csrf
                <div class="space-y-5">
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Store name</span>
                        <input type="text" name="store_name" value="{{ old('store_name', $settings['store_name']) }}" class="mt-1 block w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none" required>
                    </label>

                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Store tagline</span>
                        <input type="text" name="store_tagline" value="{{ old('store_tagline', $settings['store_tagline']) }}" class="mt-1 block w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none">
                    </label>

                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Support email</span>
                        <input type="email" name="support_email" value="{{ old('support_email', $settings['support_email']) }}" class="mt-1 block w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none">
                    </label>

                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Support phone</span>
                        <input type="text" name="support_phone" value="{{ old('support_phone', $settings['support_phone']) }}" class="mt-1 block w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none">
                    </label>
                </div>

                <button type="submit" class="mt-6 inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Save store settings</button>
            </form>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-slate-900 mb-4">M-Pesa integration</h2>
            <form method="POST" action="{{ route('admin.settings.save') }}">
                @csrf
                <div class="space-y-5">
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Paybill / Till</span>
                        <input type="text" name="mpesa_paybill" value="{{ old('mpesa_paybill', $settings['mpesa_paybill']) }}" class="mt-1 block w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none">
                    </label>

                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Short code</span>
                        <input type="text" name="mpesa_short_code" value="{{ old('mpesa_short_code', $settings['mpesa_short_code']) }}" class="mt-1 block w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none">
                    </label>

                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Callback URL</span>
                        <input type="url" name="mpesa_callback_url" value="{{ old('mpesa_callback_url', $settings['mpesa_callback_url']) }}" class="mt-1 block w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none">
                    </label>
                </div>

                <button type="submit" class="mt-6 inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Save M-Pesa settings</button>
            </form>
        </div>
    </div>
</div>
@endsection
