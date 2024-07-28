@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<style>
    .ellipsis-btn {
        border: none;
        background: none;
        font-size: 1.5rem;
        cursor: pointer;
    }
</style>
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
                                <a class="nav-item nav-link" href="/distributor"> Halaman utama</a>
                                <a class="nav-item nav-link active" href="/distributor/stock"> Stock</a>
                                <a class="nav-item nav-link active" href="/distributor/product"> Product</a>
                                <a class="nav-item nav-link active" href="/distributor/purchase-order">Purchase Order</a>    
                                <a class="nav-item nav-link active" href="/distributor/purchase-order/new">Tambah</a>                          
                            </div>
                        </div>
                    </nav>
                    <div class="row">
                        <div class="col-md-4">
                            Tambah Purchase Order
                        </div>
                    </div>
                    <div class="row mt-4">
                        <form action="#" id="frm-add-purchase-order" class="row g-3"> 
                            @csrf
                            <input type="hidden" id="distributor_id" value="{{ $user->id }}"/>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Produk</label>
                                    <div class="form-floating">
                                        <select class="form-control" name="product_id" id="product_id"> 
                                                <option value=""> -Pilih Produk- </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Qty</label>
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="qty" id="qty" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Harga</label>
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="price" id="price" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Keterangan</label>
                                <div class="form-floating">
                                   <textarea class="form-control" name="description" id="description"></textarea>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success btn-save">Simpan</button>
                                <button type="reset" class="btn btn-secondary btn-reset">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript">

    $(document).ready(function () {

        getProduct()

        $("#frm-add-purchase-order").on("submit", function(e){
            e.preventDefault()
            if($("#product_id").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Produk tidak boleh kosong !',
                });
                return 
            }

            if($("#qty").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Quantity tidak boleh kosong !',
                });
                return 
            }

            $.ajax({
                type: "POST",
                url: "/api/purchase-order",
                data: {
                    distributor_id : $("#distributor_id").val(),
                    product_id : $("#product_id option:selected").val(),
                    qty :  $("#qty").val(),
                    description : $("#description").val(),
                },
                dataType: "JSON",
                success: function (response) {
                    if(response.status == 200){
                        $.confirm({
                            title: 'Pesan ',
                            content: 'Data order behasil disampaikan !',
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        window.location.href = '/distributor/purchase-order'
                                    }
                                },
                            }
                        });
                    }
                }
            });
        })

        $("#product_id").on("change", function(e){
            e.preventDefault()
            var productId = this.value
            getPriceProduct(productId)
        })
    });

    function getProduct(){
        $.ajax({
            type: "GET",
            url: "/api/product",
            data : "data",
            dataType: "JSON",
            success: function (response) {
                $("#product_id").html("");
                var len = 0;

                if(response['data'] != null) {
                    len = response['data'].length
                    for(i = 0; i < len; i++) {
                        var selected = ""
                        var id = response['data'][i].id
                        var product_name = response['data'][i].product_name
                        var option = "<option value='"+id+"' "+selected+">"+product_name+"</option>";
                        $("#product_id").append(option);
                    }
                }
            }
        });
    }

    function getPriceProduct(product_id = null){
        $.ajax({
            type: "GET",
            url: "/api/product",
            data : {
                id : product_id
            },
            dataType: "JSON",
            success: function (response) {
                var data = response['data'][0]
                var price = parseInt(data.price).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })
                $("#price").val(price)
            }
        });
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>