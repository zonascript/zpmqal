@extends('auth.main')
@section('content')
  <div class="login_wrapper">
    <div id="register" class="animate form">
      <section class="login_content">
        <form>
          <h1>Create Account</h1>
          <div>
            <input type="text" class="form-control" placeholder="Username" required="" />
          </div>
          <div>
            <input type="email" class="form-control" placeholder="Email" required="" />
          </div>
          <div>
            <input type="password" class="form-control" placeholder="Password" required="" />
          </div>
          <div>
            <a class="btn btn-default submit" href="index.html">Submit</a>
          </div>

          <div class="clearfix"></div>

          <div class="separator">
            <p class="change_link">Already a member ?
              <a href="#signin" class="to_register"> Log in </a>
            </p>

            <div class="clearfix"></div>
            <br />

            <div>
              @include('auth.partials._footer')
            </div>
          </div>
        </form>
      </section>
    </div>
  </div>
@endsection