<x-layout title="Add New">
   
    <div class="container col-md-5">
    <form action="http://localhost/laravel/public/editstore/{{$data->sekolah_id}}" method="POST">
      @csrf @method('put')
        <h1>Form Edit Sekolah </h1>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">sekolah</label>
          <input type="text" class="form-control" value="{{$data->sekolah}}" name="sekolah" id="exampleInputEmail1">
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