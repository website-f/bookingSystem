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
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                  <input type="file" name="image" class="form-control"><br>
                  <hr>
                  <div class="row">
                    <div class="col-lg-12">
                      <p class="font-weight-bold">Stylists</p>
                        @foreach ($stylists as $stylist)
                            <div class="row mb-2">
                                <div class="col-lg-12">
                                    <div class="btn btn-block btn-outline-primary styleBtn clearfix">
                                        <div class="float-left">
                                            <input type="checkbox" name="stylists[]" autocomplete="off" value="{{$stylist->id}}">
                                            <img class="img-fluid img-thumbnail" height="50px" width="50px" src="{{asset($stylist->image)}}" alt="{{$stylist->display_name}}">
                                            {{$stylist->display_name}}
                                        </div>
                                        {{-- <a data-toggle="collapse" href="#collapseOne-{{$stylist->id}}" class="float-right bg-primary p-1 rounded" onclick="handleLinkClick(event)">services</a> --}}
                                    </div>
                                </div>
                            </div>
                            {{-- <div id="collapseOne-{{$stylist->id}}" class="collapse">
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-sm-6">
                                    <!-- checkbox -->
                                    <div class="form-group">
                                      <div class="form-check">
                                        @foreach ($service as $services)
                                        <input class="form-check-input" type="checkbox" name="services[]"
                                        checked value="{{$services->id}}"
                                        >
                                        <label class="form-check-label">{{$services->name}}</label> <br>
                                        @endforeach
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div> --}}
                        @endforeach
                    </div>
                  </div>

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
        <div class="col-lg-3">
          <div class="card h-100 mb-2">
            @if ($locations->image !== null)
            <img class="card-img-top" src="{{asset($locations->image)}}" alt="{{$locations->name}}"> 
            @else
            <img class="card-img-top" src="#" alt="{{$locations->name}}">
            @endif
            
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><b>{{$locations->name}}</b></h5>
              <p class="card-text">{{$locations->full_address}}</p>
              <button type="button" class="btn btn-primary w-100 mt-auto" data-toggle="modal" data-target="#editLocation-{{$locations->id}}">
                <i class="fas fa-edit"></i> Edit Location
              </button>
              
              <!-- Modal -->
              <div class="modal fade" id="editLocation-{{$locations->id}}" tabindex="-1" role="dialog" aria-labelledby="editLocation-{{$locations->id}}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Edit Location</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="/dashboard/edit-location/{{$locations->id}}" method="POST"  enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                    <div class="modal-body">
                      <label class="form-label">Location Name</label>
                      <input type="text" name="name" class="form-control" value="{{$locations->name}}"><br>
                      <label class="form-label">Location Full Address</label>
                      <textarea name="full_address" class="form-control" cols="30" rows="7">{{$locations->full_address}}</textarea><br>
                      <label class="form-label">Image</label>
                      <input type="file" name="image" class="form-control"><br>
                      <hr>
                      <div class="row">
                        <div class="col-lg-12">
                          <p class="font-weight-bold">Stylists</p>
                            @foreach ($stylists as $stylist)
                                <div class="row mb-2">
                                    <div class="col-lg-12">
                                        <div class="btn btn-block btn-outline-primary styleBtn clearfix
                                        @if ($locations->stylists->contains($stylist->id))
                                            btn-primary active
                                        @else
                                            btn-outline-primary
                                        @endif
                                        "
                                        >
                                            <div class="float-left">
                                                <input type="checkbox" name="stylists[]" autocomplete="off" value="{{$stylist->id}}"
                                                @if ($locations->stylists->contains($stylist->id))
                                                checked
                                                @endif 
                                                >
                                                <img class="img-fluid img-thumbnail" height="50px" width="50px" src="{{asset($stylist->image)}}" alt="">
                                                {{$stylist->display_name}}
                                            </div>
                                            {{-- <a href="#collapseTwo-{{$stylist->id}}" class="float-right bg-primary p-1 rounded" onclick="handleLinkClickEdit(event)">services</a> --}}
                                        </div>
                                    </div>
                                </div>
                                {{-- <div id="collapseTwo-{{$stylist->id}}" class="collapse">
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-sm-6">
                                        <!-- checkbox -->
                                        <div class="form-group">
                                          <div class="form-check">
                                            @foreach ($service as $services)
                                            <input class="form-check-input" type="checkbox" name="servicesTwo[]" value="{{$services->id}}"
                                            @if ($stylist->services->contains($services->id))
                                            checked
                                            @endif 
                                            >
                                            <label class="form-check-label">{{$services->name}}</label><br>
                                            @endforeach
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div> --}}
                            @endforeach
    
                        </div>
                      </div>
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
<!-- jQuery -->
<script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
      var styleBtns = document.querySelectorAll('.styleBtn');

      styleBtns.forEach(function (btn) {
          btn.addEventListener('click', function () {
              var checkbox = this.querySelector('input[type="checkbox"]');
              checkbox.checked = !checkbox.checked;

              // Optionally, you can manually update the styling based on the checkbox state.
              if (checkbox.checked) {
                  btn.classList.add('btn-primary', 'active');
              } else {
                  btn.classList.remove('btn-primary', 'active');
              }
          });
      });
  });
</script>
<script>
  function handleLinkClick(event) {
      event.stopPropagation(); // Prevent the click event from bubbling up to the parent div
      // Add your custom link click logic here
      var targetId = event.target.getAttribute('href'); // Get the target collapse div ID
      console.log('Target ID:', targetId);
      $(targetId).collapse('toggle');
  }

  function handleLinkClickEdit(event) {
      event.stopPropagation(); // Prevent the click event from bubbling up to the parent div
      // Add your custom link click logic here
      var targetId = event.target.getAttribute('href'); // Get the target collapse div ID
      console.log('Target ID:', targetId);
      var targetDiv = document.querySelector(targetId);
      var targetDicRem = targetDiv.classList.remove("show")
      console.log(targetDiv)
  }
</script>

@endsection