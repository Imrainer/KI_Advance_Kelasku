<x-layout title="Profil">
<x-navbar></x-navbar>

<style>

.title {
  color:  rgb(63, 197, 146);
  font-weight: bold
}

.button {
  background-color:  rgb(63, 197, 146);
  color: white;
}

.button:hover{
  background-color: white;
  outline:10px  rgb(63, 197, 146);
  color:  rgb(63, 197, 146);
}

</style>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class=" d-flex justify-content-center mt-5">
    @if (empty($data->foto))    
 <a>  <img src="{{ asset('storage/blank_user.png') }}"  alt="Profile Picture" width="300px" class="me-3 profil rounded-circle" data-bs-toggle="modal" data-bs-target="#exampleModal"></a>
    @else
    <a>  <img src="{{ asset('storage/'. $data->foto) }}" alt="Profile Picture" width="300px" class="me-3 profil rounded-circle" data-bs-toggle="modal" data-bs-target="#exampleModal"></a>
    @endif
<div class="ms-3">
    {{-- @foreach ( $user as $user) --}}
    <form action="http://localhost/laravel/public/editprofil-store" method="POST">
        @csrf @method('put')
        <div class="mb-3 mt-3">
            <label for="exampleInputEmail1" class="title form-label">Nama</label>
            <input type="text" class="form-control"  value="{{$data->nama}}" name="nama">
          </div>
        <div class="mb-3 mt-3">
          <label for="exampleInputEmail1" class="title form-label">Email </label>
          <input type="email" class="form-control" value="{{$data->email}}"name="email">
          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>

        <div class="mb-3 mt-3">
            <label for="exampleInputEmail1" class="title form-label">Nomor Telepon</label>
            <input type="number" class="form-control" value="{{$data->nomor_telepon}}" name="nomor_telepon">
          </div>
          
        <div class="d-flex justify-content-center">
        <button type="submit" class="button btn">Submit</button>
    </div> 
    {{-- @endforeach --}}
      </form>
   
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Foto Profil</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="http://localhost/laravel/public/editprofilpict" method="POST" enctype="multipart/form-data">
                @csrf @method('put')
            <div class="mb-3 mt-3">
                {{-- <label for="exampleInputEmail1" class="form-label">File</label> --}}
                <input type="file" class="form-control" name="foto">
              </div>
            <div class="d-flex justify-content-center mt-5">
             <button type="submit" class="btn btn-primary">Confirm</button>
            </div>
            </form>
        </div>
        
      </div>
    </div>
  </div>
</x-layout>