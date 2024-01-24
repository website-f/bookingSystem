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
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      {{-- <div class="row">
        <div class="col-12">
        
          <div class="card bg-gradient-info">
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="fas fa-th mr-1"></i>
                Sales Graph
              </h3>

              
            </div>
            <div class="card-body">
              <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          
            <div class="card-footer bg-transparent">
              <div class="row">
                <div class="col-4 text-center">
                  <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
                         data-fgColor="#39CCCC">

                  <div class="text-white">Mail-Orders</div>
                </div>
              
                <div class="col-4 text-center">
                  <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
                         data-fgColor="#39CCCC">

                  <div class="text-white">Online</div>
                </div>
              
                <div class="col-4 text-center">
                  <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
                         data-fgColor="#39CCCC">

                  <div class="text-white">In-Store</div>
                </div>
              
              </div>
             
            </div>
           
          </div>

        </div>

      </div> --}}

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Appointments</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Status</th>
                  <th>Submission Date</th>
                  <th>Booking Code</th>
                  <th>Location</th>
                  <th>Service</th>
                  <th>Stylist</th>
                  <th>Date</th>
                  <th>Customer Name</th>
                  <th>Customer Phone</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($bookings as $booking)
                    <tr>
                      <td>
                        @if ($booking->status == "active")
                          <button class="btn btn-primary">Active</button>
                        @elseif ($booking->status == "complete")
                          <button class="btn btn-success">Complete</button>
                        @elseif ($booking->status == "cancelled")
                          <button class="btn btn-danger">Cancelled</button>
                        @else
                          {{$booking->status}}
                        @endif
                      </td>
                      <td>{{$booking->created_at->format('d-m-Y')}}</td>
                      <td>{{$booking->booking_code}}</td>
                      <td>
                        @php
                            $location = $locations->where('id', $booking->location_id)->first();
                        @endphp
                        {{$location->name}}
                      </td>
                      <td>
                        @php
                            $service = $services->where('id', $booking->service_id)->first();
                        @endphp
                        {{$service->name}}
                      </td>
                      <td>
                        @php
                            $stylist = $stylists->where('id', $booking->stylist_id)->first();
                        @endphp
                        {{$stylist->display_name}}
                      </td>
                      <td>
                        @php
                            $fulldate = json_decode($booking->date);
                        @endphp
                        {{$fulldate}}
                      </td>
                      <td>
                        @php
                            $customer = $customers->where('id', $booking->customer_id)->first();
                        @endphp
                        {{$customer->first_name}} {{$customer->last_name}}
                      </td>
                      <td>
                        {{$customer->phone}}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <!-- ./col -->
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false, "pageLength": 30,
      "buttons": ["copy", "excel", "pdf", "print"],
      "order": [[1, "desc"]],

    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "order": [[0, "desc"]]
    });
    $('#example3').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "order": [[0, "desc"]]
    });
    $('#example4').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "order": [[0, "desc"]]
    });
  });
</script>

@endsection