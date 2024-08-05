@extends('client-main')

@section('title', 'Booking')
    
@section('content')
    <!-- Page content -->
    <!-- Loading overlay -->
  <div id="loading-overlay">
    <div class="loader"></div>
  </div>
    <section class="container pt-5">
        <div class="row">

  
          <!-- Sidebar (User info + Account menu) -->
          <aside class="col-lg-3 col-md-4 border-end pb-5 mt-n5">
            <div class="position-sticky top-0">
              <div class="text-center pt-5">
                <div class="d-table position-relative mx-auto mt-2 mt-lg-4 pt-5 mb-3">
                  {{-- <img src="assets/img/avatar/18.jpg" class="d-block rounded-circle" width="120" alt="John Doe">
                  <button type="button" class="btn btn-icon btn-light bg-white btn-sm border rounded-circle shadow-sm position-absolute bottom-0 end-0 mt-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Change picture">
                    <i class="bx bx-refresh"></i>
                  </button> --}}
                </div>
                <h2 class="h5 mb-1">Questions ?</h2>
                <p class="mb-3 pb-3">Call +60149112800 for help</p>
                <div id="account-menu" class="list-group list-group-flush collapse d-md-block">
                  <a href="#" class="list-group-item list-group-item-action d-flex align-items-center active">
                    <i class="bx bx-current-location fs-xl opacity-60 me-2"></i>
                    Location Selection
                  </a>
                  <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bx bx-selection fs-xl opacity-60 me-2"></i>
                    Service Selection
                  </a>
                  <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bx bx-selection fs-xl opacity-60 me-2"></i>
                    Service Selection Details
                  </a>
                  <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bx bxs-user-account fs-xl opacity-60 me-2"></i>
                    Select Stylist
                  </a>
                  <a href="#" id="datetimeTabBtn" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bx bx-calendar fs-xl opacity-60 me-2"></i>
                    Select Date & Time
                  </a>
                  <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bx bx-info-square fs-xl opacity-60 me-2"></i>
                    Your Information
                  </a>
                  <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bx bxs-user-detail fs-xl opacity-60 me-2"></i>
                    Verify Booking Details
                  </a>
                </div>
              </div>
            </div>
          </aside>


          <!-- Account details -->
          <div class="col-md-8 offset-lg-1 pb-5 mb-2 mb-lg-4 pt-md-5 mt-n3 mt-md-0">

            <form id="regForm" action="/book-appointment" method="POST">
              @csrf
              <!-- One "tab" for each step in the form: -->
              <div class="tabBookingStep"> 
                <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
                  <h1 class="h2 pt-xl-1 pb-3">Location Selection</h1>
                  <input type="hidden" name="location" id="location">
                  <input type="hidden" name="locationName" id="locationName">
    
                  @foreach ($location as $locations)
                  <div class="card overflow-hidden border-0 shadow-sm card-hover mb-2">
                    <div class="row g-0">
                      @if ($locations->image !== null)
                      <div class="col-sm-4 bg-repeat-0" style="background-image: url({{ asset($locations->image) }}); min-height: 12rem; background-size: cover;"></div>
                      @else
                      <div class="col-sm-4 bg-repeat-0 bg-size-cover"></div>
                      @endif
                      <div class="col-sm-8">
                        <div class="card-body">
                          <h5 class="card-title">{{$locations->name}}</h5>
                          <p class="card-text fs-sm">{{$locations->full_address}}</p>
                          <button type="button" data-location="{{$locations->id}}" data-locationName="{{$locations->name}}" class="btn btn-sm btn-primary nextBtn"  onclick="nextPrev(1)">Select This Location</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  
                </div>
              </div>
              <div class="tabBookingStep">
                 <!--Service------------------------>
                <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
                  <h1 class="h2 pt-xl-1 pb-3">Service Selection</h1>
                  <input type="hidden" id="service">

                  @foreach ($category as $categories)
                  <div class="card overflow-hidden border-0 shadow-sm card-hover mb-2">
                    <div class="row g-0">
                      @if ($categories->image !== null)
                      <div class="col-sm-4 bg-repeat-0" style="background-image: url({{ asset($categories->image) }}); min-height: 12rem; background-size: cover; background-position: center;"></div>
                      @else
                      <div class="col-sm-4 bg-repeat-0 bg-size-cover"></div>
                      @endif
                      <div class="col-sm-8">
                        <div class="card-body">
                          <h5 class="card-title">{{$categories->name}}</h5>
                          <button type="button" data-service="{{$categories->name}}" class="btn btn-sm btn-primary nextBtn"  onclick="nextPrev(1)">Select This</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach                
                  
                </div>
              </div>
              <div class="tabBookingStep">
                <!--Service Details------------------------>
                <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
                  <h1 class="h2 pt-xl-1 pb-3">Service Selection Details</h1>
                  <input type="hidden" id="serviceDetails" name="serviceDetails">
                  <input type="hidden" id="serviceDetailsId" name="serviceDetailsId">
                  <div id="serviceIdOne">
                    
                  </div>
                  <div id="serviceIdTwo">
                    @foreach ($service2 as $services2)
                    <div class="card overflow-hidden border-0 shadow-sm card-hover mb-2">
                      <div class="row g-0">
                        @if ($services2->selection_image !== null)
                        <div class="col-sm-4 bg-repeat-0" style="background-image: url({{ asset($services2->selection_image) }}); min-height: 12rem; background-size: cover; background-position: center;"></div>
                        @else
                        <div class="col-sm-4 bg-repeat-0 bg-size-cover"></div>
                        @endif
                        <div class="col-sm-8">
                          <div class="card-body">
                            <h5 class="card-title">{{$services2->name}}</h5>
                            <p class="card-text fs-sm">RM{{ $services2->charge_amount }}</p>
                            <button type="button" data-serviceDetails="{{$services2->name}}" data-serviceId="{{$services2->id}}" class="btn btn-sm btn-primary nextBtn getStylistsbtn"  onclick="nextPrev(1)">Select This Service</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach 
                  </div>
                  
                </div>
              </div>
              <div class="tabBookingStep">
                <!--Stylist------------------------>
                <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
                  <h1 class="h2 pt-xl-1 pb-3">Select Stylist</h1>
                  <input type="hidden" id="stylist" name="stylist">
                  <input type="hidden" id="stylistId" name="stylistId">
    
                  <div id="stylistContainer">
                    @foreach ($stylists as $stylist)
                    <div class="card overflow-hidden border-0 shadow-sm card-hover mb-2">
                      <div class="row g-0">
                        @if ($stylist->image !== null)
                        <div class="col-sm-4 bg-repeat-0" style="background-image: url({{ asset($stylist->image) }}); min-height: 12rem; background-repeat: no-repeat; background-attachment: fixed; background-position: center bottom;"></div>
                        @else
                        <div class="col-sm-4 bg-repeat-0 bg-size-cover"></div>
                        @endif
                        <div class="col-sm-8">
                          <div class="card-body">
                            <h5 class="card-title">{{$stylist->display_name}}</h5>
                            <button type="button" data-stylist="{{$stylist->id}}" data-stylist-id="{{$stylist->id}}" class="btn btn-sm btn-primary nextBtn"  onclick="nextPrev(1)">Select This</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach 
                  </div>

                </div>
              </div>
              <div class="tabBookingStep">
                <!-----Datetime----------------------->
                <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
                  <h1 class="h2 pt-xl-1 pb-3">Select Date & Time</h1>
                  <input type="hidden" id="datetime" name="datetime">
                  <div class="row">
                    <div class="col-12 p-4">
                        <div class="card">
                           <div class="card-body pb-2 d-flex justify-content-center align-items-center">
                            <div id='calendar'></div>
                            <!-- Modal -->
                            <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                   <div id="eventTitle"></div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                    
                                  </div>
                                </div>
                              </div>
                            </div>
        
                           </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tabBookingStep">
                <!--Info---------------------------->
                <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
                  <h1 class="h2 pt-xl-1 pb-3">Your Information</h1>
    
                  <div class="needs-validation border-bottom pb-3 pb-lg-4">
                    <div class="row pb-2">
                      <div class="col-sm-6 mb-4">
                        <label for="fn" class="form-label fs-base">First name</label>
                        <input type="text" id="fn" class="form-control form-control-lg" name="fname" required>
                        <div class="invalid-feedback">Please enter your first name!</div>
                      </div>
                      <div class="col-sm-6 mb-4">
                        <label for="sn" class="form-label fs-base">Last name</label>
                        <input type="text" id="ln" class="form-control form-control-lg" name="lname" required>
                        <div class="invalid-feedback">Please enter your second name!</div>
                      </div>
                      <div class="col-sm-6 mb-4">
                        <label for="email" class="form-label fs-base">Email address</label>
                        <input type="email" id="email" class="form-control form-control-lg" name="email" required>
                        <div class="invalid-feedback">Please provide a valid email address!</div>
                      </div>
                      <div class="col-sm-6 mb-4">
                        <label for="phone" class="form-label fs-base">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control form-control-lg">
                      </div>
                      <div class="col-12 mb-4">
                        <label for="bio" class="form-label fs-base">Comments</label>
                        <textarea id="bio" name="comments" class="form-control form-control-lg" rows="4"></textarea>
                      </div>
                    </div>
                    <div class="d-flex mb-3">
                      <button type="reset" class="btn btn-secondary me-3">Cancel</button>
                      <button type="button" onclick="nextPrev(1)" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
  
                </div>
              </div>
              <div class="tabBookingStep">
                <!-------Details------------------------->
                <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
                  <h1 class="h2 pt-xl-1 pb-3">Verify Booking Details</h1>

                  <div class="card overflow-hidden border-0 shadow-sm card-hover mb-2">
                    <div class="row g-0">
                      <div class="col-sm-4 bg-repeat-0 bg-size-cover" style="background-image: url({{asset('/client/assets/img/team/34.png')}}); min-height: 12rem;"></div>
                      <div class="col-sm-8">
                        <div class="card-body">
                          <h5 class="card-title">Location</h5>
                          <p class="locationInput"></p>
                          <h5 class="card-title">Date</h5>
                          <p class="datetimeInput"></p>
                          <h5 class="card-title">Service</h5>
                          <p class="serviceInput"></p>
                          <h5 class="card-title">Stylist</h5>
                          <p class="stylistInput"></p>
                          <h5 class="card-title">Full Name</h5>
                          <p class="fullnameInput"></p>
                          <h5 class="card-title">Phone</h5>
                          <p class="phoneInput"></p>
                          <h5 class="card-title">Email</h5>
                          <p class="emailInput"></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
              <div style="overflow:auto;">
                <div style="float:right;">
                  <button type="button" class="btn btn-outline-primary" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                  <button type="submit" class="btn btn-success" id="nextBtn">Submit</button>
                </div>
              </div>
              
            </form>
          </div>
        </div>
      </section>
      <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
      <script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
      <script>
        $(document).ready(function () {
            // Attach click event handler to a parent element that exists when the page is loaded
            // and delegate the event to elements with the class 'getStylistsbtn'
            $(document).on('click', '.getStylistsbtn', function () {
                var locationId = $('#location').val();
                var serviceId = $('#serviceDetailsId').val();
                console.log("clicked")
        
                $.ajax({
                    url: '/get-stylist/' + locationId + '/' + serviceId,
                    type: 'GET',
                    success: function (data) {
                        // Assuming you have a container with the ID 'stylistContainer'
                        $('#stylistContainer').html(''); // Clear previous content
                        if (data.stylists.length > 0) {
                            $.each(data.stylists, function (index, stylist) {
                                var stylistImage = stylist.image ? '{{ asset('') }}' + stylist.image : '';
                                var opacityStyle = stylist.branch.includes(locationId) ? '' : 'opacity: 0.3;';
                                var cardHtml = '<div class="card overflow-hidden border-0 shadow-sm card-hover mb-2">';
                                cardHtml += '<div class="row g-0">';
                                if (stylist.image !== null) {
                                    cardHtml += '<div class="col-sm-4 bg-repeat-0" style="background-image: url(' + stylistImage + '); min-height: 14rem; background-size: cover; background-position: center top; ' + opacityStyle + '"></div>';
                                } else {
                                    cardHtml += '<div class="col-sm-4 bg-repeat-0 bg-size-cover"></div>';
                                }
                                cardHtml += '<div class="col-sm-8">';
                                cardHtml += '<div class="card-body">';
                                cardHtml += '<h5 class="card-title" style="'+ opacityStyle +'">' + stylist.display_name + '</h5>';
                                if (stylist.branch.includes(locationId)) {
                                  cardHtml += '<button style="'+ opacityStyle +'" type="button" data-stylist="' + stylist.display_name + '" data-stylist-id="' + stylist.id + '" class="btn btn-sm btn-primary nextBtn"  onclick="nextPrev(1)">Select This</button>';
                                } else {
                                  cardHtml += '<button style="'+ opacityStyle +'" type="button" class="btn btn-sm btn-primary nextBtn">Select This</button>';
                                }
                                cardHtml += '</div></div></div></div>';
                                $('#stylistContainer').append(cardHtml);
                            });
                        } else {
                            // Handle case where no stylists are returned
                            $('#stylistContainer').html('<p>No stylists available for the selected location.</p>');
                        }
                        // Continue with the logic for the next step or any additional actions
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        });
      </script>
      <script>

        document.addEventListener('DOMContentLoaded', function() {
          function switchTab() {
            calendar.render()
          }
      
          var stylistContainer = document.getElementById('stylistContainer');
          stylistContainer.addEventListener('click', function(event) {
              if (event.target.classList.contains('nextBtn')) {
                switchTab();
              }
          });
          // Example: Switch to the "datetime" tab
          // document.getElementById('nextBtn').addEventListener('click', function () {
          //   switchTab();
          // });

          document.getElementById('prevBtn').addEventListener('click', function () {
            switchTab();
          });
          var calendarEl = document.getElementById('calendar');
          var stylistSchedule; // Declare stylistSchedule globally
        
          // Function to update the UI with stylist data
          function updateUI() {
            calendar.render(); // Render the calendar once the stylist data is available
            updateDayGridColors(stylistSchedule);
          }
        
          var calendar = new FullCalendar.Calendar(calendarEl, {
            dateClick: function(info) {
              getStylistSchedule(info.date, function(data) {
                stylistSchedule = data;
        
                // Update modal content based on availability
                updateModalContent(stylistSchedule, info.date);
                var myModal = new bootstrap.Modal(document.getElementById('eventModal'));
                myModal.show();
              });
            },
        
            themeSystem: 'bootstrap5',
            // headerToolbar: { center: 'dayGridMonth,timeGridWeek' },
            initialView: 'dayGridMonth',
            events: [], // Add an empty events array to avoid undefined errors
          });
        
          // Add the datesSet event callback
          calendar.on('datesSet', function() {
            getStylistSchedule(calendar.view.activeStart, function(data) {
              stylistSchedule = data;
              updateDayGridColors(stylistSchedule);
            });
          });
        
          // Fetch stylist data and update the UI
          getStylistSchedule(new Date(), function(data) {
            stylistSchedule = data;
            updateUI();
          });
        });
        
        function getStylistSchedule(date, callback) {
          // Implement logic to fetch stylist's schedule for the clicked date
          // This could involve an AJAX request to your server or retrieving data from your database
          // Return a schedule object or array with information about available, booked, and off days
          // Example:
          var dateString = date.toLocaleDateString('en-US', { timeZone: 'Asia/Kuala_Lumpur' }).split('/').join('-');
          var stylistId = document.getElementById("stylistId");
          console.log(stylistId.value)

          // Make an AJAX request to fetch the stylist's schedule
          $.ajax({
              type: 'GET',
              url: '/get-schedule/' + stylistId.value,
              data: { date: dateString },
              dataType: 'json',
              success: function (data) {
                  // Invoke the callback with the fetched data
                  callback(data);
              },
              error: function (error) {
                  console.error('Error fetching stylist schedule:', error);
              }
          });
        }
        
        function updateDayGridColors(stylistSchedule) {
        
          var daygrid = document.querySelectorAll(".fc-daygrid-day");
          var currentDate = new Date(); // Get current date
          var currentFormattedDate = `${currentDate.getMonth() + 1}-${currentDate.getDate()}-${currentDate.getFullYear()}`;

          // Calculate the date for 24 hours from now
          var next24HoursDate = new Date();
          next24HoursDate.setDate(currentDate.getDate() + 1);
          var next24HoursFormattedDate = `${next24HoursDate.getMonth() + 1}-${next24HoursDate.getDate()}-${next24HoursDate.getFullYear()}`;
          
          daygrid.forEach(element => {
            var daygridDate = element.getAttribute("data-date")
             // Parse the date using the Date object
             const parsedDate = new Date(daygridDate);
        
             // Format the date as "M-D-YYYY"
            const formattedDate = `${parsedDate.getMonth() + 1}-${parsedDate.getDate()}-${parsedDate.getFullYear()}`;
        
            var isOffDay = stylistSchedule.offDays.includes(formattedDate);
            var isCurrentDay = formattedDate === currentFormattedDate;
            var isNext24Hours = formattedDate === next24HoursFormattedDate;
            
        
            var dayNumberElement = element.querySelector('.fc-daygrid-day-number');
            if (isCurrentDay || isNext24Hours) {
                dayNumberElement.style.textDecoration = "underline solid yellow 50%";
            } else if (isOffDay) {
                dayNumberElement.style.textDecoration = "underline solid red 50%";
            } else {
                dayNumberElement.style.textDecoration = "underline solid rgb(6, 187, 6) 50%";
            }
            
          });
        
        }
        
      
        function updateModalContent(stylistSchedule, date) {
          // Implement logic to update modal content based on availability
          var locationName = document.getElementById("locationName").value;
          console.log(locationName);
          var modalContent = '';
          var dateFormatted = date.toLocaleDateString('en-GB', { day: 'numeric', month: 'numeric', year: 'numeric' });
          var currentDate = new Date(); // Get current date
          var currentFormattedDate = `${(currentDate.getDate()).toString().padStart(2, '0')}/${(currentDate.getMonth() + 1).toString().padStart(2, '0')}/${currentDate.getFullYear()}`;
          console.log(dateFormatted + currentFormattedDate)

          // Calculate the date for 24 hours from now
          var next24HoursDate = new Date();
          next24HoursDate.setDate(currentDate.getDate() + 1);
          var next24HoursFormattedDate = `${(next24HoursDate.getDate()).toString().padStart(2, '0')}/${(next24HoursDate.getMonth() + 1).toString().padStart(2, '0')}/${next24HoursDate.getFullYear()}`;

          if (locationName == "Bangsar Shopping Centre (Premium)") {
            for (var hour = 10; hour <= 20; hour++) {
            var startTime = `${stylistSchedule.date}T${hour.toString().padStart(2, '0')}:00:00`;
            console.log(startTime)
        
            // Check if the time slot is booked
            var isBooked = stylistSchedule.booked.some(slot => slot.start === startTime);
            var isOffDay = stylistSchedule.offDays.includes(stylistSchedule.date);
            var isCurrentDay = dateFormatted === currentFormattedDate;
            var isNext24Hours = dateFormatted === next24HoursFormattedDate;
        
            // Format the time slot and add it to the modal content
            modalContent += `<button data-date="${dateFormatted}, ${hour}:00" data-bs-dismiss="modal" ${isCurrentDay || isNext24Hours ? '' : 'onclick="nextPrev(1)"'} type="button" class="dataDate mb-2 w-100 btn ${isBooked ? 'btn-warning' : (isOffDay ? 'btn-danger' : (isCurrentDay || isNext24Hours ? 'btn-warning' : 'btn-success'))}">${hour}:00`;
              modalContent += isBooked ? ' (Booked)</button><br>' : (isOffDay ? ' (Off Day)</button><br>' : (isCurrentDay || isNext24Hours ? ' (Not Available)</button><br>' : ' (Available)</button><br>'));
          }
            
          } else if (locationName == "Publika") {
              for (var hour = 10; hour <= 19; hour++) {
              var startTime = `${stylistSchedule.date}T${hour.toString().padStart(2, '0')}:30:00`;
              console.log(startTime)
          
              // Check if the time slot is booked
              var isBooked = stylistSchedule.booked.some(slot => slot.start === startTime);
              var isOffDay = stylistSchedule.offDays.includes(stylistSchedule.date);
              var isCurrentDay = dateFormatted === currentFormattedDate;
              var isNext24Hours = dateFormatted === next24HoursFormattedDate;
          
              // Format the time slot and add it to the modal content
              modalContent += `<button data-date="${dateFormatted}, ${hour}:00" data-bs-dismiss="modal" ${isCurrentDay || isNext24Hours ? '' : 'onclick="nextPrev(1)"'} type="button" class="dataDate mb-2 w-100 btn ${isBooked ? 'btn-warning' : (isOffDay ? 'btn-danger' : (isCurrentDay || isNext24Hours ? 'btn-warning' : 'btn-success'))}">${hour}:00`;
                modalContent += isBooked ? ' (Booked)</button><br>' : (isOffDay ? ' (Off Day)</button><br>' : (isCurrentDay || isNext24Hours ? ' (Not Available)</button><br>' : ' (Available)</button><br>'));
            }
          } else if (locationName == "Bangsar Telawi") {
              // Display the first slot as 10:30 AM
              var startTime = `${stylistSchedule.date}T10:30:00`;
              console.log(startTime);
              
              // Check if the 10:30 AM slot is booked
              var isBooked = stylistSchedule.booked.some(slot => slot.start === startTime);
              var isOffDay = stylistSchedule.offDays.includes(stylistSchedule.date);
              var isCurrentDay = dateFormatted === currentFormattedDate;
              var isNext24Hours = dateFormatted === next24HoursFormattedDate;
              
              // Format the 10:30 AM slot and add it to the modal content
              modalContent += `<button data-date="${dateFormatted}, 10:30" data-bs-dismiss="modal" ${isCurrentDay || isNext24Hours ? '' : 'onclick="nextPrev(1)"'} type="button" class="dataDate mb-2 w-100 btn ${isBooked ? 'btn-warning' : (isOffDay ? 'btn-danger' : (isCurrentDay || isNext24Hours ? 'btn-warning' : 'btn-success'))}">10:30`;
              modalContent += isBooked ? ' (Booked)</button><br>' : (isOffDay ? ' (Off Day)</button><br>' : (isCurrentDay || isNext24Hours ? ' (Not Available)</button><br>' : ' (Available)</button><br>'));
              
              // Loop through the rest of the time slots from 11:00 AM to 6:00 PM
              for (var hour = 11; hour <= 18; hour++) {
                  // Set the time slot for each hour starting at 11:00 AM
                  startTime = `${stylistSchedule.date}T${hour.toString().padStart(2, '0')}:00:00`;
                  console.log(startTime);
              
                  // Check if the time slot is booked
                  isBooked = stylistSchedule.booked.some(slot => slot.start === startTime);
                  isOffDay = stylistSchedule.offDays.includes(stylistSchedule.date);
                  isCurrentDay = dateFormatted === currentFormattedDate;
                  isNext24Hours = dateFormatted === next24HoursFormattedDate;
              
                  // Format the time slot and add it to the modal content
                  modalContent += `<button data-date="${dateFormatted}, ${hour}:00" data-bs-dismiss="modal" ${isCurrentDay || isNext24Hours ? '' : 'onclick="nextPrev(1)"'} type="button" class="dataDate mb-2 w-100 btn ${isBooked ? 'btn-warning' : (isOffDay ? 'btn-danger' : (isCurrentDay || isNext24Hours ? 'btn-warning' : 'btn-success'))}">${hour}:00`;
                  modalContent += isBooked ? ' (Booked)</button><br>' : (isOffDay ? ' (Off Day)</button><br>' : (isCurrentDay || isNext24Hours ? ' (Not Available)</button><br>' : ' (Available)</button><br>'));
              }
          } else {
            for (var hour = 10; hour <= 21; hour++) {
            var startTime = `${stylistSchedule.date}T${hour.toString().padStart(2, '0')}:00:00`;
            // var endTime = `${stylistSchedule.date}T${(hour + 1).toString().padStart(2, '0')}:00:00`;
            console.log(startTime)
        
            // Check if the time slot is booked
            // var isBooked = stylistSchedule.booked.some(slot => (slot.start <= startTime && slot.end > startTime));
            var isBooked = stylistSchedule.booked.some(slot => slot.start === startTime);
            var isOffDay = stylistSchedule.offDays.includes(stylistSchedule.date);
            var isCurrentDay = dateFormatted === currentFormattedDate;
            var isNext24Hours = dateFormatted === next24HoursFormattedDate;
        
            // Format the time slot and add it to the modal content
            modalContent += `<button data-date="${dateFormatted}, ${hour}:00" data-bs-dismiss="modal" ${isCurrentDay || isNext24Hours ? '' : 'onclick="nextPrev(1)"'} type="button" class="dataDate mb-2 w-100 btn ${isBooked ? 'btn-warning' : (isOffDay ? 'btn-danger' : (isCurrentDay || isNext24Hours ? 'btn-warning' : 'btn-success'))}">${hour}:00`;
            modalContent += isBooked ? ' (Booked)</button><br>' : (isOffDay ? ' (Off Day)</button><br>' : (isCurrentDay || isNext24Hours ? ' (Not Available)</button><br>' : ' (Available)</button><br>'));
          }
          }
        
          // Update the modal content
          document.getElementById('eventTitle').innerHTML = modalContent;
          document.getElementById('exampleModalLabel').innerHTML = `Book Time Slot (${dateFormatted})`;
        
        }
        
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab
        
        function showTab(n) {
          // This function will display the specified tab of the form...
          var x = document.getElementsByClassName("tabBookingStep");
          x[n].style.display = "block";
          //... and fix the Previous/Next buttons:
          if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
          } else {
            document.getElementById("prevBtn").style.display = "inline";
          }
          if (n == (x.length - 1)) {
            document.getElementById("nextBtn").style.display = "inline";
          } else {
            document.getElementById("nextBtn").style.display = "none";
          }
          //... and run a function that will display the correct step indicator:
          fixStepIndicator(n);
        }
        
        function nextPrev(n) {
          // This function will figure out which tab to display
          var x = document.getElementsByClassName("tabBookingStep");
          // Exit the function if any field in the current tab is invalid:
          
          // Hide the current tab:
          x[currentTab].style.display = "none";
          // Increase or decrease the current tab by 1:
          currentTab = currentTab + n;
          // if you have reached the end of the form...
          if (currentTab >= x.length) {
            // ... the form gets submitted:
            document.getElementById("regForm").submit();
            return false;
          }
          var clickedButton = event.target;
          var dataDateValue = clickedButton.getAttribute('data-date');
          var dataLocationValue = clickedButton.getAttribute('data-location');
          var dataLocationNameValue = clickedButton.getAttribute('data-locationName');
          var dataServiceValue = clickedButton.getAttribute('data-service');
          var dataServiceDetailsValue = clickedButton.getAttribute('data-serviceDetails');
          var dataServiceDetailsIdValue = clickedButton.getAttribute('data-serviceId');
          var dataStylistValue = clickedButton.getAttribute('data-stylist');
          var dataStylistIdValue = clickedButton.getAttribute('data-stylist-id');

          let serviceDetails1Div = document.getElementById("serviceIdOne");
          let serviceDetails2Div = document.getElementById("serviceIdTwo")

          var datetimeInput = document.getElementById("datetime");
          var locationInput = document.getElementById("location");
          var locationInputName = document.getElementById("locationName");
          var serviceInput = document.getElementById("serviceDetails");
          var serviceInputId = document.getElementById("serviceDetailsId");
          var stylistInput = document.getElementById("stylist");
          var stylistIdInput = document.getElementById("stylistId");
          var fn = document.getElementById("fn");
          var ln = document.getElementById("ln");
          var email = document.getElementById("email");
          var phone = document.getElementById("phone");
          var bio = document.getElementById("bio");

          var datetimeInputVerify = document.querySelector(".datetimeInput");
          var locationInputVerify = document.querySelector(".locationInput");
          var serviceInputVerify = document.querySelector(".serviceInput");
          var stylistInputVerify = document.querySelector(".stylistInput");
          var fnVerify = document.querySelector(".fullnameInput");
          var emailVerify = document.querySelector(".emailInput");
          var phoneVerify = document.querySelector(".phoneInput");

          if (dataDateValue !== null) {
            console.log(dataDateValue)
            datetimeInput.value = dataDateValue;
            datetimeInputVerify.innerHTML = dataDateValue;
          }

          if (dataLocationValue !== null) {
            console.log(dataLocationValue)
            locationInput.value = dataLocationValue;
            locationInputName.value = dataLocationNameValue;
            locationInputVerify.innerHTML = dataLocationNameValue;
            console.log(dataLocationValue);

            $.ajax({
                url: '/get-services/' + dataLocationNameValue,
                type: 'GET',
                success: function (data) {
                    // Assuming you have a container with the ID 'serviceContainer'
                    $('#serviceIdOne').html(''); // Clear previous content
                    if (data.services.length > 0) {
                        $.each(data.services, function (index, service) {
                            var cardHtml = '<div class="card overflow-hidden border-0 shadow-sm card-hover mb-2">';
                            cardHtml += '<div class="row g-0">';
                            var serviceImage = service.selection_image ? '{{ asset('') }}' + service.selection_image : '';
                            if (service.selection_image !== null) {
                                cardHtml += '<div class="col-sm-4 bg-repeat-0" style="background-image: url(' + serviceImage + '); min-height: 12rem; background-size: cover; background-position: center;"></div>';
                            } else {
                                cardHtml += '<div class="col-sm-4 bg-repeat-0 bg-size-cover"></div>';
                            }
                            cardHtml += '<div class="col-sm-8">';
                            cardHtml += '<div class="card-body">';
                            cardHtml += '<h5 class="card-title">' + service.name + '</h5>';
                            cardHtml += '<p class="card-text fs-sm">RM' + service.charge_amount + '</p>';
                            cardHtml += '<button type="button" data-serviceDetails="' + service.name + '" data-serviceId="' + service.id + '" class="btn btn-sm btn-primary nextBtn getStylistsbtn" onclick="nextPrev(1)">Select This Service</button>';
                            cardHtml += '</div></div></div></div>';
                            $('#serviceIdOne').append(cardHtml);
                        });
                    } else {
                        // Handle case where no services are returned
                        $('#serviceIdOne').html('<p>No services available for the selected location and category.</p>');
                    }
                    // Continue with the logic for the next step or any additional actions
                },
                error: function (error) {
                    console.log(error);
                }
            });
          }

          if (dataServiceValue == "Hair Service") {
            console.log(dataServiceValue)
            serviceDetails1Div.style.display = "block";
            serviceDetails2Div.style.display = "none";
            
          } else if (dataServiceValue == "Lash Service") {
            console.log(dataServiceValue)
            serviceDetails1Div.style.display = "none";
            serviceDetails2Div.style.display = "block"
          }

          if (dataServiceDetailsValue !== null) {
            console.log(dataServiceDetailsValue)
            serviceInput.value = dataServiceDetailsValue;
            serviceInputId.value = dataServiceDetailsIdValue;
            serviceInputVerify.innerHTML = dataServiceDetailsValue;
          }

          if (dataStylistValue !== null) {
            console.log(dataStylistIdValue)
            stylistInput.value = dataStylistValue;
            stylistIdInput.value = dataStylistIdValue;

            stylistInputVerify.innerHTML = dataStylistValue;
          }

          
          
          fnVerify.innerHTML = fn.value + " " + ln.value;
          emailVerify.innerHTML = email.value;
          phoneVerify.innerHTML = phone.value;
          // Otherwise, display the correct tab:
          showTab(currentTab);
        }
        
        function fixStepIndicator(n) {
          var tabMenu = document.getElementById("account-menu");
        
          if (tabMenu) {
            for (var i = 0; i < tabMenu.children.length; i++) {
              if (i === n) {
                tabMenu.children[i].classList.add("active");
              } else {
                tabMenu.children[i].classList.remove("active");
              }
            }
          }
        }

      </script>
      <script>
        // Add event listener to the form submit event
        document.getElementById('regForm').addEventListener('submit', function(event) {
          // Prevent the default form submission behavior
          event.preventDefault();
    
          // Show loading overlay
          document.getElementById('loading-overlay').style.display = 'block';
    
          // Submit the form after a short delay to allow time for the loading overlay to appear
          setTimeout(function() {
            document.getElementById('regForm').submit();
          }, 500); // Adjust delay as needed
        });
      </script>
@endsection