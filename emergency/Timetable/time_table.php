<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตารางเวลารถพยาบาล</title>
    <!-- โหลด jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- โหลด FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>
    <link rel="stylesheet" href="style_test.css">
</head>

<body>

    <!-- Title -->
    <div class="title">
        <h1>ตารางเวลารถพยาบาล</h1>
    </div>

    <div id="calendar"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                editable: true,
                selectable: true,
                timeZone: 'Asia/Bangkok',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
                eventDisplay: 'block', // แสดงข้อมูลแบบบล็อกในช่วงเวลา
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                events: {
                    url: 'fetch_events.php',
                    failure: function() {
                        alert('There was an error while fetching events!');
                    },
                    success: function(data) {
                        console.log('Fetched events:', data);
                        data.forEach(event => {
                            if (event.type === 'ambulance') {
                                event.color = 'red'; // ตั้งสีสำหรับ ambulance
                            } else if (event.type === 'event') {
                                event.color = 'green'; // ตั้งสีสำหรับ event
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching events:', error);
                        console.error('Response:', xhr.responseText);
                    }
                },
                select: function(info) {
                    var title = prompt('ใส่ชื่อรายการของคุณ:');
                    var type = prompt('ใส่ประเภทงาน (ambulance หรือ event):');

                    if (title && type) {
                        var eventData = {
                            title: title,
                            start: info.start.toISOString(),
                            end: info.end.toISOString(),
                            type: type
                        };
                        console.log('Event Data:', eventData);

                        calendar.addEvent(eventData);

                        $.ajax({
                            url: 'save_event.php',
                            method: 'POST',
                            data: {
                                title: eventData.title,
                                type: eventData.type,
                                start: eventData.start,
                                end: eventData.end
                            },
                            success: function(response) {
                                console.log(response);
                                alert('Event saved!');
                            },
                            error: function(xhr, status, error) {
                                console.error('Error saving event:', error);
                                console.error('Response:', xhr.responseText);
                                alert('There was an error while saving the event!');
                            }
                        });
                    }
                    calendar.unselect();
                }
            });
            calendar.render();
        });
    </script>
</body>

</html>