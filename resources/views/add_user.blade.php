<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Demo S3 AWS</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>
    <body class="antialiased">
        <div class="container" style="margin-top: 20px">
            <h3 class="text-center">Thêm mới thông tin người dùng ( Demo Laravel S3 )</h3>
            <br>
            <a class="btn-info btn" href="{{ route('list') }}" style="margin-left: 20%">
                Danh sách
            </a>
            <div class="row justify-content-center" style="margin-top: 20px">
                <form method="POST" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <label class="col-4">Tên người dùng:</label>
                        <div class="col-8">
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <label class="col-4">Email:</label>
                        <div class="col-8">
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <label class="col-4">Ảnh:</label>
                        <div class="col-8">
                            <input type="file" name="profile" class="form-control-file">
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="form-row justify-content-center">
                        <button class="btn-primary btn">
                            Thêm mới
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container" style="margin-top: 20px">
            @if($errors->any())
                <p class="text-center" style="color: red">{{ $errors->first() }}</p>
            @endif
        </div>
    </body>
</html>
