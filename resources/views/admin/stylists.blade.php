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
          <button type="button" class="btn btn-outline-primary w-100" data-toggle="modal" data-target="#addStylist">
            <i class="fas fa-plus"></i> Add Stylist
          </button>
          
          <!-- Modal -->
          <div class="modal fade" id="addStylist" tabindex="-1" role="dialog" aria-labelledby="addStylist" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Add Stylist</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="/dashboard/add-stylist" method="POST"  enctype="multipart/form-data">
                  @csrf
                <div class="modal-body">
                  <div class="row mb-2">
                    <div class="col-lg-6">
                      <label class="form-label">First Name</label>
                      <input type="text" name="first_name" class="form-control"><br>
                    </div>
                    <div class="col-lg-6">
                      <label class="form-label">Last Name</label>
                      <input type="text" name="last_name" class="form-control"><br>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-lg-6">
                      <label class="form-label">Display Name</label>
                      <input type="text" name="display_name" class="form-control"><br>
                    </div>
                    <div class="col-lg-6">
                      <label class="form-label">Title</label>
                      <input type="text" name="title" class="form-control"><br>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-lg-6">
                      <label class="form-label">Bio</label>
                      <input type="text" name="bio" class="form-control"><br>
                    </div>
                    <div class="col-lg-6">
                      <label class="form-label">Email</label>
                      <input type="text" name="email" class="form-control"><br>
                    </div>
                  </div>
                  <label class="form-label">Image</label>
                  <input type="file" id="formFile" name="image" class="form-control">
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
          @foreach ($stylist as $stylists)  
          <div class="col-md-3">
          <div class="card card-primary card-outline fixed-card">
            <div class="card-body box-profile">
              <div class="text-center">
                @if ($stylists->image !== null)
                <img width="50px" height="50px" class="profile-user-img img-fluid img-circle" src="{{asset($stylists->image)}}" alt="{{$stylists->display_name}}"> 
                @else
                <img class="profile-user-img img-fluid img-circle" src="#" alt="{{$stylists->display_name}}">
                @endif
              </div>

              <h3 class="profile-username text-center">{{$stylists->display_name}}</h3>

              <p class="text-muted text-center">{{$stylists->bio}}</p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Booking</b> <a class="float-right">1,322</a>
                </li>
                <li class="list-group-item">
                  <b>Today</b> <a class="float-right"><span class="badge badge-success">on duty</span></a>
                </li>
                {{-- <li class="list-group-item">
                  <b>Friends</b> <a class="float-right">13,287</a>
                </li> --}}
              </ul>

              <button type="button" class="btn btn-primary w-100 btn-sm" data-toggle="modal" data-target="#editStylist-{{$stylists->id}}">
                <i class="fas fa-edit"></i> Edit Stylist
              </button>
              
              <!-- Modal -->
              <div class="modal fade" id="editStylist-{{$stylists->id}}" tabindex="-1" role="dialog" aria-labelledby="editStylist-{{$stylists->id}}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Edit Stylist</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="/dashboard/edit-stylist" method="POST"  enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                    <div class="modal-body">
                      <div class="row mb-2">
                        <div class="col-lg-6">
                          <label class="form-label">First Name</label>
                          <input type="text" name="first_name" class="form-control" value="{{$stylists->first_name}}"><br>
                        </div>
                        <div class="col-lg-6">
                          <label class="form-label">Last Name</label>
                          <input type="text" name="last_name" class="form-control" value="{{$stylists->last_name}}"><br>
                        </div>
                      </div>
                      <div class="row mb-2">
                        <div class="col-lg-6">
                          <label class="form-label">Display Name</label>
                          <input type="text" name="display_name" class="form-control" value="{{$stylists->display_name}}"><br>
                        </div>
                        <div class="col-lg-6">
                          <label class="form-label">Title</label>
                          <input type="text" name="title" class="form-control" value="{{$stylists->title}}"><br>
                        </div>
                      </div>
                      <div class="row mb-2">
                        <div class="col-lg-6">
                          <label class="form-label">Bio</label>
                          <input type="text" name="bio" class="form-control" value="{{$stylists->bio}}"><br>
                        </div>
                        <div class="col-lg-6">
                          <label class="form-label">Email</label>
                          <input type="text" name="email" class="form-control" value="{{$stylists->email}}"><br>
                        </div>
                      </div>
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
            <!-- /.card-body -->
          </div>
          </div>
        @endforeach
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

@endsection