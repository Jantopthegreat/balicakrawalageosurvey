<x-mail::layout>
<x-slot:header>
<x-mail::header :url="config('app.url')">
<img src="{{ isset($message) ? $message->embed(public_path(config('cakrawala.brand.logo'))) : asset(config('cakrawala.brand.logo')) }}" alt="{{ config('cakrawala.brand.name') }}" width="120" style="width: 120px; max-width: 100%; height: auto;">
</x-mail::header>
</x-slot:header>

# {{ $greeting }}

@foreach ($introLines as $line)
{{ $line }}

@endforeach

<x-mail::button :url="$actionUrl">
{{ $actionText }}
</x-mail::button>

@foreach ($outroLines as $line)
{{ $line }}

@endforeach

Salam,<br>
{{ config('cakrawala.brand.name') }}

<x-slot:subcopy>
<x-mail::subcopy>
Jika tombol "{{ $actionText }}" tidak bisa dibuka, salin tautan berikut ke browser:
[{{ $actionUrl }}]({{ $actionUrl }})
</x-mail::subcopy>
</x-slot:subcopy>

<x-slot:footer>
<x-mail::footer>
&copy; {{ date('Y') }} {{ config('cakrawala.brand.name') }}. Hak cipta dilindungi.
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
