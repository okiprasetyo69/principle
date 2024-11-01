@extends('layouts.home')
@section('title','Vendor')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
@section('content')

<!-- <div class="container">
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
                                <a class="nav-item nav-link active" href="/category"> Category </a>
                                <a class="nav-item nav-link" href="/product">Product</a>
                                <a class="nav-item nav-link" href="/list-distributor">Distributor</a>
                                <a class="nav-item nav-link" href="/principal/stock">Stock</a>
                            </div>
                        </div>
                    </nav>

                    <div class="row">
                        <div class="col-md-4">
                            Management Category
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-sm btn-primary btn-add">
                                Tambah
                            </button>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="search_category" class="form-control" id="search_category" placeholder="Masukkan kata kunci" />
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="responsive">
                                <table class="table table-hover" id="category-table">
                                    <thead>
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama Kategori</th>
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
</div> -->

<main id="main" class="main"> 
    <div class="pagetitle">
        <h1>Management Inventory</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">
                    <a href="#">Inventory</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="#">Kategori</a>
                </li>
            </ol>
        </nav>

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
                                    <button type="button" class="btn btn-sm btn-primary btn-add">
                                        Tambah
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="search_category" class="form-control" id="search_category" placeholder="Masukkan kata kunci" />
                                </div>
                            </div>
                            <div class="row mt-4"> 
                                <div class="col-md-12 mt-2">
                                    <div class="responsive">
                                        <table class="table table-hover" id="category-table">
                                            <thead>
                                                <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nama Kategori</th>
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
    </div>
</main>
<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <form action="#" id="frm-category">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" class="form-control" />
                    <div class="row">
                    <div class="col-md-12 mt-2">
                        <label> Nama Kategori</label>
                        <input type="text" class="form-control" name="category_name" id="category_name" />
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
    var table, category_name

    $(document).ready(function () {
        getCategory()
         // Open Modal
         $(".btn-add").click(function(e){
            e.preventDefault()
            $("#categoryModal").modal("show")
            $(".modal-title").text("Tambah kategori")
            $("#btn-save").text("Simpan")
            $("#id").val("")
            $("#category_name").val("")
        })
        
        // Close Modal
        $("#btn-close").click(function(e){
            e.preventDefault()
            $("#categoryModal").modal("hide")
        })

        $("#search_category").on("keyup press", function(e){
            e.preventDefault()
            category_name = this.value
            getCategory(category_name)
        })

        $("#frm-category").on("submit", function(e){
            e.preventDefault()
            if($("#name").val() == ""){
                $.alert({
                    title: 'Pesan!',
                    content: 'Nama kategori tidak boleh kosong !',
                });
                return 
            }

            $.ajax({
                type: "POST",
                url: "/api/category",
                data: {
                    id : $("#id").val(),
                    category_name : $("#category_name").val(),
                },
                dataType: "JSON",
                success: function (response) {
                    if(response.status == 200){
                        $.confirm({
                            title: 'Pesan ',
                            content: 'Data kategori berhasil diperbarui !',
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        $("#categoryModal").modal("hide")
                                        getCategory()
                                    }
                                },
                            }
                        });
                    }
                }
            });
        })
    });

    function getCategory(category_name = null){
        if (table != null) {
            table.destroy();
        }

        table =  $("#category-table").DataTable(
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
                    url :  '/api/category',
                    type: "GET",
                    data: {
                        category_name: category_name,
                    }
                },
                columns: [
                    { data: null,  width: "5%",},
                    { data: 'category_name', name: 'category_name', width: "70%", },
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
                        targets: 2,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var html = "<button type='button' class='btn btn-sm btn-warning' onclick='detail("+rowData.id+")' > Ubah </button> <button type='button' class='btn btn-sm btn-danger' onclick='confirm("+rowData.id+")'> Hapus </button>"
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
            url: "/api/category",
            data: {
                id : id
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data[0]
                console.log(data)
                $("#categoryModal").modal("show")
                $(".modal-title").text("Ubah kategori")
                $("#btn-save").text("Ubah")
                $("#id").val(data.id)
                $("#category_name").val(data.category_name)
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
            url: "/api/category",
            data: {
                id : id,
            },
            dataType: "JSON",
            success: function (response) {
                if(response.status == 200){
                    $.confirm({
                        title: 'Pesan',
                        content: 'Data kategori berhasil dihapus !',
                        buttons: {
                            Ya: {
                                btnClass: 'btn-success any-other-class',
                                action: function(){
                                    getCategory()
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