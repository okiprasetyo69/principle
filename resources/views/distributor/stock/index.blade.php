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
                                <a class="nav-item nav-link" href="/distributor/purchase-order">Purchase Order</a>                          
                            </div>
                        </div>
                    </nav>
                    <div class="row">
                        <div class="col-md-4">
                            Monitor Stock  {{ $user->company_name }}
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label> Cari Produk</label>
                            <select name="product_id" id="product_id" class="form-control"> 
                                <option value=""> - Pilih Produk -</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12 mt-2">
                            <div class="responsive">
                                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                                <table class="table table-hover" id="stock-distributor-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Produk</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript">
    var table, user_id, product_id

    $(document).ready(function () {
        user_id = $("#user_id").val()
        getStockDistributor(user_id)
        getProduct()
        $("#product_id").on("change", function(e){
            e.preventDefault()
            product_id = $("#product_id option:selected").val()
            getStockDistributor(user_id, product_id)
        })
    });

    function getStockDistributor(user_id, product_id = null){
        if (table != null) {
            table.destroy();
        }

        table =  $("#stock-distributor-table").DataTable(
           {
                lengthChange: false,
                searching: false,
                destroy: true,
                processing: true,
                serverSide: true,
                bAutoWidth: true,
                scrollCollapse : true,
                ordering: false,
                language: {
                emptyTable: "Data tidak tersedia",
                zeroRecords: "Tidak ada data yang ditemukan",
                infoFiltered: "",
                infoEmpty: "",
                paginate: {
                    previous: "‹",
                    next: "›",
                },
                info: "Menampilkan _START_ dari _END_ dari _TOTAL_ Produk",
                aria: {
                        paginate: {
                            previous: "Previous",
                            next: "Next",
                        },
                    },
                },
                ajax:{
                    url :  '/api/stock/per-distributor',
                    type: "GET",
                    data: {
                        user_id : user_id,
                        product_id: product_id,
                    }
                },
                columns: [
                    { data: null,  width: "5%",},
                    { data: null, },
                    { data: null },
                    { data: null },
                    { data: null },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).addClass("text-center");
                            $(td).html(table.page.info().start + row + 1);
                        },
                    },
                    {
                        targets: 1,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var product = ""
                            if(rowData.product_id != null){
                                product = rowData.product.product_name
                            } else {
                                product = "-"
                            }
                            $(td).html(product);
                        },
                    },
                    {
                        targets: 2,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var qty = 0
                            if(rowData.qty != null){
                                qty = rowData.qty.toLocaleString('id-ID')
                            }
                            $(td).html(qty);
                        },
                    },
                    {
                        targets: 3,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var price = 0
                            if(rowData.product_id != null){
                                price = parseInt(rowData.product.price)
                            }
                            $(td).html(price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
                        },
                    },
                    {
                        targets: 4,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var total_price = 0
                            if(rowData.total_price != null){
                                total_price = rowData.total_price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })
                            }
                            $(td).html(total_price);
                        },
                    },
                ]
           }
        )
    }

    function getProduct(product_id = null){
        $.ajax({
            type: "GET",
            url: "/api/product",
            data : "data",
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                $("#product_id").html("");
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
                        $("#product_id").append(option);
                    }
                }
            }
        });
    }

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>