@extends('admin-main')

@section('title', 'Dashboard')
    
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Locations</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Locations</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      @if (Session::has('status'))
       <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
      @endif
      <div class="row mb-4">
        <div class="col-lg-2">
          <button type="button" class="btn btn-outline-primary w-100" data-toggle="modal" data-target="#addLocation">
            <i class="fas fa-plus"></i> Add Location
          </button>
          
          <!-- Modal -->
          <div class="modal fade" id="addLocation" tabindex="-1" role="dialog" aria-labelledby="addLocation" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Add Location</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="/dashboard/add-location" method="POST"  enctype="multipart/form-data">
                  @csrf
                <div class="modal-body">
                  <label class="form-label">Location Name</label>
                  <input type="text" name="name" class="form-control"><br>
                  <label class="form-label">Location Full Address</label>
                  <textarea name="full_address" class="form-control" cols="30" rows="7"></textarea><br>
                  <label class="form-label">Image</label>
                  <input type="file" name="image" class="form-control">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Add</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <div class="row">
        @foreach ($location as $locations)
        <div class="col-lg-4">
          <div class="card ">
            @if ($locations->image !== null)
            <img class="card-img-top" src="{{asset($locations->image)}}" alt="{{$locations->name}}"> 
            @else
            <img class="card-img-top" src="#" alt="{{$locations->name}}">
            @endif
            
            <div class="card-body">
              <h5 class="card-title"><b>{{$locations->name}}</b></h5>
              <p class="card-text">{{$locations->full_address}}</p>
              <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#editLocation-{{$locations->id}}">
                <i class="fas fa-edit"></i> Edit Location
              </button>
              
              <!-- Modal -->
              <div class="modal fade" id="editLocation-{{$locations->id}}" tabindex="-1" role="dialog" aria-labelledby="editLocation-{{$locations->id}}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Edit Location</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="/dashboard/edit-location" method="POST"  enctype="multipart/form-data">
                      @csrf
                    <div class="modal-body">
                      <label class="form-label">Location Name</label>
                      <input type="text" name="name" class="form-control" value="{{$locations->name}}"><br>
                      <label class="form-label">Location Full Address</label>
                      <textarea name="full_address" class="form-control" cols="30" rows="7">{{$locations->full_address}}</textarea><br>
                      <label class="form-label">Image</label>
                      <input type="file" name="image" class="form-control">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

@endsection