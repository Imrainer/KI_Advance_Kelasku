<x-layout title="Sidebar">
<style>
.sidebar {
    height: 100vh;
    background-color:  rgb(63, 197, 146);
   
}

.button {
    background-color:  rgb(63, 197, 146);
    border: none;
   
}

.title {
  color: rgb(63, 197, 146);
}

.content {
    height: 70vh;
}

.profil[title] {
  position: relative;
  cursor: pointer;
}

.profil[title]:hover:after {
  content: attr(title);
  padding: 5px;
  color: #000000;
  background-color: #000;
  position: absolute;
  z-index: 999;
  left: 50%;
  transform: translateX(-50%);
}

</style>

<div class=" sidebar col-md-2">

<h3 class="text-light text-center p-3 ms-4">KelasKu  
   <svg width="60" height="60" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
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
  </svg> </h3>

<div class="content mt-5 ">
<a href="http://localhost/laravel/public/dashboard" class="text-decoration-none"><h6 class="text-light ms-5  "><i class="fas fa-book me-2"></i> Dashboard</h6></a>
<a href="http://localhost/laravel/public/sekolah" class="text-decoration-none"><h6 class="text-light ms-5 mt-4  "><i class="fas fa-school me-2"></i> Sekolah</h6></a>
</div>

<div class=" ms-5 d-flex">
    @if (empty(($photo)))
    <a><img src="{{ asset('storage/blank_user.png') }}" data-bs-toggle="modal" data-bs-target="#modalfotoblank" alt="Profile Picture" width="40px" class="profil rounded-circle"></a>
@else
<a><img src="{{ asset('storage/'.$photo) }}"  data-bs-toggle="modal" data-bs-target="#modalfoto" alt="Profile Picture" width="40px" class="profil rounded-circle"></a>
    @endif

    <div class="modal fade" id="modalfotoblank" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog rounded-circle">
        <div class="modal-content rounded-circle">
      <img src="{{ asset('storage/blank_user.png') }}" class="rounded-circle">
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalfoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog rounded-circle">
        <div class="modal-content rounded-circle">
          <img src="{{ asset('storage/'.$photo) }}" class="rounded-circle">
        </div>
      </div>
    </div>

    <div class="dropdown mt-1">
  <button class="button dropdown-toggle fst-italic" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    {{$name}}
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="http://localhost/laravel/public/profil">Edit Profile</a></li>
    <li><a href="http://localhost/laravel/public/logout" class="dropdown-item text-decoration-none"><h6 class="text-light fst-italic fwt-light pt-2 ms-3">Logout </h6></a></li>
  </ul>
</div>
</div>
</div>
</x-layout>