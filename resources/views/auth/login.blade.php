<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POS System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .login-container { margin-top: 100px; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center login-container">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4>POS LOGIN</h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger p-2 small">{{ $errors->first() }}</div>
                    @endif

                    <form action="{{ url('/login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="admin@mail.com" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="******" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                    </form>
                </div>
                <div class="card-footer text-muted text-center">
                    <small>&copy; 2026 POS Bundling System</small>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>