<x-layout title="Login">
   
    <div class="container mt-5 col-md-5 shadow-lg">
    <form action="login" class="p-3" method="POST">
        @csrf
        <h1 class="fw-bold">Form Login </h1>
        
        <div class="mb-3 d-flex col-md-10 mt-5">
          <i class="fas fa-phone mt-2 text-primary"></i>
            <input type="number" class="form-control  ms-3" name="nomor_telepon" id="exampleInputEmail1">
          </div>
         
        <div class="mb-3 d-flex col-md-10 mt-5">
          <i class="fas fa-lock  mt-2 text-primary"></i>
          <input type="password" class="form-control ms-3" name="password" id="exampleInputPassword1">
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <div class="d-flex justify-content-center ">
        <button type="submit" class="btn btn-outline-primary">Submit</button></div>
      </form>
</div>
</x-layout>