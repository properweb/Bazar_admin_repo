<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin</title>
    <link rel="stylesheet" href="{{asset('/public/css/vendors/simplebar.css')}}">
    <link href="{{asset('/public/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css">
    <link href="{{asset('/public/css/examples.css')}}" rel="stylesheet">

</head>
<body>
<div class="bg-light min-vh-100 d-flex flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card-group d-block d-md-flex row">
                    <div class="card col-md-7 p-4 mb-0">
                        <form method="post" action="">
                            @csrf
                        <div class="card-body login-card-body">
                            {{-- <h1>Login</h1>--}}
                            <div class="logo">
                                <img src="https://staging1.bazarcenter.ca/assets/images/bazar.svg" alt="" />
                            </div>
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="input-group mb-3">
                                <input class="form-control" id="email" name="email" type="text" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                            </div>
                            <div class="input-group mb-4">
                                <input class="form-control" id="password" name="password" type="password" placeholder="Password" required>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button class="btn btn-primary px-4" type="submit">Login</button>
                                </div>

                            </div>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
