<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decrypt File</title>
    <!-- Tambahkan stylesheet Bootstrap di sini -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.min.css">

</head>
<body>

    <nav class="navbar navbar-inverse bg-dark">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand text-light"  href="#">Decrypt File</a>
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
                <h3 class="mb-4 mt-4" style="text-align: left ">Data Decrypt</h3>

                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-md-2">Nama File</th>
                            <th class="col-md-2">Deskripsi</th>
                            <th  class="col-md-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($file->count())
                        @foreach ($file as $index => $decrypt)
                        <tr>
                            <td>{{$decrypt->filename}}</td>
                            <td>{{$decrypt->deskripsi}}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#decryptModal{{ $decrypt->id }}">Decrypt</button>
                               
                                        
                                <a href="#" class="btn btn-danger" onclick="deleteData({{ $decrypt->id }})">Delete</a>
                            
                                <form id="delete-form-{{ $decrypt->id }}" action="{{ route('file.delete', $decrypt->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                
                            </td>
                        </tr>


                        <!-- Modal -->
                        <div class="modal fade" id="decryptModal{{ $decrypt->id }}" tabindex="-1" role="dialog" aria-labelledby="decryptModalLabel{{ $decrypt->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="decryptModalLabel{{ $decrypt->id }}">Decrypt File: {{ $decrypt->filename }}</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div >
                                            <label>File Name: </label>
                                            <label id="decryptModalLabel{{ $decrypt->id }}"> {{ $decrypt->filename }}</label>
                                        </div>  
                                        <div >
                                            <label>Description: </label>
                                            <label id="decryptModalLabel{{ $decrypt->id }}"> {{ $decrypt->deskripsi }}</label>
                                        </div>  
                                        <div >
                                            <label>Waktu Enkripsi: </label>
                                            <label id="decryptModalLabel{{ $decrypt->id }}"> {{ $decrypt->created_at }}</label>
                                        </div>  
                                        <div >
                                            <label>Size File: </label>
                                            <label id="decryptModalLabel{{ $decrypt->id }}"> {{ $decrypt->file_size }}</label>
                                            <label>Kb </label>

                                        </div>  
                                        <form id="decryption-form{{ $decrypt->id }}" action="{{ route('files.download', $decrypt->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="decryption-key{{ $decrypt->id }}" class="col-form-label">Decryption Key:</label>
                                                <input type="password" class="form-control" id="decryption-key{{ $decrypt->id }}" name="decryption_key" placeholder="Enter Decryption Key" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Decrypt and Download</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
          </main>


            
        </div>
    </div>

    

    <script>
        function deleteData(id) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Kamu akan menghapus file encrypt",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form untuk menghapus data
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
    
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.min.js"></script>
    <!-- Tambahkan script Bootstrap di sini (Opsional jika Anda ingin menggunakan fitur interaktif Bootstrap) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>

