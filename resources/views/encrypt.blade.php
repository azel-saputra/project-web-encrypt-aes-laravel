<!DOCTYPE html>
<html >
<head>
    <title>Encrypt File</title>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>
<body>

    <nav class="navbar navbar-inverse bg-dark">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand text-light"  href="#">Encrypt FIle</a>
          </div>
        </div>
      </nav>

      
    <!--sidebar-->
    <div class="d-flex" id="wrapper">
        <div class="border-end bg-white" id="sidebar-wrapper " style="width: 200px">
          <img src="image/encryption.png" class=" mx-auto d-block mt-3" style="width: 80px">
            <h3 class="mb-4 mt-4" style="text-align: center ">
              @if(Auth::check())
              <p>Hallo, {{ Auth::user()->name }}</p>
           @endif</h3>

            <a class=" h5 list-group-item list-group-item-action list-group-item-light p-3 border " href="{{route('dashboard')}}" style="text-align: center">Dashboard</a>

            <a class=" h5 list-group-item list-group-item-action list-group-item-light p-3 border " href="{{route('encrypt')}}" style="text-align: center">Encrypt File</a>
            <a class=" h5 list-group-item list-group-item-action list-group-item-light p-3 border " href="{{route('decrypt')}}" style="text-align: center">Decrypt File</a>

            <div >
              <!-- Authentication -->
              <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <a class=" h5 list-group-item list-group-item-action list-group-item-light p-3 border " style="text-align: center; color: red" href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                    <img src="/image/logout.png" style="width: 25px"> {{ __('Log Out') }}
                  </a>
              </form>
          </div>
          </div>

          <main class="container">   
            <div class="my-5 p-5 bg-body rounded shadow-sm">            
                <div class="container ">
                    <div class="row ">
                        <div class="d-flex justify-content-around">
                            <div class="four">
                                
                                <form action="{{ route('file.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @if (Session::has('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif
                                    <div class="row w-10">
                                        <div class="row mb-4 ">
                                            <div>
                                                <label for="file" class="form-label">Pilih File:</label>
                                                <input type="file" class="form-control" name="file" required>
                                            </div>
                                            
                                        </div>
                                        <div class="row mb-4 ">
                                            <div >
                                                <label for="deskripsi" class="form-label">Deskripsi:</label>
                                                <input type="text" class="form-control" name="deskripsi" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label for="encryption_key" class="form-label">Kunci Enkripsi:</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" name="encryption_key" id="encryption_key" required>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <input type="checkbox" id="show_password">
                                                            <label class="form-check-label" for="show_password">Show</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </form>
                            </div>
                        </div>
                  </div>	
                </div>
            </div>
            </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('show_password').addEventListener('change', function() {
            var passwordField = document.getElementById('encryption_key');
            if (this.checked) {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
        });
    </script>

    <script>
        // Menggunakan JavaScript untuk menampilkan nama file pada label input file
        var fileInput = document.getElementById('inputGroupFile01');
        var fileLabel = document.querySelector('.custom-file-label');
    
        fileInput.addEventListener('change', function () {
            var fileName = this.files[0].name;
            fileLabel.innerText = fileName;
        });
    </script>
</body>
</html>

