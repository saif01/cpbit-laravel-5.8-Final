@include('admin.layout.header')

  <!-- BEGIN : Body-->
  <body data-col="1-column" class=" 1-column  blank-page">
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">
      <div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
          <div class="content-wrapper">
<!--Login Page Starts-->
<section id="login">
  <div class="container-fluid">
    <div class="row full-height-vh m-0">
      <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="card">
          <div class="card-content">
            <div class="card-body login-img">
              <div class="row m-0">
                <div class="col-lg-6 d-lg-block d-none py-2 text-center align-middle">
                  <img src="app-assets/img/gallery/login.png" alt="" class="img-fluid mt-5" width="400" height="230">
                </div>
                <div class="col-lg-6 col-md-12 bg-white px-4 pt-3">
                  <h4 class="mb-2 card-title">Login</h4>
                  <p class="card-text mb-3">
                    Welcome back, please login to your account.
                  </p>
                   {{-- @if(isset(Auth::user()->email))
                        <script>window.location="/main/successlogin";</script>
                    @endif --}}

                    @if ($message = session()->get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif


                <form method="post" action="{{ route('admin.login.action') }}">
                        {{ csrf_field() }}
                  <input type="text" class="form-control mb-3" name="login" placeholder="Enter Login Id" required="required"/>
                  <input type="password" class="form-control mb-1" name="password" placeholder="Password" required="required"/>
                    <hr>
                    <div class="fg-actions d-flex justify-content-between">
                        <div class="recover-pass">
                       <button class="btn btn-raised gradient-pomegranate white big-shadow w-lg waves-effect waves-light" type="submit" name="submit">Log In</button>
                        </div>
                    </div>
                </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Login Page Ends-->

          </div>
        </div>
        <!-- END : End Main Content-->
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

  </body>
  <!-- END : Body-->
</html>
