@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('css/image-uploader.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.6.0/fabric.min.css" />

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
                                Management Product / Signature
                            </div>
                        </div>

                        <div class="row">
                            <form action="#" id="frm-add-signature" class="row g-3"> 
                                @csrf
                                <div class="row">
                                    <input type="text" name="id" value="{{ auth()->user()->id }}"/>
                                    <div class="col-md-6">
                                        <label for="">Dokter</label>
                                        <div class="canvas-container">
                                            <canvas id="canvas" width="250" height="200" style="border:1px solid #000;"></canvas>
                                            <input type="hidden" name="canvas" id="canvas-image" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Perawat</label>
                                        <div class="canvas-container">
                                            <canvas id="canvas2" width="250" height="200" style="border:1px solid #000;"></canvas>
                                            <input type="hidden" name="canvas2" id="canvas-image2" value="" />
                                        </div>
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
</div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/460/fabric.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {

        const canvas = new fabric.Canvas('canvas');
        const canvas2 = new fabric.Canvas('canvas2');
        var imageUrl = "{{ asset($url) }}"

        // console.log(imageUrl)

        if(imageUrl != ""){
            fabric.Image.fromURL(imageUrl, function(img) {
            // // Mengatur ukuran dan posisi gambar (opsional)
            // img.scale(0.5); // Mengubah skala gambar
            // img.set({
            //     left: 100, // Menentukan posisi kiri
            //     top: 100   // Menentukan posisi atas
            // });

            // Menambahkan gambar ke kanvas
            canvas.add(img);
            });
        }

        canvas.isDrawingMode = true;
        canvas.freeDrawingBrush.width = 5;
        canvas.freeDrawingBrush.color = "black";
        canvas.backgroundColor = "#ffffff";
        canvas.renderAll()

        canvas2.isDrawingMode = true;
        canvas2.freeDrawingBrush.width = 5;
        canvas2.freeDrawingBrush.color = "black";
        canvas2.backgroundColor = "#ffffff";
        canvas2.renderAll()

        $("#frm-add-signature").on("submit", function(e){
            e.preventDefault()

            var dataURL1 = canvas.toDataURL('image/png');
            var dataURL2 = canvas2.toDataURL('image/png');
            formData = new FormData(this);
            formData.append('canvas1', dataURL1);
            formData.append('canvas2', dataURL2);

            $.ajax({
                type: "POST",
                url: "/api/product/signature",
                data: formData,
                processData: false,
                contentType: false, 
                success: function (response) {
                    console.log(response)
                }
            });
        })
        
    });

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
