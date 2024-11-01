@extends('layouts.home')
@section('title','Product')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

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
                            <div class="col-md-6">
                                <label> Cari Produk </label>
                                <select name="filter_product_id" id="filter_product_id" class="form-control"> 
                                    <option value=""> - Pilih Produk - </option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12 mt-2">
                                <div class="responsive"> 
                                    <table class="table table-hover" id="stock-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Produk</th>
                                                <th scope="col">Qty</th>
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

<div class="modal fade" id="stockModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Stock</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label> Cari Produk </label>
                        <select name="product_id" id="product_id" class="form-control"> 
                             <option value=""> - Pilih Produk - </option>
                        </select>
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

    var table
    $(document).ready(function () {
        getProduct()
    });

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
                        $("#product_id").append(option);
                        $("#filter_product_id").append(option);
                    }
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