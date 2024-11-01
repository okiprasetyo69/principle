@component('mail::message')
# Purchase Order 

<h1> Hallo Principal !</h1>
<p> Selamat anda mendapatkan order dari Distributor {{ $user->name }} untuk produk {{ $product->product_name }} sebanyak {{ $qtyOrder }} </p>
<p> Harap untuk segera menghubungi {{ $user->phone_number }} untuk melakukan validasi </p>
Thanks,<br>

{{ config('app.name') }}
@endcomponent
