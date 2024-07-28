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
                                <a class="nav-item nav-link" href="/distributor/purhcase-order">Purchase Order</a>
                                <a class="nav-item nav-link active" href="/distributor/purhcase-order/new">Tambah</a>                          
                            </div>
                        </div>
                    </nav>
                    <div class="row">
                        <div class="col-md-4">
                            Tambah Purchase Order 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mt-2">
                            <button type="button" class="btn btn-sm btn-primary btn-add">
                                Tambah
                            </button>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12 mt-2">
                            <div class="responsive">
                            <input type="hidden" name="distributor_id" id="distributor_id" value="{{ $user->id }}">
                                <table class="table table-hover" id="add-purchase-order-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Produk</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Total Harga</th>
                                            <th scope="col">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-purchase-order">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-success btn-save">Simpan</button>
                            <a href="/distributor/purhcase-order" class="btn btn-secondary">Batal</a>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript">

    var count, table, totalPrice, qty, price

    $(document).ready(function () {
        
        $("#tbody-purchase-order").on("click", '.delete-row',function(e){
            e.preventDefault()
            var rowId =  $(this).attr('id')
            $("#"+rowId+"").parent('td').parent('tr').remove(); 
        })

        $(".btn-add").on("click", function(e){
            e.preventDefault()
            let row = ""
            let head = ""
            count = $('#add-purchase-order-table tr').length
            row = `<tr>
                    <td>`+count+`</td>
                    <td> <select name='product_id[]' class='form-control product_id' id='product_id_`+count+`' style='width:100%;' data-id='`+count+`'> </select> </td> 
                    <td> <input type='number' min='0' name='qty[]' class='form-control qty' id='qty_`+ count +`' data-id='`+count+`'/> </td>
                    <td> <input type='number' min='0' 'name='price[]' class='form-control price' id='price_`+count+`' data-id='`+count+`' readonly/> </td>
                    <td> <input type='number' min='0' 'name='total_price[]' class='form-control total_price' id='total_price_`+count+`' data-id='`+count+`' readonly/> </td>
                    <td> <button type='button' class='btn btn-md btn-danger delete-row' id=`+count+`>Delete</button></td>    
                </tr>`
            $('#tbody-purchase-order').append(row)
            getProduct(null, count)
        })

        $(document).on('change', '.product_id', function() {
            var product_id = $(this).val()
            var rowId =  $(this).attr('data-id')
            calculateProductPrice(product_id, rowId)
        });

        $(document).on('keyup press', '.qty', function() {
            var rowId =  $(this).attr('data-id')
            qty = parseInt($(this).val())
            price = parseInt($("#price_"+rowId).val())
            totalPrice = qty * price
            $("#total_price_"+rowId).val(totalPrice)
        });

        // save
        $(".btn-save").on("click", function(e){
            e.preventDefault()
            
            let detailOrder = []
            $("#add-purchase-order-table tbody tr").each(function(index){
                let product_id = $(this).find('.product_id option:selected').val()
                qty = $(this).find('.qty').val()
                totalPrice = $(this).find('.total_price').val()
                detailOrder.push({
                    product_id : product_id,
                    qty : qty,
                    total_price : totalPrice
                })
            })
            let jsonDetailOrder = JSON.stringify(detailOrder)
            let data = {
                distributor_id : $("#distributor_id").val(),
                detail_order : detailOrder
            }
            $.ajax({
                type: "POST",
                url: "/api/",
                data: data,
                dataType: "JSON",
                success: function (response) {
                    console.log(response)
                    if(response.status == 200){
                        $.confirm({
                            title: 'Pesan ',
                            content: 'Data Purchase Order berhasil ditambahkan !',
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        window.location.href = '/distributor/purhcase-order'
                                    }
                                },
                            }
                        });
                    }
                }
            });
        })
    });

    function getProduct(product_id = null, counter = null){
        $.ajax({
            type: "GET",
            url: "/api/product",
            data : {
                id : product_id
            },
            dataType: "JSON",
            success: function (response) {
                $("#product_id_"+counter).html("");
                var len = 0;

                if(response['data'] != null) {
                    len = response['data'].length
                    for(i = 0; i < len; i++) {
                        var selected = ""
                        var id = response['data'][i].id
                        var product_name = response['data'][i].product_name

                        if(id == product_id){
                            selected = "selected"
                        }

                        var option = "<option value='"+id+"' "+selected+">"+product_name+"</option>";
                        $("#product_id_"+counter).append(option);
                    }
                }
            }
        });
    }

    function calculateProductPrice(product_id = null, rowId = null){
        $.ajax({
            type: "GET",
            url: "/api/product",
            data : {
                id : product_id
            },
            dataType: "JSON",
            success: function (response) {
                var data = response['data'][0]
                $("#price_"+rowId).val(data.price)
            }
        });
    }
    
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>