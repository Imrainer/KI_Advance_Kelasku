<x-layout title="Login">

<style>
.icon{
  color: rgb(63, 197, 146);
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
@if (session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif

@if (session()->has('error'))
<div class="alert alert-danger">
    {{ session()->get('error') }}
</div>
@endif

@foreach($errors->all() as $msg)
  <div class="alert alert-danger">{{$msg}}</div>
  @endforeach

<div class="container mt-5 col-md-5 shadow-lg">
      <div class=" col-md-12">
    <form action="http://localhost/laravel/public/login" class="p-3" method="POST">
        @csrf
        <h1 class=" fw-bold ">KelasKu 
        <svg width="80" height="80" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
          <mask id="mask0_104_16" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="120" height="120">
          <rect width="120" height="120" fill="#326737"/>
          </mask>
          <g mask="url(#mask0_104_16)">
          <path d="M60 108L25 89V64L60 83L95 64V89L60 108Z" fill="#326737"/>
          </g>
          <mask id="mask1_104_16" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="120" height="120">
          <rect width="120" height="120" fill="#54A25C"/>
          </mask>
          <g mask="url(#mask1_104_16)">
          <path d="M105 85V50.5L60 75L5 45L60 15L115 45V85H105Z" fill="#54A25C"/>
          </g>
          </svg>
</h1>
         <h5 class="fst-roboto "> Sign in </h5>

        <div class="mb-3 d-flex col-md-10 mt-4">
          <i class="icon fas fa-phone mt-2 "></i>
            <input type="number" class="form-control  ms-3" name="nomor_telepon" id="exampleInputEmail1" placeholder="Masukkan Nomor Telepon">
          </div>
         
        <div class="mb-3 d-flex col-md-10 mt-5">
          <i class="icon fas fa-lock  mt-2 "></i>
          <input type="password" class="form-control ms-3" name="password" id="exampleInputPassword1"
          placeholder="Masukkan Password">
        </div>
       
        <div class="d-flex justify-content-center ">
        <button type="submit" class="button btn ">Login</button></div>
      </form>
</div>
</x-layout>