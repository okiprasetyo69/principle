@component('mail::message')
# Distributor Notification

<h1>Halo, {{ $user->name }}</h1>
<p> Produk {{ $product->product_name }} anda tersisa 10 lagi. Harap segera untuk melakukan purchase order sebelum stok anda habis ! </p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
