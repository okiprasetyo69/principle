@extends('layouts.home')
@section('title','Product')
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
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Management Inventory</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">
                    <a href="#">Inventory</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="#">Stock</a>
                </li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard"> 
        <div class="row">
            <div class="col-md-12"> 
                <div class="card">
                    <div class="card-body"> 
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row mt-4"> 
                            <div class="col-md-4">
                                Monitor Stock  {{ $user->company_name }}
                            </div>
                        </div>
                        <div class="row mt-4"> 
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-primary btn-add">
                                    Tambah
                                </button>
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
                                                <th scope="col">Aksi</th>
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

    </section>
</main>

<!-- Modal -->
<div class="modal fade" id="stockModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Stock</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <form action="#" id="frm-stock-distributor">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" class="form-control" />
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label> Nama Produk</label>
                            <select name="product_id" id="product_id" class="form-control"> 
                                <option value=""> </option>
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label> Qty</label>
                            <input type="number" min="0" name="qty" id="qty" class="form-control" />
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

<script type="text/javascript">
    var table, user_id, product_id

    $(document).ready(function () {
        user_id = $("#user_id").val()
        getStockDistributor(user_id)
        getProduct()
        $("#filter_product_id").on("change", function(e){
            e.preventDefault()
            product_id = $("#filter_product_id option:selected").val()
            getStockDistributor(user_id, product_id)
        })

        // Open Modal
        $(".btn-add").click(function(e){
            e.preventDefault()
            $("#stockModal").modal("show")
            $(".modal-title").text("Tambah Stock")
            $("#btn-save").text("Simpan")
            $("#id").val("")
            getProduct()
            $("#qty").val("")
        })
        
        // Close Modal
        $("#btn-close").click(function(e){
            e.preventDefault()
            $("#stockModal").modal("hide")
        })

        $("#frm-stock-distributor").on("submit", function(e){
            e.preventDefault()
            if($("#product_id option:selected").val() == ""){
                $.alert({
                    title: 'Pesan!',
                    content: 'Produk tidak boleh kosong !',
                });
                return 
            }
            if($("#qty").val() == ""){
                $.alert({
                    title: 'Pesan!',
                    content: 'Qty tidak boleh kosong !',
                });
                return 
            }
            $.ajax({
                type: "POST",
                url: "/api/distributor/stock",
                data: {
                    user_id : $("#user_id").val(),
                    id : $("#id").val(),
                    product_id : $("#product_id option:selected").val(),
                    qty : $("#qty").val()
                },
                dataType: "JSON",
                success: function (response) {
                    if(response.status == 200){
                        $.confirm({
                            title: 'Pesan ',
                            content: 'Data Stock Produk berhasil diperbarui !',
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        $("#stockModal").modal("hide")
                                        getStockDistributor(user_id)
                                    }
                                },
                            }
                        });
                    }
                }
            });
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
                    {
                        targets: 5,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {;
                            var html = `<div class="dropdown">
                                            <button class="ellipsis-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                &#x22EE;
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <button type="button" class="dropdown-item" onclick=detail(`+rowData.id+`)>Detail</button>
                                                <button type="button" class="dropdown-item" onclick=confirm(`+rowData.id+`)>Hapus</button>
                                            </div>
                                        </div>`
                            $(td).html(html);
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
                $("#filter_product_id").html("");
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
                        var optionForFilter = "<option value='"+id+"'>"+product_name+"</option>";
                        $("#product_id").append(option);
                        $("#filter_product_id").append(optionForFilter);
                    }
                }
            }
        });
    }

    function detail(id){
        $.ajax({
            type: "GET",
            url: "/api/stock/per-distributor",
            data: {
                id : id,
                user_id : $("#user_id").val()
            },
            dataType: "JSON",
            success: function (response) {
                let data = response.data[0]
                $("#stockModal").modal("show")
                $("#id").val(data.id)
                $("#qty").val(data.qty)
                getProduct(data.product_id)
                $("#btn-save").text("Ubah")
                $(".modal-title").text("Ubah Stock")
            }
        });
    }

    function confirm(id){
        $.confirm({
            title: 'Pesan ',
            content: 'Apa anda yakin akan menghapus data ini ?',
            buttons: {
                Ya: {
                    btnClass: 'btn-red any-other-class',
                    action: function(){
                        remove(id)
                    }
                },
                Batal: {
                    btnClass: 'btn-secondary',
                },
            }
        });
    }

    function remove(id){
        $.ajax({
            type: "DELETE",
            url: "/api/distributor/stock",
            data: {
                id : id,
            },
            dataType: "JSON",
            success: function (response) {
                if(response.status == 200){
                    $.confirm({
                        title: 'Pesan',
                        content: 'Data stock product berhasil dihapus !',
                        buttons: {
                            Ya: {
                                btnClass: 'btn-success any-other-class',
                                action: function(){
                                    getStockDistributor(user_id)
                                }
                            },
                        }
                    });
                }
            }
        });
    }

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
@endsection
@section('pagespecificscripts')
   
@stop