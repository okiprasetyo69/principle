<!DOCTYPE html>
<html>
<head>
    <title>Pemberitahuan</title>
</head>
<body>
    <h1>Halo, {{ $user->name }}</h1>
    <p> Produk {{ $product->product_name }} di distributor {{ $user->name }} tersisa 10 lagi. Harap segera untuk melakukan purchase order sebelum stok anda habis</p>
</body>
</html>
