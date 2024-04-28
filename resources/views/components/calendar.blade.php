<div class="flex flex-grow flex-col">
    <h2 class="flex flex-grow" id="month-year"></h2>
    <table class="flex flex-grow flex-col" id="calendar">
        <thead>
            <tr></tr>
        </thead>
        <tbody class="flex flex-col"></tbody>
    </table>
    <div class="flex flex-grow flex-row justify-between items-start">
        <div class="flex flex-grow flex-column items-end"> <!-- Changed flex-direction to column -->
            <button class="dark" onclick="prevMonth()">Previous Month</button>
        </div>
        <div class="flex flex-column flex-end"> <!-- Changed flex-direction to column -->
            <button class="pink" onclick="nextMonth()">Next Month</button>
        </div>
    </div>

    <style>
        #calendar td {
            padding: 1rem;
            min-width: 4rem;
            min-height: 4rem;
            border: 1px solid black;
        }

        #calendar td[data-date]:hover {
            background-color: #f29492;
            color: white;
            cursor: pointer;
        }

        #calendar td {}

        tr {
            display: flex;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            margin: 5px;
            flex: 1;
        }

        td {
            color: #f29492;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #114357;
            border-radius: 5px;
        }

        table {
            border-spacing: 10px;
            /* Adjust the spacing between cells */
        }
    </style>

    <script>
        let today = moment();

        console.log(@json($val))

        function generateCalendar() {
            var month = today.month();
            var year = today.year();
            var day = today.date();
            var daysInMonth = today.daysInMonth();
            var firstDayOfMonth = moment(today).startOf('month');
            var startingDayOfWeek = firstDayOfMonth.day();

            var table = document.getElementById("calendar");
            var tbody = table.querySelector("tbody");
            table.querySelector("thead tr").innerHTML = '';

            moment.weekdaysShort().forEach(function(day) {
                var th = document.createElement("th");
                th.textContent = day;
                table.querySelector("thead tr").appendChild(th);
            });

            tbody.innerHTML = '';

            var row = tbody.insertRow();
            var dayCounter = 1;
            for (var i = 0; i < 7; i++) {
                var cell = row.insertCell();
                if (i >= startingDayOfWeek) {
                    cell.textContent = dayCounter;

                    // if the day is today, highlight it
                    if (dayCounter === day) {
                        cell.style.backgroundColor = '#f29492';
                        cell.style.color = 'white';
                    }
                    // add event listener to cell
                    cell.addEventListener('click', handleCellClick);
                    cell.setAttribute('data-date', `${year}-${month + 1}-${dayCounter}`);
                    dayCounter++;

                }
            }

            for (var i = 1; i < 6; i++) {
                var newRow = tbody.insertRow();
                var rowHasContent = false;

                for (var j = 0; j < 7; j++) {
                    var cell = newRow.insertCell();
                    if (dayCounter <= daysInMonth) {
                        cell.textContent = dayCounter;
                        // add event listener to cell
                        // if the day is today, highlight it
                        if (dayCounter === day) {
                            cell.style.backgroundColor = '#f29492';
                            cell.style.color = 'white';
                        }

                        cell.addEventListener('click', handleCellClick);
                        cell.setAttribute('data-date', `${year}-${month + 1}-${dayCounter}`);
                        dayCounter++;
                        rowHasContent = true;
                    }
                }
                if (!rowHasContent) {
                    newRow.style.display = 'none';
                }
            }
            document.getElementById("month-year").textContent = today.format('MMMM YYYY');
        }

        function prevMonth() {
            today = today.subtract(1, 'month');
            generateCalendar(today);
        }

        function nextMonth() {
            today = today.add(1, 'month');
            generateCalendar(today);
        }

        function handleCellClick(event) {
            // go to /schedule/{day}
            window.location.href = `/schedule/${event.target.getAttribute('data-date')}`;
        }

        generateCalendar(moment());
    </script>
</div>
