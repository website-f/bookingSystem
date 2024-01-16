@extends('client-main')

@section('title', 'Booking')
    
@section('content')
    <!-- Page content -->
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

            <form id="regForm" action="#">
              <!-- One "tab" for each step in the form: -->
              <div class="tabBookingStep"> 
                <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
                  <h1 class="h2 pt-xl-1 pb-3">Location Selection</h1>
                  <input type="hidden" name="location" id="location">
    
                  <div class="card overflow-hidden border-0 shadow-sm card-hover">
                    <div class="row g-0">
                      <div class="col-sm-4 bg-repeat-0 bg-size-cover" style="background-image: url({{asset('/client/assets/img/team/01.jpg')}}); min-height: 12rem;"></div>
                      <div class="col-sm-8">
                        <div class="card-body">
                          <h5 class="card-title">Card title</h5>
                          <p class="card-text fs-sm">Some quick example text to build on the card title and make up the bulk of the card's content within card's body.</p>
                          <button type="button" data-location="location" class="btn btn-sm btn-primary nextBtn"  onclick="nextPrev(1)">Select This Location</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
              <div class="tabBookingStep">
                 <!--Service------------------------>
                <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
                  <h1 class="h2 pt-xl-1 pb-3">Service Selection</h1>
                  <input type="hidden" id="service">
                  <div class="card overflow-hidden border-0 shadow-sm card-hover mb-2">
                    <div class="row g-0">
                      <div class="col-sm-4 bg-repeat-0 bg-size-cover" style="background-image: url({{asset('/client/assets/img/team/01.jpg')}}); min-height: 12rem;"></div>
                      <div class="col-sm-8">
                        <div class="card-body">
                          <h5 class="card-title">Card title1</h5>
                          <p class="card-text fs-sm">Some quick example text to build on the card title and make up the bulk of the card's content within card's body.</p>
                          <button type="button" data-service="service1" class="btn btn-sm btn-primary nextBtn"  onclick="nextPrev(1)">Select This Location</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="card overflow-hidden border-0 shadow-sm card-hover">
                    <div class="row g-0">
                      <div class="col-sm-4 bg-repeat-0 bg-size-cover" style="background-image: url({{asset('/client/assets/img/team/01.jpg')}}); min-height: 12rem;"></div>
                      <div class="col-sm-8">
                        <div class="card-body">
                          <h5 class="card-title">Card title2</h5>
                          <p class="card-text fs-sm">Some quick example text to build on the card title and make up the bulk of the card's content within card's body.</p>
                          <button type="button" data-service="service2" class="btn btn-sm btn-primary nextBtn"  onclick="nextPrev(1)">Select This Location</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
              <div class="tabBookingStep">
                <!--Service Details------------------------>
                <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
                  <h1 class="h2 pt-xl-1 pb-3">Service Selection Details</h1>
                  <input type="hidden" id="serviceDetails" name="serviceDetails">
                  <div id="serviceIdOne">
                    <div class="card overflow-hidden border-0 shadow-sm card-hover mb-2">
                      <div class="row g-0">
                        <div class="col-sm-4 bg-repeat-0 bg-size-cover" style="background-image: url({{asset('/client/assets/img/team/01.jpg')}}); min-height: 12rem;"></div>
                        <div class="col-sm-8">
                          <div class="card-body">
                            <h5 class="card-title">Card title 1</h5>
                            <p class="card-text fs-sm">Some quick example text to build on the card title and make up the bulk of the card's content within card's body.</p>
                            <button type="button" data-serviceDetails="serviceDetails1" class="btn btn-sm btn-primary nextBtn"  onclick="nextPrev(1)">Select This Location</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="serviceIdTwo">
                    <div class="card overflow-hidden border-0 shadow-sm card-hover">
                      <div class="row g-0">
                        <div class="col-sm-4 bg-repeat-0 bg-size-cover" style="background-image: url({{asset('/client/assets/img/team/01.jpg')}}); min-height: 12rem;"></div>
                        <div class="col-sm-8">
                          <div class="card-body">
                            <h5 class="card-title">Card title 2</h5>
                            <p class="card-text fs-sm">Some quick example text to build on the card title and make up the bulk of the card's content within card's body.</p>
                            <button type="button" data-serviceDetails="serviceDetails2" class="btn btn-sm btn-primary nextBtn"  onclick="nextPrev(1)">Select This Location</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
              <div class="tabBookingStep">
                <!--Stylist------------------------>
                <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
                  <h1 class="h2 pt-xl-1 pb-3">Select Stylist</h1>
                  <input type="hidden" id="stylist" name="stylist">
    
                  <div class="card overflow-hidden border-0 shadow-sm card-hover">
                    <div class="row g-0">
                      <div class="col-sm-4 bg-repeat-0 bg-size-cover" style="background-image: url({{asset('/client/assets/img/team/01.jpg')}}); min-height: 12rem;"></div>
                      <div class="col-sm-8">
                        <div class="card-body">
                          <h5 class="card-title">Card title</h5>
                          <p class="card-text fs-sm">Some quick example text to build on the card title and make up the bulk of the card's content within card's body.</p>
                          <button type="button" data-stylist="stylist" class="btn btn-sm btn-primary nextBtn"  onclick="nextPrev(1)">Select This Location</button>
                        </div>
                      </div>
                    </div>
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
                  <button type="submit" class="btn btn-success" id="nextBtn" onclick="nextPrev(1)">Submit</button>
                </div>
              </div>
              
            </form>
          </div>
        </div>
      </section>
      <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
      <script>

        document.addEventListener('DOMContentLoaded', function() {
          function switchTab() {
            calendar.render()
          }
      
          let nextBtns = document.querySelectorAll(".nextBtn");

          nextBtns.forEach(function(nextBtn) {
            nextBtn.addEventListener('click', function() {
              switchTab();
            })
           })
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
        
          // Simulate an asynchronous call
          setTimeout(function() {
            var data = {
              date: dateString,
              availability: [
                { start: dateString + 'T10:00:00', end: dateString + 'T12:00:00' },
                // ... other available time slots ...
              ],
              booked: [
                { start: '1-13-2024' + 'T13:00:00', end: '1-13-2024' + 'T14:00:00' },
                { start: '1-14-2024' + 'T11:00:00', end: '1-14-2024' + 'T12:00:00' }
                // ... other booked time slots ...
              ],
              offDays: [
                '1-15-2024', // Example off day
                '1-20-2024',
                '2-25-2024',
                // ... other off days ...
              ]
            };
        
            callback(data); // Invoke the callback with stylist data
          }, 0); // Simulate a delay of 1 second, replace with your actual data fetching logic
        }
        
        
        function updateDayGridColors(stylistSchedule) {
        
          var daygrid = document.querySelectorAll(".fc-daygrid-day");
          
          daygrid.forEach(element => {
            var daygridDate = element.getAttribute("data-date")
             // Parse the date using the Date object
             const parsedDate = new Date(daygridDate);
        
             // Format the date as "M-D-YYYY"
            const formattedDate = `${parsedDate.getMonth() + 1}-${parsedDate.getDate()}-${parsedDate.getFullYear()}`;
        
            var isOffDay = stylistSchedule.offDays.includes(formattedDate);
            
        
            if (isOffDay) {
              // Access the <a> element within the <td> and set styles
              var dayNumberElement = element.querySelector('.fc-daygrid-day-number');
              dayNumberElement.style.textDecoration = "underline solid red 50%";
            } else {
              // Access the <a> element within the <td> and set styles
              var dayNumberElement = element.querySelector('.fc-daygrid-day-number');
              dayNumberElement.style.textDecoration = "underline solid rgb(6, 187, 6) 50%";
            }
            
            
          });
          
        
        }
        
      
        function updateModalContent(stylistSchedule, date) {
          // Implement logic to update modal content based on availability
          var modalContent = '';
          var dateFormatted = date.toLocaleDateString('en-GB', { day: 'numeric', month: 'numeric', year: 'numeric' });
          // Example: Check each hour from 10 AM to 7 PM
          for (var hour = 10; hour <= 21; hour++) {
            var startTime = `${stylistSchedule.date}T${hour.toString().padStart(2, '0')}:00:00`;
            var endTime = `${stylistSchedule.date}T${(hour + 1).toString().padStart(2, '0')}:00:00`;
        
            // Check if the time slot is booked
            var isBooked = stylistSchedule.booked.some(slot => (slot.start <= startTime && slot.end > startTime));
            var isOffDay = stylistSchedule.offDays.includes(stylistSchedule.date);
        
            // Format the time slot and add it to the modal content
            modalContent += `<button data-date="${dateFormatted} , ${hour}:00 - ${(hour + 1)}:00" data-bs-dismiss="modal" onclick="nextPrev(1)" type="button" class="dataDate mb-2 w-100 btn ${isBooked ? 'btn-warning' : (isOffDay ? 'btn-danger' : 'btn-success')}">${hour}:00 - ${(hour + 1)}:00`;
            modalContent += isBooked ? ' (Booked)</button><br>' : (isOffDay ? ' (Off Day)</button><br>' : ' (Available)</button><br>');
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
          var dataServiceValue = clickedButton.getAttribute('data-service');
          var dataServiceDetailsValue = clickedButton.getAttribute('data-serviceDetails');
          var dataStylistValue = clickedButton.getAttribute('data-stylist');

          let serviceDetails1Div = document.getElementById("serviceIdOne");
          let serviceDetails2Div = document.getElementById("serviceIdTwo")

          var datetimeInput = document.getElementById("datetime");
          var locationInput = document.getElementById("location");
          var serviceInput = document.getElementById("serviceDetails");
          var stylistInput = document.getElementById("stylist");
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
            locationInputVerify.innerHTML = dataLocationValue;
          }

          if (dataServiceValue == "service1") {
            console.log(dataServiceValue)
            serviceDetails1Div.style.display = "block";
            serviceDetails2Div.style.display = "none";
            
          } else if (dataServiceValue == "service2") {
            console.log(dataServiceValue)
            serviceDetails1Div.style.display = "none";
            serviceDetails2Div.style.display = "block"
          }

          if (dataServiceDetailsValue !== null) {
            console.log(dataServiceDetailsValue)
            serviceInput.value = dataServiceDetailsValue;
            serviceInputVerify.innerHTML = dataServiceDetailsValue;
          }

          if (dataStylistValue !== null) {
            console.log(dataStylistValue)
            stylistInput.value = dataStylistValue;
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
@endsection