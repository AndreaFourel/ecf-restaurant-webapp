const reservationDay = document.querySelector('#reservation_reservationDay');
const dayNameField = document.querySelector(".day-name-field");
const dayField = document.querySelector('.day-field');
const reservationDayRadioYes = document.querySelector('#reservationDayRadioYes');
const reservationDayRadioNon = document.querySelector('#reservationDayRadioNon');
const reservationMidi = document.querySelector('#reservationMidi');
const reservationSoir =document.querySelector('#reservationSoir');

const reservationDate = document.querySelector('#reservationDate');
const reservationTimeOfDay =document.querySelector('#reservationTimeOfDay');
const closeMessage = document.querySelector('.close-message');

const reservationTime = document.querySelector('#reservationTime');
const formReservationTime = document.querySelector('.form-reservation-time');
const validation = document.querySelector('#validation');
const reservationBtn = document.querySelector('.reservation-btn');


//selecting the day name of the reservation day
reservationDay.addEventListener('change', (e) => {

    let phpDate = e.target.value;
    console.log(phpDate);
    reservationDate.classList.remove('hideDiv');

    const weekDayNames = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    const months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

    let reservationDayName = weekDayNames[getDayFromString(phpDate)[0]];
    let reservationDay = getDayFromString(phpDate)[1] + ' ' + months[getDayFromString(phpDate)[2]] + ' ?';

    dayNameField.textContent = reservationDayName;
    dayField.textContent = reservationDay;
    //reservationTimeOfDay.classList.remove('hideDiv');

});



const handleSchedule = async () => {

    let reservationDayName = dayNameField.textContent;

    try {
        const response = await fetch('https://127.0.0.1:8000/api/weekDays');
        const data = await response.json();

        if(!response.ok) {
            console.log(response.status);
            return;
        }
        console.log(data);

        const apiDataForReservationDay = data.find(({title}) => title === reservationDayName);
        console.log(apiDataForReservationDay);

        if (apiDataForReservationDay.open) {
            reservationTimeOfDay.classList.remove('hideDiv');
            reservationDay.setAttribute('disabled', 'true');

            let schedules = apiDataForReservationDay.dailySchedule;
            console.log(schedules);

            if (schedules.length > 1) {
                reservationTimeOfDay.classList.remove('hideDiv');
                reservationMidi.addEventListener('click', () => {
                    reservationTime.classList.remove('hideDiv');
                    console.log(schedules[0]);
                    let schedule = getFormatSchedule(schedules[0]);
                    displayArrivalTimeDiv(schedule);
                });

                reservationSoir.addEventListener('click', () => {
                    reservationTime.classList.remove('hideDiv');
                    console.log(schedules[1]);
                    let schedule = getFormatSchedule(schedules[1]);
                    displayArrivalTimeDiv(schedule);
                })

            } else {
                reservationTimeOfDay.classList.add('hideDiv');
                reservationTime.classList.remove('hideDiv');
                let schedule = getFormatSchedule(schedules[0]);
                displayArrivalTimeDiv(schedule);
            }

        } else {
            closeMessage.classList.remove('hideDiv');
        }

    }catch (error) {
        console.log(error);
    }
};

reservationDayRadioYes.addEventListener('click', handleSchedule);

reservationDayRadioNon.addEventListener('click', () => {
    reservationDay.removeAttribute('disabled');
    reservationTimeOfDay.classList.add('hideDiv');
    reservationTime.classList.add('hideDiv');
    closeMessage.classList.add('hideDiv');
})




///////////////reservationUtils///////////////////
//
function getDayFromString(dateString) {
    try {
        let year = dateString.substring(0, 4);
        let month = dateString.substring(5, 7);
        let day = dateString.substring(8, 10);
        let dayName = new Date(year, month - 1, day).getDay();
        let dayDate = new Date(year, month - 1, day).getDate();
        let dateMonth = new Date(year, month - 1, day).getMonth();
        return [dayName, dayDate, dateMonth];
    } catch (error) {
        return null;
    }
}

//
Date.prototype.getFullMinutes = function () {
    if (this.getMinutes() < 10) {
        return '0' + this.getMinutes();
    }
    return this.getMinutes();
};

//
function formatTimeObject(date) {
    return(date.getHours() + ':' +date.getFullMinutes());
}

//
function addMinutes(date, minutes) {
    const dateCopy = new Date(date);

    dateCopy.setMinutes(date.getMinutes() + minutes);

    return dateCopy;
}

//
function subtractMinutes(date, minutes) {
    // make copy with "Date" constructor
    const dateCopy = new Date(date);

    dateCopy.setMinutes(date.getMinutes() - minutes);

    return dateCopy;
}

//
function getFormatSchedule (schedule) {
    let open = subtractMinutes(new Date(schedule.openingTime), 60);
    let close = subtractMinutes(new Date(schedule.closingTime), 120);

    let openArray = [open];

    while (open < close) {
        open = addMinutes(open, 15);
        openArray.push(open);
    }

    return openArray.map(item =>formatTimeObject(item));
}


//
function displayArrivalTimeDiv (schedule) {
    let htmlDiv = '<option value="">Veuillez choisir une heure d\'arrivée</option>';
    console.log(schedule);

    schedule.forEach(element => {
        htmlDiv += '<option value="' + element + '" class="me-2 schedule-proposal">' + element + '</option>';
    })

    document.getElementById('reservationTime').innerHTML = htmlDiv;
}

reservationTime.addEventListener('change', ()=>{
    validation.classList.remove('hideDiv');
    reservationTime.options[reservationTime.options.selectedIndex].setAttribute('selected', 'selected');
    document.querySelector('#reservation_reservationTime').value = reservationTime.options[reservationTime.selectedIndex].value;
})

validation.addEventListener('click', () => {
    formReservationTime.classList.remove('hideDiv');
    reservationBtn.removeAttribute('disabled');
    reservationDate.remove();
    reservationTimeOfDay.remove();
    validation.remove();
    reservationDay.removeAttribute('disabled');
    reservationTime.remove();
})



