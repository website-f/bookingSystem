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
      @if (Auth::user()->role_id == 1)
          <!-- Custom tabs (Charts with tabs)-->
      <div class="card bg-gradient-light">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-chart-pie mr-1"></i>
            Booking Report
          </h3>
          <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
              <li class="nav-item">
                <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Overall</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#sales-chart" data-toggle="tab">Branch</a>
              </li>
            </ul>
          </div>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content p-0">
            <!-- Morris chart - Sales -->
            <div class="chart tab-pane active" id="revenue-chart"
                 style="position: relative; height: 300px;">
                 <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
             </div>
            <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
              <canvas class="chart" id="line-chart-branch" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          </div>
        </div><!-- /.card-body -->
      </div>
      <!-- /.card -->

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Today's Appointment</h3>
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
                                    <option value="cancelled" {{$booking->status == "cancelled" ? 'selected' : ''}}>Canceled</option>
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
                                    <option value="cancelled" {{$booking->status == "cancelled" ? 'selected' : ''}}>Canceled</option>
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
                                    <option value="cancelled" {{$booking->status == "cancelled" ? 'selected' : ''}}>Canceled</option>
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
      @else
      <div class="card bg-gradient-light">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-chart-pie mr-1"></i>
            Booking Report
          </h3>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content p-0">
            <!-- Morris chart - Sales -->
            <div class="chart tab-pane active" id="revenue-chart"
                 style="position: relative; height: 300px;">
                 <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
             </div>
          </div>
        </div><!-- /.card-body -->
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Today's Appointment</h3>
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
                                      <option value="cancelled" {{$booking->status == "cancelled" ? 'selected' : ''}}>Canceled</option>
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
                                    <option value="cancelled" {{$booking->status == "cancelled" ? 'selected' : ''}}>Canceled</option>
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
                                    <option value="cancelled" {{$booking->status == "cancelled" ? 'selected' : ''}}>Canceled</option>
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
                                    <option value="cancelled" {{$booking->status == "cancelled" ? 'selected' : ''}}>Canceled</option>
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
      @endif
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
<script>
  // Sales graph chart
  var bookingsCountPerDay = <?php echo json_encode($bookingsCountPerDay); ?>;
  var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d');
  var labels = Object.keys(bookingsCountPerDay); // Extracting the days as labels
  var data = labels.map(function(day) {
    return bookingsCountPerDay[day]; // Extracting the count for each day
  });

  var salesGraphChartData = {
    labels: labels,
    datasets: [
      {
        label: 'Bookings Count',
        fill: false,
        borderWidth: 2,
        lineTension: 0,
        spanGaps: true,
        borderColor: '#007bff',
        pointRadius: 3,
        pointHoverRadius: 7,
        pointColor: '#007bff',
        pointBackgroundColor: '#007bff',
        data: data
      }
    ]
  };

  var salesGraphChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        ticks: {
          fontColor: '#007bff'
        },
        gridLines: {
          display: false,
          color: '#007bff',
          drawBorder: false
        }
      }],
      yAxes: [{
        ticks: {
          stepSize: 2,
          fontColor: '#007bff'
        },
        gridLines: {
          display: true,
          color: '#B4D4FF',
          drawBorder: false
        }
      }]
    }
  };

  // This will get the first returned node in the jQuery collection.
  var salesGraphChart = new Chart(salesGraphChartCanvas, {
    type: 'line',
    data: salesGraphChartData,
    options: salesGraphChartOptions
  });
</script>
<script>
    var bookingsCountPerDayByBranch = <?php echo json_encode($bookingsCountPerDayByBranch); ?>;
    
    // Sales graph chart
    var salesGraphChartCanvas = $('#line-chart-branch').get(0).getContext('2d');

    // Extracting and sorting the dates
    var dates = Object.keys(bookingsCountPerDayByBranch).sort(function(a, b) {
        return new Date(a) - new Date(b);
    });

    // Extracting branch IDs
    var branchIds = [];
    dates.forEach(function(day) {
        var branchCounts = bookingsCountPerDayByBranch[day];
        Object.keys(branchCounts).forEach(function(branchId) {
            if (!branchIds.includes(branchId)) {
                branchIds.push(branchId);
            }
        });
    });

    // Mapping branch IDs to branch names
    var branchNames = {
        "1": "Bangsar Telawi",
        "2": "My Town",
        "3": "Bangsar Shopping Centre (Premium)",
        "4": "Pavilion Bukit Jalil",
        "5": "IOI City Mall",
        "6": "Publika",
        "7": "Setia City Mall"
        // Add more branch IDs and names as needed
    };

    // Initialize datasets
    var datasets = branchIds.map(function(branchId) {
        return {
            label: branchNames[branchId] || "Unknown",
            fill: false,
            borderWidth: 2,
            lineTension: 0,
            spanGaps: true,
            borderColor: getRandomColor(),
            pointRadius: 3,
            pointHoverRadius: 7,
            pointColor: 'black',
            pointBackgroundColor: 'black',
            data: dates.map(function(day) {
                return bookingsCountPerDayByBranch[day][branchId] || 0;
            })
        };
    });

    var salesGraphChartData = {
        labels: dates,
        datasets: datasets
    };

    var salesGraphChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: true
        },
        scales: {
            xAxes: [{
                ticks: {
                    fontColor: 'black'
                },
                gridLines: {
                    display: false,
                    color: 'black',
                    drawBorder: false
                }
            }],
            yAxes: [{
                ticks: {
                    stepSize: 2,
                    fontColor: 'black'
                },
                gridLines: {
                    display: true,
                    color: '#B4D4FF',
                    drawBorder: false
                }
            }]
        }
    };

    // This will get the first returned node in the jQuery collection.
    var salesGraphChart = new Chart(salesGraphChartCanvas, {
        type: 'line',
        data: salesGraphChartData,
        options: salesGraphChartOptions
    });

    // Generate random color
    function getRandomColor() {
        return '#' + Math.floor(Math.random() * 16777215).toString(16);
    }
</script>







@endsection