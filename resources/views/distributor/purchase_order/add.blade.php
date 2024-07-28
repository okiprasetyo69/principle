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
                            Management Purchase Order
                        </div>
                    </div>

                    <div class="row mt-2" id="card-product">
                       
                        
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="purchaseOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <form action="#" id="frm-add-purchase-order">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="product_id" class="form-control" />
                    <input type="hidden" id="distributor_id" value="{{ $user->id }}"/>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label> Quantity</label>
                            <input type="number" class="form-control" name="qty" id="qty" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label> Keterangan </label>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn-close">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

<script type="text/javascript">

    $(document).ready(function () {

        getProduct()

         // Close Modal
         $("#btn-close").click(function(e){
            e.preventDefault()
            $("#purchaseOrderModal").modal("hide")
        })

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
                    product_id : $("#product_id").val(),
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

    
    });

    function getProduct(){
        $.ajax({
            type: "GET",
            url: "/api/product",
            data : "data",
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                $("#card-product").html("")
                var cardHtml = ""
                $.each(data, function (i, val) { 
                    console.log(val)
                    cardHtml += `<div class="col-md-4">
                            <div class="card">
                                <img class="card-img-top" src=`+ val.items[0].image_url +`>
                                <div class="card-body">
                                    <h5 class="card-title">`+ val.category.category_name+` - `+val.product_name+`</h5>
                                    <p class="card-text"> Harga : `+ val.price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) +` </p>
                                    <p class="card-text"> `+ val.items[0].description+` </p>
                                    <button type="button" class="btn btn-md btn-primary" onclick=orderNow(`+val.id+`)>Pesan Sekarang</button>
                                </div>
                            </div>
                        </div>`
                });
                $("#card-product").append(cardHtml)
              
            }
        });
    }

    function orderNow(id){
        $("#purchaseOrderModal").modal("show")
        $(".modal-title").text("Pesan")
        $("#btn-save").text("Checkout")
        $("#product_id").val(id)
    }

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>