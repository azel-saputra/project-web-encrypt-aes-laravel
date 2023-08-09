<!-- app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>

    <style>
        table td{
      height: 120px;

    }
    body{margin-top:20px;}				              


    a:link {
    text-decoration: none;

    }
    a:link:hover{
    text-decoration: none;
    }

    a:visited{
    color: black
    }

    a:visited:hover{
    color: black
    }

    .container{
        margin-top: 20px;
    }

    .counter-box {
        display: block;
        background: #f6f6f6;
        padding: 40px 20px 37px;
        text-align: center
        
    }

    .counter-box p {
        margin: 5px 0 0;
        padding: 0;
        color: #909090;
        font-size: 18px;
        font-weight: 500
    }

    .counter-box i {
        font-size: 60px;
        margin: 0 0 15px;
        color: #d2d2d2
    }

    .counter { 
        display: block;
        font-size: 32px;
        font-weight: 700;
        color: #666;
        line-height: 28px
    }

    .counter-box.colored {
        background: #3acf87;
    }

    .counter-box.colored p,
    .counter-box.colored i,
    .counter-box.colored .counter {
        color: #fff
    }
  
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Tambahkan stylesheet Bootstrap di sini -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>
<body>

    <nav class="navbar navbar-inverse bg-dark">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand text-light"  href="#">Dashboard</a>
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
            <div class="my-3 p-3 bg-body rounded shadow-sm ">            
                <div class="container ">
                    <div class="row ">
                        <div class="d-flex justify-content-around">
                            <div class="four col-md-3">
                                <a class="dasboard" href="{{route('decrypt')}}">
                                    <div class="counter-box">
                                        <i class="fa"><img src="/image/shield.png" style="width: 70px"></i>
                                        <span class="counter">{{ $count }}</span>
                                        <p>Jumlah File Decrypt</p>
                                    </div>
                                </a>   
                            </div>
                        </div>
                  </div>	
                </div>
            </div>
            </main>
        
            
       
        </div>
    </div>
    <!-- Tambahkan script Bootstrap di sini (Opsional jika Anda ingin menggunakan fitur interaktif Bootstrap) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>

