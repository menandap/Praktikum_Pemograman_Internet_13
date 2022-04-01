<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Account Admin</title>
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{URL::asset('assets/css/login.css')}}">
</head>
<body>
<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 px-0 d-none d-sm-block">
                <img src="{{URL::asset('assets/images/baner-right-image-03.jpg')}}" alt="login image" class="login-img">
            </div>
            <div class="col-sm-6 login-section-wrapper">
                <div class="brand-wrapper">
                    <h1>Hexa Shop</h1>
                </div>
                <div class="login-wrapper my-auto">
                    <h1 class="login-title">Create Account Admin</h1>
                    <form method="POST" action="{{ route('admin.register') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="username">username</label>
                            <input type="username" name="username" id="username" class="form-control @error('username') is-invalid @enderror" placeholder="username">
                            
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Your Name" required>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="enter your passsword">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="password-confirm">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="enter your password again">
                        </div>
                        <div class="form-group mb-4">
                            <label for="phone">Phone Number</label>
                            <input type="phone" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="enter your phone number">

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="profile_image">profile Image Number</label>
                            <input type="file" name="profile_image" id="profile_image" class="form-control @error('profile_image') is-invalid @enderror">

                            @error('profile_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-block login-btn"> {{ __('Register') }}</button>

                    </form>
            
                    <p class="login-wrapper-footer-text">Already have an account? <a href="{{route('admin.login')}}" class="text-reset">Sign in here</a></p>
                </div>
            </div>
        </div>
    </div>
</main>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
