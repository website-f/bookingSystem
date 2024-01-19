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
          <h1 class="m-0">Categories</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Categories</li>
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
            <i class="fas fa-plus"></i> Add Categories
          </button>
          
          <!-- Modal -->
          <div class="modal fade" id="addLocation" tabindex="-1" role="dialog" aria-labelledby="addLocation" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Add Categories</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="/dashboard/add-category" method="POST"  enctype="multipart/form-data">
                  @csrf
                <div class="modal-body">
                  <label class="form-label">Service Name</label>
                  <input type="text" name="name" class="form-control"><br>
                  <label class="form-label">Image</label>
                  <input type="file" name="image" class="form-control"><br>

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
        @foreach ($category as $categories)
        <div class="col-lg-3">
          <div class="card ">
            @if ($categories->image !== null)
            <img class="card-img-top" src="{{asset($categories->image)}}" alt="{{$categories->name}}"> 
            @else
            <img class="card-img-top" src="#" alt="{{$categories->name}}">
            @endif
            
            <div class="card-body">
              <h5 class="card-title mb-2"><b>{{$categories->name}}</b></h5>
              <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#editcategory-{{$categories->id}}">
                <i class="fas fa-edit"></i> Edit Category
              </button>
              
              <!-- Modal -->
              <div class="modal fade" id="editcategory-{{$categories->id}}" tabindex="-1" role="dialog" aria-labelledby="editcategory-{{$categories->id}}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Edit Location</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="/dashboard/edit-location" method="POST"  enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                    <div class="modal-body">
                      <label class="form-label">Location Name</label>
                      <input type="text" name="name" class="form-control" value="{{$categories->name}}"><br>
                      <label class="form-label">Image</label>
                      <input type="file" name="image" class="form-control"><br>

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