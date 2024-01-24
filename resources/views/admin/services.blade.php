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
          <h1 class="m-0">Services</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Services</li>
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
          <button type="button" class="btn btn-outline-primary w-100" data-toggle="modal" data-target="#addServices">
            <i class="fas fa-plus"></i> Add Services
          </button>
          
          <!-- Modal -->
          <div class="modal fade" id="addServices" tabindex="-1" role="dialog" aria-labelledby="addServices" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Add Services</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="/dashboard/add-service" method="POST"  enctype="multipart/form-data">
                  @csrf
                <div class="modal-body">
                  <div class="row mb-2">
                    <div class="col-lg-6">
                      <label class="form-label">Service Name</label>
                      <input type="text" name="name" class="form-control"><br>
                    </div>
                    <div class="col-lg-6">
                      <label class="form-label">Short Description</label>
                      <input type="text" name="short_description" class="form-control"><br>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-lg-6">
                      <label class="form-label">Price Min</label>
                      <input type="number" name="price_min" class="form-control"><br>
                    </div>
                    <div class="col-lg-6">
                      <label class="form-label">Price Max</label>
                      <input type="number" name="price_max" class="form-control"><br>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-lg-6">
                      <label class="form-label">Charge Amount</label>
                      <input type="number" name="charge_amount" class="form-control"><br>
                    </div>
                    <div class="col-lg-6">
                      <label class="form-label">Duration</label>
                      <input type="number" name="duration" class="form-control"><br>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Category</label>
                    <select class="form-control" name="category_id">
                      @foreach ($category as $categories)
                          <option value="{{$categories->id}}">{{$categories->name}}</option>
                      @endforeach
                    </select>
                  </div>
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
        @foreach ($service as $services)
        <div class="col-lg-3">
          <div class="card ">
            @if ($services->selection_image !== null)
            <img class="card-img-top" src="{{asset($services->selection_image)}}" alt="{{$services->name}}"> 
            @else
            <img class="card-img-top" src="#" alt="{{$services->name}}">
            @endif
            
            <div class="card-body">
              <h5 class="card-title"><b>{{$services->name}}</b></h5>
              <p class="card-text">{{$services->short_description}}</p>
              <p class="card-text">RM{{number_format($services->charge_amount, 2)}}</p>
              <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#editServices-{{$services->id}}">
                <i class="fas fa-edit"></i> Edit Services
              </button>
              
              <!-- Modal -->
              <div class="modal fade" id="editServices-{{$services->id}}" tabindex="-1" role="dialog" aria-labelledby="editServices-{{$services->id}}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Edit Service</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="/dashboard/edit-service/{{$services->id}}" method="POST"  enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="modal-body">
                        <div class="row mb-2">
                          <div class="col-lg-6">
                            <label class="form-label">Service Name</label>
                            <input type="text" name="name" class="form-control" value="{{$services->name}}"><br>
                          </div>
                          <div class="col-lg-6">
                            <label class="form-label">Short Description</label>
                            <input type="text" name="short_description" class="form-control" value="{{$services->short_description}}"><br>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-6">
                            <label class="form-label">Price Min</label>
                            <input type="number" name="price_min" class="form-control" value="{{$services->price_min}}"><br>
                          </div>
                          <div class="col-lg-6">
                            <label class="form-label">Price Max</label>
                            <input type="number" name="price_max" class="form-control" value="{{$services->price_max}}"><br>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-6">
                            <label class="form-label">Charge Amount</label>
                            <input type="number" name="charge_amount" class="form-control" value="{{$services->charge_amount}}"><br>
                          </div>
                          <div class="col-lg-6">
                            <label class="form-label">Duration</label>
                            <input type="number" name="duration" class="form-control" value="{{$services->duration}}"><br>
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Category</label>
                          <select class="form-control" name="category_id">
                            @foreach ($category as $categories)
                                <option value="{{$categories->id}}" 
                                  @if ($categories->id == $services->category_id)
                                      selected
                                  @else
                                  @endif
                                  >{{$categories->name}}</option>
                            @endforeach
                          </select>
                        </div>
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
                                          @if ($services->stylists->contains($stylist->id))
                                            btn-primary active
                                        @else
                                            btn-outline-primary
                                        @endif
                                          ">
                                              <div class="float-left">
                                                  <input type="checkbox" name="stylists[]" autocomplete="off" value="{{$stylist->id}}"
                                                  @if ($services->stylists->contains($stylist->id))
                                                checked
                                                @endif
                                                  >
                                                  <img class="img-fluid img-thumbnail" height="50px" width="50px" src="{{asset($stylist->image)}}" alt="{{$stylist->display_name}}">
                                                  {{$stylist->display_name}}
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