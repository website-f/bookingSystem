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
          <h1 class="m-0">All Appointments</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">All Appointments</li>
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
                  <th>#</th>
                  <th>Status</th>
                  <th>Submission Date</th>
                  <th>Booking Code</th>
                  <th>Location</th>
                  <th>Service</th>
                  <th>Stylist</th>
                  <th>Booking Date</th>
                  <th>Customer Name</th>
                  <th>Customer Phone</th>
                  <th>Customer Email</th>
                  <th>Customer Comments</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($bookings as $booking)
                    <tr>
                      <td></td>
                      <td>
                        @if ($booking->status == "pending")
                          <!-- Button trigger modal -->
                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pending{{$booking->id}}">
                             Pending
                           </button>
                           
                           <!-- Modal -->
                           <div class="modal fade" id="pending{{$booking->id}}" tabindex="-1" role="dialog" aria-labelledby="pending{{$booking->id}}" aria-hidden="true">
                             <div class="modal-dialog modal-dialog-centered" role="document">
                               <div class="modal-content">
                                 <div class="modal-header">
                                   <h5 class="modal-title" id="exampleModalLongTitle">Change Status</h5>
                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                   </button>
                                 </div>
                                 <div class="modal-body">
                                  <form action="/change-status/{{$booking->id}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <label class="form-label">Current Status:</label>
                                    <select name="status" class="form-control mb-2">
                                      <option value="pending" {{$booking->status == "pending" ? 'selected' : ''}}>Pending</option>
                                      <option value="approved" {{$booking->status == "approved" ? 'selected' : ''}}>Approved</option>
                                      <option value="complete" {{$booking->status == "complete" ? 'selected' : ''}}>Complete</option>
                                      <option value="cancelled" {{$booking->status == "cancelled" ? 'selected' : ''}}>Cancelled</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                   </form>
                                 </div>
                                 <div class="modal-footer">
                                   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                 </div>
                               </div>
                             </div>
                           </div>
                        @elseif ($booking->status == "complete")
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#complete{{$booking->id}}">
                          Complete
                        </button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="complete{{$booking->id}}" tabindex="-1" role="dialog" aria-labelledby="complete{{$booking->id}}" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Change Status</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="/change-status/{{$booking->id}}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <label class="form-label">Current Status:</label>
                                  <select name="status" class="form-control mb-2">
                                    <option value="pending" {{$booking->status == "pending" ? 'selected' : ''}}>Pending</option>
                                    <option value="approved" {{$booking->status == "approved" ? 'selected' : ''}}>Approved</option>
                                    <option value="complete" {{$booking->status == "complete" ? 'selected' : ''}}>Complete</option>
                                    <option value="cancelled" {{$booking->status == "cancelled" ? 'selected' : ''}}>Cancelled</option>
                                  </select>
                                  <button type="submit" class="btn btn-primary">Save changes</button>
                                 </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        @elseif ($booking->status == "cancelled")
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancelled{{$booking->id}}">
                          Cancelled
                        </button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="cancelled{{$booking->id}}" tabindex="-1" role="dialog" aria-labelledby="cancelled{{$booking->id}}" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Change Status</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="/change-status/{{$booking->id}}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <label class="form-label">Current Status:</label>
                                  <select name="status" class="form-control mb-2">
                                    <option value="pending" {{$booking->status == "pending" ? 'selected' : ''}}>Pending</option>
                                    <option value="approved" {{$booking->status == "approved" ? 'selected' : ''}}>Approved</option>
                                    <option value="complete" {{$booking->status == "complete" ? 'selected' : ''}}>Complete</option>
                                    <option value="cancelled" {{$booking->status == "cancelled" ? 'selected' : ''}}>Cancelled</option>
                                  </select>
                                  <button type="submit" class="btn btn-primary">Save changes</button>
                                 </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        @else
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#approve{{$booking->id}}">
                          {{$booking->status}}
                        </button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="approve{{$booking->id}}" tabindex="-1" role="dialog" aria-labelledby="approve{{$booking->id}}" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Change Status</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="/change-status/{{$booking->id}}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <label class="form-label">Current Status:</label>
                                  <select name="status" class="form-control mb-2">
                                    <option value="pending" {{$booking->status == "pending" ? 'selected' : ''}}>Pending</option>
                                    <option value="approved" {{$booking->status == "approved" ? 'selected' : ''}}>Approved</option>
                                    <option value="complete" {{$booking->status == "complete" ? 'selected' : ''}}>Complete</option>
                                    <option value="cancelled" {{$booking->status == "cancelled" ? 'selected' : ''}}>Cancelled</option>
                                  </select>
                                  <button type="submit" class="btn btn-primary">Save changes</button>
                                 </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        @endif
                      </td>
                      <td>{{$booking->created_at}}</td>
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
                      <td>
                        {{$booking->comments}}
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
      "order": [[2, "desc"]],

    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
  });
</script>

@endsection