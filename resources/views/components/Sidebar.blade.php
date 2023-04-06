<x-layout title="Sidebar">
<style>
.sidebar {
    height: 100vh;
}

.content {
    height: 70vh;
}
</style>

<div class=" sidebar bg-light border col-md-2">

<h3 class="text-primary text-center p-3">MyClass </h3>
<div class="content mt-5 ">
<a href="/dashboard" class="text-decoration-none"><h6 class="ms-5 text-primary "><i class="fas fa-book"></i> Dashboard</h6></a>
<a href="/sekolah" class="text-decoration-none"><h6 class="ms-5 mt-3 text-primary "><i class="fas fa-school"></i> Sekolah</h6></a>
</div>
<div class=" ms-5 d-flex">
<img src="images/blank_user.png"  class="rounded-circle " width="35px" alt=" profil "><a href="/logout" class="text-decoration-none"><h6 class="text-dark fst-italic fwt-light pt-2 ms-3">LOGOUT </h6></a></div>
</div>
</x-layout>