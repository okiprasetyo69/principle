@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('css/image-uploader.css') }}">

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
                                Management Product / Tambah
                            </div>
                        </div>

                        <div class="row">
                            <form action="#" id="frm-add-product" class="row g-3"> 
                                @csrf
                                <input type="hidden" id="id" name="id" />
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Nama Produk</label>
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Masukkan Nama Produk" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Kategori</label>
                                        <div class="form-floating">
                                            <select class="form-control" name="category_id" id="category_id"> 
                                                <option value=""> -Pilih Kategori- </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Harga</label>
                                    <div class="form-floating">
                                        <input type="number" min="0" class="form-control" name="price" id="price">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Qty</label>
                                    <div class="form-floating">
                                        <input type="number" min="0" class="form-control" name="qty" id="qty">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Judul</label>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="title" id="title">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Deskripsi</label>
                                    <div class="form-floating">
                                        <textarea class="form-control" name="description" id="description"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for=""> Foto Produk</label>
                                    <div class="input-images"></div>
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
</div>
@endsection


<script type="text/javascript">

    var imagName, category_id
    var product = <?php echo $product ?>

    $(document).ready(function () {
        // console.log(product)
        let preloaded = []
        let items = product.items

        // assign value
        $("#id").val(product.id)
        $("#product_name").val(product.product_name)
        $("#price").val(product.price)
        $("#qty").val(product.qty)
        $("#title").val(product.title)
        $("#description").val(product.description)

        $.each(items, function (i, val) { 
            preloaded.push({
                'id' : val.id,
                'src' : val.image_url
            })
        })

        $('.input-images').imageUploader({
            label: 'Drag & Drop files here or click to browse',
            preloaded: preloaded,
            imagesInputName: 'images',
            preloadedInputName: 'oldImages',
        });

        getCategory(product.category_id)

        // submit
        $("#frm-add-product").on("submit", function(e){
            e.preventDefault()
            if($("#product_name").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Nama Produk tidak boleh kosong !',
                });
                return 
            }
            if($("#price").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Harga tidak boleh kosong !',
                });
                return 
            }
            if($("#qty").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Quatity tidak boleh kosong !',
                });
                return 
            }

            $.ajax({
                type: "POST",
                url: "/api/product/update",
                data: new FormData(this),
                dataType: "JSON",
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    if(response.status == 200){
                        $.confirm({
                            title: 'Pesan ',
                            content: 'Data produk berhasil diperbarui !',
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        window.location.href = '/product'
                                    }
                                },
                            }
                        });
                    }
                }
            });
           
        })
    });

    function getCategory(category_id){
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
