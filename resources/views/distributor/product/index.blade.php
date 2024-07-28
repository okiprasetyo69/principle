@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> Halaman Distributor </div>

                <div class="card-body">
                   
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <div class="navbar-nav">
                                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                                <a class="nav-item nav-link" href="/distributor"> Halaman utama</a>
                                <a class="nav-item nav-link active" href="/distributor/stock"> Stock</a>
                                <a class="nav-item nav-link active" href="/distributor/product"> Product</a>
                                <a class="nav-item nav-link" href="/distributor/purchase-order">Purchase Order</a>                          
                            </div>
                        </div>
                    </nav>
                    <div class="row">
                        <div class="col-md-4">
                            Monitor Stock  {{ $user->company_name }}
                        </div>
                    </div>
                    <form method="GET" action="{{ route('distributor.stock') }}"> 
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label> Cari Produk</label>
                                <input type="text" class="form-control" id="search_product" name="search_product" placeholder="Masukkan nama produk" autofocus />
                            </div>
                            <div class="col-md-2"> 
                                <button type="submit" class="btn btn-success mt-4" id="btn-search" style="border-radius:50px;"> <i class="bi bi-search"></i> Cari </button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-4" id="data-product">
                        
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-sm btn-primary btn-block" id="load-more">Load More</button>
                        </div>                   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript">
    
    var nextCursor, productName
    $(document).ready(function () {
        
        loadProduct();
     
        $('#load-more').click(function(e) {
            e.preventDefault()
            loadProduct(nextCursor);
        });

        $("#btn-search").on("click", function(e){
            e.preventDefault()
            productName = $("#search_product").val()
            if(productName != ''){
                $("#data-product").empty()
                loadProduct(null, productName)
            } else {
                $("#data-product").empty()
                loadProduct()
            }
            
        })
        
    });

    function loadProduct(cursor = null, productName= null){
        $.ajax({
            type: "GET",
            url: "/distributor/product/load-more",
            data: {
                cursor : cursor,
                product_name : productName
            },
            success: function (response) {
                nextCursor = response.next_cursor;
                var data = response.data
                var html = ""
                $.each(data, function (i, val) { 
                    html += `<div class="col-md-4">
                                <div class="card mt-2">
                                    <div class="card-body">
                                        <h5 class="card-title"> `+ val.product_name+` </h5>
                                        <h6 class="card-subtitle mb-2 text-muted"> `+val.title+` </h6>
                                        <p class="card-text">Kategori :  `+val.category.category_name+` </p>
                                        <a href="/distributor/`+val.product_name.toLowerCase()+`/`+val.id+`" class="card-link text-center">Detail</a>
                                    </div>
                                </div>
                            </div>`
                });
                $("#data-product").append(html)

                if (nextCursor == null) {
                    $('#load-more').hide();
                } else {
                    $('#load-more').show();
                }
            }
        });
    }

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>