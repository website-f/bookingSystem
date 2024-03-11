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
          <h1 class="m-0">Appointment</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Appointment</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
         
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
                  <th>Customer Email</th>
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
                      <td>
                        {{$customer->email}}
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
<!-- ChartJS -->
<script src="{{asset('admin/plugins/chart.js/Chart.min.js')}}"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false, "pageLength": 30,
      "buttons": ["copy", "excel", "pdf", "print"],
      "order": [[1, "desc"]],

    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
  });
</script>

@endsection