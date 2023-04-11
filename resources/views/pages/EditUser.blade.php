<x-layout title="Edit User">
   
    <div class="container col-md-5">
      @foreach ( $data as $item)
      <form action="/ki/Rainer/KI_Advance1of5/KI_Advance_MyClass/KI_Advance_Kelasku/public/editprofile/{{$data->user_id}}" method="POST">
        @csrf @method('put')
        @endforeach
        <h1> Form Edit User </h1>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Nama</label>
          <input type="text" class="form-control"  value="{{$data->nama}}" name="nama" id="exampleInputEmail1">
        </div>
      
      <div class="form-group"> 
        <label>Sekolah</label>
        <select class="form-control" name="sekolah_id">
      
          <option value=""> Pilih </option>
          @foreach ( $sekolah as $sekolah)
          <option value="{{$sekolah->sekolah_id}}"> {{$sekolah->sekolah}} </option>
          @endforeach
        </select>
      </div>
      
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Foto</label>
        <input type="file" class="form-control" name="foto"   id="exampleInputEmail1">
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


