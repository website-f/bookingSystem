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
              <h3 class="card-title">Sponsor Events</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Submission Date</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($sponsor as $sponsorship)
                    <tr>
                      <td>
                        <a href="/view-request/{{$sponsorship->id}}" class="btn btn-primary btn-sm mb-1"><i class="ion ion-eye"></i></a>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal{{$sponsorship->id}}">
                          <i class="ion ion-ios-trash"></i>
                        </button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="modal{{$sponsorship->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                Are you sure want to remove {{$sponsorship->event_name}} ?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a href="/delete/{{$sponsorship->id}}" class="btn btn-danger">Confirm</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td>{{$sponsorship->created_at->format('d-m-Y')}}</td>
                      
                    </tr>
                  @endforeach
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

<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<script>
  const pageLabels = @json($statusCounts->keys());
  const pageData = @json($statusCounts->values());
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    
    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutData        = {
      labels: pageLabels,
      datasets: [
        {
          data: pageData,
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

    // Sales graph chart
  var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
  // $('#revenue-chart').get(0).getContext('2d');

  var salesGraphChartData = {
    labels: ['2011 Q1', '2011 Q2', '2011 Q3', '2011 Q4', '2012 Q1', '2012 Q2', '2012 Q3', '2012 Q4', '2013 Q1', '2013 Q2'],
    datasets: [
      {
        label: 'Digital Goods',
        fill: false,
        borderWidth: 2,
        lineTension: 0,
        spanGaps: true,
        borderColor: '#efefef',
        pointRadius: 3,
        pointHoverRadius: 7,
        pointColor: '#efefef',
        pointBackgroundColor: '#efefef',
        data: [2666, 2778, 4912, 3767, 6810, 5670, 4820, 15073, 10687, 8432]
      }
    ]
  }

  var salesGraphChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        ticks: {
          fontColor: '#efefef'
        },
        gridLines: {
          display: false,
          color: '#efefef',
          drawBorder: false
        }
      }],
      yAxes: [{
        ticks: {
          stepSize: 5000,
          fontColor: '#efefef'
        },
        gridLines: {
          display: true,
          color: '#efefef',
          drawBorder: false
        }
      }]
    }
  }

  // eslint-disable-next-line no-unused-vars
  var salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
    type: 'line',
    data: salesGraphChartData,
    options: salesGraphChartOptions
  })

   
  })
</script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false, "pageLength": 30,
      "buttons": ["copy", "excel", "pdf", "print"],

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