<!DOCTYPE html>
<html>

<head>
  <title>Login Restoran Digital</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/gh/agoenxz2186/submitAjax@develop/submit_ajax.js">
  </script>
  <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

  <meta name="viewport" content="with=device-with, initial-scale=1">

</head>

<body>
  <div class="vh-100 d-flex justify-content-center align-items-center">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
          <div class="card bg-white">
            <div class="card-body p-5">
              <form id="form-login" method="post" action="<?= base_url('/login') ?>" class="mb-3 mt-md-4">
                <h2 class="fw-bold mb-2 text-uppercase ">Restoran Aroma Pontianak</h2>
                <p class=" mb-5">Please enter your login and password!</p>
                <div class="mb-3">
                  <label for="email" class="form-label ">Email address</label>
                  <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                  <label for="sandi" class="form-label ">Password</label>
                  <input type="password" name="sandi"  class="form-control" id="sandi" placeholder="*******">
                </div>
                <p class="small"><a class="text-primary" href="<?=base_url('/login/lupa') ?>">Forgot password?</a></p>
                <div class="d-grid">
                  <button class="btn btn-outline-dark" type="submit">Login</button>
                </div>
              </form>
              <div>
                <p class="mb-0  text-center">Don't have an account? <a href="signup.html" class="text-primary fw-bold">Sign
                    Up</a></p>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script>
        $(document).ready(function(){
            $('form#form-login').submitAjax({
                pre:()=>{
                    $('form#form-login button[type=submit]').hide();
                },
                pasca:()=>{
                    $('form#form-login button[type=submit]').show();
                },
                success:(response, status)=>{
                    var js = $.parseJSON(response);
                    alert(js.message);
                    window.location = "<?=url_to('user')?>";
                },
                error: (xhr, status)=>{
                    var json = $.parseJSON(   xhr.responseText  );
                    alert(json.message);
                }
            });
        });
    </script>
</html>