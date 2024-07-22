@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('css/image-uploader.css') }}">
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
<script src="{{ asset('js/image-uploader.js') }}"></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> Halaman Prinsipal </div>
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
                                    <a class="nav-item nav-link" href="/category"> Category </a>
                                    <a class="nav-item nav-link active" href="/product">Product</a>
                                    <a class="nav-item nav-link" href="/list-distributor">Distributor</a>
                                </div>
                            </div>
                        </nav>
                    
                        <div class="row">
                            <div class="col-md-4">
                                Management Product
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-sm btn-primary btn-add">
                                    Tambah
                                </button>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="filter_product_name" id="filter_product_name" placeholder="Masukkan nama produk" autofocus/>
                            </div>
                            <!-- <div class="col-md-4">
                                <select name="category_id" id="category_id" class="form-control"> 
                                    <option value=""> -Pilih Kategori-</option>
                                </selet>
                            </div> -->
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12 mt-2">
                                <div class="responsive">
                                    <table class="table table-hover" id="product-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Kategori</th>
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
    </div>
</div>
@endsection


<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label> Judul </label>
                        <input type="text" class="form-control" id="title" name="title" readonly />
                    </div>
                    <div class="col-md-12">
                        <label> Deskripsi </label>
                        <textarea class="form-control" id="description" name="description" readonly></textarea>
                    </div>
                    <div class="col-md-12" id="col-lbl-product">
                        <label> Foto Produk </label>
                    </div>
                    <div class="col-md-12" id="list-photo-product">
                       
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn-close">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var table, product_name, distributor_id

    $(document).ready(function () {
        loadProduct()
        // getCategory()

        $(".btn-add").on("click", function(e){
            e.preventDefault()
            window.location.href = '/product/new'
        })


        // Close Modal
        $("#btn-close").click(function(e){
            e.preventDefault()
            $("#productModal").modal("hide")
        })

        $("#filter_product_name").on("keyup press", function(e){
            e.preventDefault()
            product_name = this.value
            loadProduct(product_name, null)
        })

       
    });

    function loadProduct(product_name = null, category_id=null){
        if (table != null) {
            table.destroy();
        }

        table =  $("#product-table").DataTable(
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
                info: "Menampilkan _START_ dari _END_ dari _TOTAL_ Kategori",
                aria: {
                        paginate: {
                            previous: "Previous",
                            next: "Next",
                        },
                    },
                },
                ajax:{
                    url :  '/api/product',
                    type: "GET",
                    data: {
                        product_name: product_name,
                        category_id : category_id
                    }
                },
                columns: [
                    { data: null,  width: "5%",},
                    { data: null},
                    { data: null },
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
                            var categoryName = ""
                            if(rowData.category_id != null){
                                categoryName = rowData.category.category_name
                            } else {
                                categoryName = "-"
                            }
                            $(td).html(categoryName);
                        },
                    },
                    {
                        targets: 2,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                           var productName = ""
                           if(rowData.product_name != ""){
                               productName = rowData.product_name
                           } else {
                            productName = "-"
                           }
                           $(td).html(productName)
                        },
                    },
                    {
                        targets: 3,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var qty = 0
                            if(rowData.qty != null){
                                qty = rowData.qty
                            } 
                            $(td).html(qty.toLocaleString('id-ID'));
                        },
                    },
                    {
                        targets: 4,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var price = 0
                            if(rowData.price != null){
                                price = rowData.price
                            } 
                            $(td).html(price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
                        },
                    },
                    {
                        targets: 5,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var total = 0
                            if(rowData.total_price != null){
                                total = rowData.total_price
                            } 
                            $(td).html(total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
                        },
                    },
                    {
                        targets: 6,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var html = `<div class="dropdown">
                                            <button class="ellipsis-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                &#x22EE;
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <button type="button" class="dropdown-item" onclick=detail(`+rowData.id+`)>Detail</button>
                                                <a class="dropdown-item" href="/product/`+rowData.id+`" >Ubah</a>
                                                <button type="button" class="dropdown-item" onclick=confirm(`+rowData.id+`)>Delete</a>
                                            </div>
                                        </div>`
                            $(td).html(html);
                        },
                    },
                ]
           }
        )
    }

    function detail(id){
        $.ajax({
            type: "GET",
            url: "/api/product",
            data: {
                id : id
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data[0]
                var items = data.items
                var html = ""
                $("#productModal").modal("show")
                $("#title").val(data.title)
                $("#description").val(data.description) 
                $("#list-photo-product").html("")
                if(items.length != 0){
                    $.each(items, function (i, val) { 
                        html += ` <img id="preview_product_image_`+i+`" src="`+val.image_url+`"  class="rounded mb-4" style="height: 150px; width: 250px;"/>`
                    });
                    $("#list-photo-product").html(html)
                } else {
                    $("#col-lbl-product").hide()
                    $("#list-photo-product").hide()
                }
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
            url: "/api/product",
            data : {
                id : id
            },
            dataType: "JSON",
            success: function (response) {
                if(response.status == 200){
                    $.confirm({
                        title: 'Pesan',
                        content: 'Data produk berhasil dihapus !',
                        buttons: {
                            Ya: {
                                btnClass: 'btn-success any-other-class',
                                action: function(){
                                    loadProduct()
                                }
                            },
                        }
                    });
                }
            }
        });
    }

    function getCategory(){
        $.ajax({
            type: "GET",
            url: "/api/category",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                $("#category_id").html("");
                var len = 0;
                if(response['data'] != null) {
                    len = response['data'].length
                    for(i = 0; i < len; i++) {
                        var selected = ""
                        var id = response['data'][i].id
                        var category_name = response['data'][i].category_name
                        if(id == category_id){
                            selected = "selected"
                        }
                        var option = "<option value='"+id+"' "+selected+">"+category_name+"</option>";
                        $("#category_id").append(option);
                    }
                }
            }
        });
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
