<x-layout title="Sekolah">
    <div class="d-flex">
    <x-Sidebar  photo="{{$admin->foto}}" name="{{$admin->nama}}"></x-Sidebar>

    <!-- Modal -->
    <div class="modal fade" id="createsekolah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel"> Form Tambahkan Sekolah</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="http://localhost/laravel/public/create-store" method="POST">
              @csrf
  
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Sekolah</label>
                  <input type="text" class="form-control" name="sekolah" id="exampleInputEmail1">
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline-primary">Submit</button>
          </form>
          </div>
        </div>
      </div>
    </div>


    <div class=" col-md-10">

      @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
  @endif
    
  @foreach($errors->all() as $msg)
  <div class="alert alert-danger">{{$msg}}</div>
  @endforeach




  <div class="mt-5  ms-5 col-md-9 ">     

        <button data-bs-toggle="modal" data-bs-target="#createsekolah" class="btn btn-outline-success mb-1 mt-3"><i class="fas fa-school"></i>+ Add New</button>
        
        <form action="http://localhost/laravel/public/sekolah" method="GET" class="col-md-6 mt-3">
        <div class="mb-3 d-flex">
          <i class="fas fa-search mt-2 me-3"></i>
          <input type="search" name="search" class="form-control col-md-5"placeholder="Type here">
          <button class="btn btn-outline-success ms-3">Search</button>
        </div>
      </form>
        
        <table class="table">
            <thead>
              <tr>
                <th scope="col">No</th>    
                <th scope="col">Nama Sekolah</th>
                <th scope="col">Action</th>  
              </tr>
            </thead>
            <tbody>       
              @foreach ($data as $item)
              <tr>
                <th scope="row">{{$item->sekolah_id}}</th>
                <td>{{$item->sekolah}}</td>
                <td>
                <a href="http://localhost/laravel/public/editsekolah/{{$item->sekolah_id}}" class="me-1 fas fa-pen text-decoration-none text-primary"></a>
                <a href="http://localhost/laravel/public/deletesekolah/{{$item->sekolah_id}}" class="ms-1 fas fa-trash text-danger"></a>  
                <td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {{$data->links()}}
    </div>

    </div>
    </x-layout>