<x-layout title="Sekolah">
    <div class="d-flex">
    <x-Sidebar title="Sekolah"></x-Sidebar>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel"> Form Tambahkan Sekolah</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/create-store" method="POST">
              @csrf
  
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">sekolah</label>
                  <input type="text" class="form-control" name="sekolah" id="exampleInputEmail1">
                </div>
           
                <div class="mb-3 form-check">
                  <input type="checkbox" class="form-check-input" id="exampleCheck1">
                  <label class="form-check-label" for="exampleCheck1">Check me out</label>
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
    
      <div class="mt-5 container col-md-8">
        <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-outline-success mb-1"><i class="fas fa-school"></i>+ Add New</button>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">No</th>    
                <th scope="col">Nama Sekolah</th>
              </tr>
            </thead>
            <tbody>       
              @foreach ($data as $item)
              <tr>
                <th scope="row">{{$item->sekolah_id}}</th>
                <td>{{$item->sekolah}}</td>
                <td>
                <a href="/editsekolah/{{$item->sekolah_id}}" class="me-1 fas fa-pen text-primary"></a>
                <a href="/deletesekolah/{{$item->sekolah_id}}" class="ms-1 fas fa-trash text-danger"></a>  
                <td>
              </tr>
              @endforeach
            </tbody>
          </table>
    </div>
    </div>
    </x-layout>