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
                      <input type="text" name="first_name" class="form-control form-control-border"><br>
                    </div>
                    <div class="col-lg-6">
                      <label class="form-label">Last Name</label>
                      <input type="text" name="last_name" class="form-control form-control-border"><br>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-lg-6">
                      <label class="form-label">Display Name</label>
                      <input type="text" name="display_name" class="form-control form-control-border"><br>
                    </div>
                    <div class="col-lg-6">
                      <label class="form-label">Title</label>
                      <input type="text" name="title" class="form-control form-control-border"><br>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-lg-6">
                      <label class="form-label">Bio</label> 
                      <input type="text" name="bio" class="form-control form-control-border"><br>
                    </div>
                    <div class="col-lg-6">
                      <label class="form-label">Email</label>
                      <input type="text" name="email" class="form-control form-control-border"><br>
                    </div>
                  </div>
                  <label class="form-label">Image</label>
                  <input type="file" id="formFile" name="image" class="form-control">
                  <hr>
                  <label class="form-label">Off Day</label>
                  <input type="date" name="off_days" class="form-control">
                  <hr>
                      <div class="row">
                        <div class="col-lg-12">
                          <p class="font-weight-bold">Services</p>
                            @foreach ($service as $services)
                                <div class="row mb-2">
                                    <div class="col-lg-12">
                                        <div class="btn btn-block btn-outline-primary styleBtn clearfix">
                                            <div class="float-left">
                                                <input type="checkbox" name="services[]" autocomplete="off" value="{{$services->id}}">
                                                {{$services->name}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
              <p class="text-muted text-center">{{$stylists->email}}</p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Booking</b> <a class="float-right">1,322</a>
                </li>
                <li class="list-group-item">
                  @php
                      $stylistSch = $stylistSchedule->where('stylist_id', $stylists->id)->first();
                      $isOffDuty = false;
                  
                      if ($stylistSch && $stylistSch->off_days !== null) {
                          $stylistSchOffDays = json_decode($stylistSch->off_days, true);
                          $todayDate = date('n-j-Y');
                          $isOffDuty = in_array($todayDate, $stylistSchOffDays);
                      }
                  @endphp
                  <b>Today</b> <a class="float-right">
                    @if ($isOffDuty)
                    <span class="badge badge-danger">Off duty</span>
                    @else
                    <span class="badge badge-success">on duty</span>
                    @endif
                  </a>
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
                    <form action="/dashboard/edit-stylist/{{$stylists->id}}" method="POST"  enctype="multipart/form-data">
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
                      <hr>
                      <label class="form-label">Off Day</label>
                      <div class="row">
                        <div class="col-lg-12">
                          @php
                              $stylistSchEdit = $stylistSchedule->where('stylist_id', $stylists->id)->first();
                              $stylistSchOffDaysEdit = [];
                          
                              if ($stylistSchEdit) {
                                  $stylistSchOffDaysEdit = json_decode($stylistSchEdit->off_days, true);
                              }
                          @endphp
                          
                          @if ($stylistSchOffDaysEdit)
                              @foreach ($stylistSchOffDaysEdit as $offdays)
                                  <div class="btn btn-block btn-outline-info mb-2 clearfix offday-item" data-offday="{{$offdays}}">
                                    <div class="float-left"><p>{{$offdays}}</p></div>
                                    <div class="float-right"> <button type="button" class="btn btn-sm btn-danger remove-offday"><i class="fas fa-trash-alt"></i></button></div>
                                  </div>  
                              @endforeach
                          @else
                              <p class="mb-2">No off days applied</p>
                          @endif
                        </div>
                        <!-- JavaScript to handle removal and send AJAX request -->
                      <script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
                      <script>
                        $(document).ready(function () {
                            $('.remove-offday').on('click', function () {
                                var offdayItem = $(this).closest('.offday-item');
                                var offday = offdayItem.data('offday');
                                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                      
                                // Make an AJAX request to remove the off-day
                                $.ajax({
                                    url: '/remove-offday',
                                    type: 'POST',
                                    data: {
                                        _token: csrfToken,
                                        stylistId: {{$stylists->id}},
                                        offday: offday
                                    },
                                    success: function (response) {
                                        // Assuming the response is a success message
                                        console.log(response);
                                        offdayItem.remove();
                                    },
                                    error: function (error) {
                                        console.log(error);
                                    }
                                });
                            });
                        });
                      </script>
                      </div>
                      <label>Add +</label>
                      <input type="date" name="off_days" class="form-control">
                      <hr>
                        <div class="row">
                          <div class="col-lg-12">
                            <p class="font-weight-bold">Stylists</p>
                              @foreach ($service as $services)
                                  <div class="row mb-2">
                                      <div class="col-lg-12">
                                          <div class="btn btn-block btn-outline-primary styleBtn clearfix
                                          @if ($stylists->services->contains($services->id))
                                            btn-primary active
                                        @else
                                            btn-outline-primary
                                        @endif
                                          ">
                                              <div class="float-left">
                                                  <input type="checkbox" name="services[]" autocomplete="off" value="{{$services->id}}"
                                                  @if ($stylists->services->contains($services->id))
                                                checked
                                                @endif
                                                  >
                                                  {{$services->name}}
                                              </div>
                                          </div>
                                      </div>
                                  </div>
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
            <!-- /.card-body -->
          </div>
          </div>
        @endforeach
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
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