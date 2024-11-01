@extends('layouts.home')
@section('title','List Distributor')
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
                                <a class="nav-item nav-link active" href="/category"> Category <span class="sr-only">(current)</span></a>
                                <a class="nav-item nav-link" href="/product">Product</a>
                                <a class="nav-item nav-link" href="/list-distributor">Distributor</a>
                                <a class="nav-item nav-link" href="/principal/stock">Stock</a>
                            </div>
                        </div>
                    </nav>

                    <div class="row">
                        <div class="col-md-4">
                            Management Distributor
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4">
                            <input type="text" name="search_distributor" class="form-control" id="search_distributor" placeholder="Cari distributor" autofocus/>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="responsive">
                                <table class="table table-hover" id="list-distributor-table">
                                    <thead>
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Distributor</th>
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
</div> -->

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Management Distributor</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">
                    <a href="#">Distributor</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="#">List Distributor</a>
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
                                <label> Cari Distributor </label>
                                <input type="text" name="search_distributor" class="form-control" id="search_distributor" placeholder="Masukkan kata kunci" autofocus/>
                            </div>
                        </div>
                        <div class="row mt-4"> 
                            <div class="col-md-12 mt-2">
                                <div class="responsive"> 
                                    <table class="table table-hover" id="list-distributor-table">
                                        <thead>
                                            <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nama Distributor</th>
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
<div class="modal fade" id="distributorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Distributor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label> Nama Distributor </label>
                        <input type="text" class="form-control" id="company_name" name="company_name" readonly />
                    </div>
                    <div class="col-md-12">
                        <label> Email </label>
                        <input type="text" class="form-control" id="email" name="email" readonly />
                    </div>
                    <div class="col-md-12">
                        <label> Telepon </label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" readonly />
                    </div>
                    <div class="col-md-12">
                        <label> Alamat </label>
                        <textarea class="form-control" id="address" name="address" readonly></textarea>
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
    var table,  company_name

    $(document).ready(function () {

        getDistributor()

        // Close Modal
        $("#btn-close").click(function(e){
            e.preventDefault()
            $("#distributorModal").modal("hide")
        })

        $("#search_distributor").on("keyup press", function(e){
            e.preventDefault()
            company_name = this.value
            getDistributor(company_name)
        })

    });

    function getDistributor(company_name = null){
        if (table != null) {
            table.destroy();
        }

        table =  $("#list-distributor-table").DataTable(
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
                    url :  '/api/user/distributor',
                    type: "GET",
                    data: {
                        company_name: company_name,
                    }
                },
                columns: [
                    { data: null,  width: "5%",},
                    { data: 'company_name', name: 'company_name', width: "70%", },
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
                            // var html = "<button type='button' class='btn btn-sm btn-warning' onclick='detail("+rowData.id+")' > Ubah </button> <button type='button' class='btn btn-sm btn-danger' onclick='confirm("+rowData.id+")'> Hapus </button>"
                            var html = `<div class="dropdown">
                                            <button class="ellipsis-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                &#x22EE;
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <button type="button" class="dropdown-item" onclick=detail(`+rowData.id+`)>Detail</button>
                                                <a class="dropdown-item" href="/distributor/stock/`+rowData.id+`" >Monitor Stock</a>
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
            url: "/api/user/distributor",
            data: {
                id : id
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data[0]
                console.log(data)
                $("#distributorModal").modal("show")
                $("#company_name").val(data.company_name)
                $("#email").val(data.email)
                $("#phone_number").val(data.phone_number)
                $("#address").val(data.address)
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