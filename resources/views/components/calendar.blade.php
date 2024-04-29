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
            min-width: 4rem;
            min-height: 4rem;
            border: 1px solid black;
            display: flex;
            flex: 1;
        }

        #calendar td[data-date]:hover {
            background-color: #f29492;
            color: white !important;
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

        .cell:hover {
            color: white !important;
        }

        td {
            color: #f29492;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #114357;
            border-radius: 5px;
            height: 5rem;
        }

        table {
            border-spacing: 10px;
            /* Adjust the spacing between cells */
        }
    </style>

    <script>
        function htmlDecode(input) {
            var doc = new DOMParser().parseFromString(input, "text/html");
            return doc.documentElement.textContent;
        }

        function renderCell(cell, innerHTML, dayCounter) {
            cell.innerHTML = `
                <div class="cell flex flex-grow flex-col m-3">
                    <div class="flex flex-grow flex-left">
                        ${dayCounter}
                    </div>
                    ${innerHTML}
                    </div>
                `;

            return cell;
        }

        // try not to cringe
        @php
            $wearIcon = @svg('maki-clothing-store');
            $washIcon = @svg('iconpark-washingmachine');
        @endphp

        const wearIcon = `{{ $wearIcon }}`;
        const washIcon = `{{ $washIcon }}`;

        function formatDate(dateString) {
            const [year, month, day] = dateString.split('-');
            const formattedMonth = String(month).padStart(2, '0');
            const formattedDay = String(day).padStart(2, '0');
            return `${year}-${formattedMonth}-${formattedDay}`;
        }

        let today = moment();
        let schedule = JSON.parse(htmlDecode(@json($schedule)));
        console.log("og", [schedule]);

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

                    const date = formatDate(`${year}-${month + 1}-${dayCounter}`);
                    console.log(schedule);
                    const daySchedule = schedule.filter(s => {
                        return s.date === date;
                    });

                    let innerHTML = `<div class="flex flex-grow justify-evenly items-center">
                                    <div class="flex w-max text-sm cell">No event</div>
                                </div>
                                `;
                    cell = renderCell(cell, innerHTML, dayCounter);

                    if (daySchedule.length) {
                        if (daySchedule.some(s => s.type === 'wear') && daySchedule.some(s => s.type === 'wash')) {
                            cell = renderCell(cell, `
                                    <div class=" flex flex-grow justify-evenly items-center">
                                        <div class="flex w-10 cell">${wearIcon}</div>
                                        <div class="flex w-10 cell">${washIcon}</div>
                                    </div>
                                    `, dayCounter);
                        } else if (daySchedule.some(s => s.type === 'wear')) {
                            cell = renderCell(cell, `
                                    <div class=" flex flex-grow justify-evenly items-center">
                                        <div class="flex w-10 cell">${wearIcon}</div>
                                    </div>
                                    `, dayCounter);
                        } else if (daySchedule.some(s => s.type === 'wash')) {
                            cell = renderCell(cell, `
                                    <div class=" flex flex-grow justify-evenly items-center">
                                        <div class="flex w-10 cell">${washIcon}</div>
                                    </div>
                                    `, dayCounter);
                        }

                    }

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
                        const date = formatDate(`${year}-${month + 1}-${dayCounter}`);

                        console.log(schedule);
                        const daySchedule = schedule.filter(s => {
                            return s.date === date;
                        });

                        let innerHTML = `<div class=" flex flex-grow justify-evenly items-center">
                                    <div class="flex w-max text-sm cell">No event</div>
                                </div>
                                `;
                        cell = renderCell(cell, innerHTML, dayCounter);

                        if (daySchedule.length) {
                            if (daySchedule.some(s => s.type === 'wear') && daySchedule.some(s => s.type === 'wash')) {
                                cell = renderCell(cell, `
                                    <div class="flex flex-grow justify-evenly items-center">
                                        <div class=" flex w-10 cell">${wearIcon}</div>
                                        <div class="flex w-10 cell">${washIcon}</div>
                                    </div>
                                    `, dayCounter);
                            } else if (daySchedule.some(s => s.type === 'wear')) {
                                cell = renderCell(cell, `
                                    <div class="flex flex-grow justify-evenly items-center">
                                        <div class="flex w-10 cell">${wearIcon}</div>
                                    </div>
                                    `, dayCounter);
                            } else if (daySchedule.some(s => s.type === 'wash')) {
                                cell = renderCell(cell, `
                                    <div class="flex flex-grow justify-evenly items-center">
                                        <div class="flex w-10 cell">${washIcon}</div>
                                    </div>
                                    `, dayCounter);
                            }

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

        // little hack for event bubbling
        function handleCellClick(event) {
            let target = event.target;
            while (target !== null && !target.getAttribute('data-date')) {
                target = target.parentElement;
            }

            if (target !== null) {
                window.location.href = `/schedule/${target.getAttribute('data-date')}`;
            }
        }

        generateCalendar(moment());
    </script>
</div>
