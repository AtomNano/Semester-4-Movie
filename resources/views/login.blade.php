@extends ('layouts.template')

@section('content')
    <div class="container">
        <div class="row">
            <h1>Login User</h1>
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>{{ $errors->first('email') }}</strong> 
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
            
            @endif
            <form action="/login" method="post" class="row">
    @csrf
    <div class="form-floating mb-3">
        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating mb-3">
        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary mb-3">Login</button>
    </div>

</form>

            
        </div>
        
    </div>

@endsection