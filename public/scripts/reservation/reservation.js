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
const secondaryForm = document.querySelector('.secondary-display');
const reservationTimeInputField = document.querySelector('#reservation_reservationTime');
const reservationGuestQuantity = document.querySelector('#reservation_guestQuantity');
const maxCapacity = document.querySelector('#max-capacity').textContent;

const API_HOST = 'https://127.0.0.1:8000/api';

reservationGuestQuantity.addEventListener('change', () => {
    document.querySelector('.show-reservation-div').classList.remove('hideDiv');
    reservationGuestQuantity.setAttribute('disabled', 'true');
})

// const loadEnv = async () => {
//     try {
//         const response = await  fetch(`config/.env`)
//         const data = await response.json();
//         if(!response.ok) {
//             console.log(response.status);
//             return;
//         }
//         console.log(data);
//     } catch(e) {
//         console.log(e)
//     }
// }
// loadEnv()

const checkPlaces = async () => {
    try {//`${API_HOST}/reservations`
        const response = await  fetch('/labouchedesgouts/api/reservations')
        const data = await response.json();
        if(!response.ok) {
            console.log(response.status);
            return;
        }

        let phpDate = reservationDay.value;

        const hoursForReservationDay = data.map(element => {
            if (element.reservationDay.substring(0,10) == phpDate) {
                return [element.reservationTime, element.guestQuantity];
            } else {
                return null;
            }
        })

        const cleanHours = hoursForReservationDay.filter((e)=>{
            return e !== null;
        })

        const hoursTab = cleanHours.map(e => {
            return [e[0].substring(0,2), e[1]];
        })

        const beforeMidiHours = hoursTab.filter((e) => {
            return e[0] < 17;
        })

        const afterMidiHours = hoursTab.filter((e) => {
            return e[0] > 17;
        })
        const availableDayPlaces = maxCapacity -totalOfDayReservations(hoursTab);
        const midiAvailablePlaces = maxCapacity - totalOfDayReservations(beforeMidiHours);
        const soirAvailablePlaces = maxCapacity - totalOfDayReservations(afterMidiHours);

        let htmlTextForDay = '<p class="mt-3">' + availableDayPlaces + ' places disponibles à cette date</p>'
        document.querySelector('.day-available-places').innerHTML = htmlTextForDay;

        let htmlTextForMidi = '<p class="mt-3">' + midiAvailablePlaces + ' places disponibles pour ce créneaux</p>'
        document.querySelector('.midi-available-places').innerHTML = htmlTextForMidi;

        let htmlTextForSoir = '<p class="mt-3">' + soirAvailablePlaces + ' places disponibles pour ce créneaux</p>'
        document.querySelector('.soir-available-places').innerHTML = htmlTextForSoir;


        let inputArray = ['<input class="availableDayPlaces" value="' + availableDayPlaces + '">', '<input class="midiAvailablePlaces" value="' + midiAvailablePlaces + '">', '<input class="soirAvailablePlaces" value="' + soirAvailablePlaces + '">'];
        let htmlContent = '';
        inputArray.forEach(input => {
            htmlContent += input
        })
        document.querySelector('.usefully-data').innerHTML = htmlContent;
    } catch (e) {
        console.log(e);
    }
}

//selecting the day name of the reservation day
reservationDay.addEventListener('change', (e) => {
    let phpDate = e.target.value;

    reservationDate.classList.remove('hideDiv');

    const weekDayNames = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    const months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

    let reservationDayName = weekDayNames[getDayFromString(phpDate)[0]];
    let reservationDay = getDayFromString(phpDate)[1] + ' ' + months[getDayFromString(phpDate)[2]] + ' ?';

    dayNameField.textContent = reservationDayName;
    dayField.textContent = reservationDay;

});




const handleSchedule = async () => {

    let reservationDayName = dayNameField.textContent;

    try {//`${API_HOST}/weekDays`
        const response = await fetch('/labouchedesgouts/api/weekDays');
        const data = await response.json();

        if(!response.ok) {
            console.log(response.status);
            return;
        }

        const apiDataForReservationDay = data.find(({title}) => title === reservationDayName);

        if (apiDataForReservationDay.open) {

            let schedules = apiDataForReservationDay.dailySchedule;
            reservationTimeOfDay.classList.remove('hideDiv');
            reservationDay.setAttribute('disabled', 'true');

            if(schedules.length === 1) {
                document.querySelector('.day-available-places').classList.remove('hideDiv');

                if((document.querySelector('.availableDayPlaces').value)*1 < (reservationGuestQuantity.value)*1) {
                    reservationTime.setAttribute('disabled', 'true');
                } else {
                    reservationTime.removeAttribute('disabled');
                }
            }

            if (schedules.length > 1) {
                reservationTimeOfDay.classList.remove('hideDiv');
                reservationMidi.addEventListener('click', () => {
                    if((reservationGuestQuantity.value)*1 <= (document.querySelector('.midiAvailablePlaces').value)*1){
                        reservationTime.classList.remove('hideDiv');
                        document.querySelector('.midi-available-places').classList.remove('hideDiv');
                        let schedule = getFormatSchedule(schedules[0]);
                        displayArrivalTimeDiv(schedule);
                    } else {
                        reservationTime.setAttribute('disabled', 'true');
                        reservationTime.classList.remove('hideDiv');
                        document.querySelector('.midi-available-places').classList.remove('hideDiv');
                    }
                });

                reservationSoir.addEventListener('click', () => {
                    if((reservationGuestQuantity.value)*1 <= (document.querySelector('.soirAvailablePlaces').value)*1){
                        reservationTime.classList.remove('hideDiv');
                        document.querySelector('.soir-available-places').classList.remove('hideDiv');
                        let schedule = getFormatSchedule(schedules[1]);
                        displayArrivalTimeDiv(schedule);
                    } else {
                        reservationTime.classList.remove('hideDiv');
                        reservationTime.setAttribute('disabled', 'true');
                        document.querySelector('.soir-available-places').classList.remove('hideDiv');
                    }
                })

            } else {
                reservationTimeOfDay.classList.add('hideDiv');
                reservationTime.classList.remove('hideDiv');
                let schedule = getFormatSchedule(schedules[0]);
                displayArrivalTimeDiv(schedule);
            }

        } else if (!apiDataForReservationDay.open) {
            closeMessage.classList.remove('hideDiv');
            reservationDay.setAttribute('disabled', 'true');
        }

     }catch (error) {
        console.log(error);
    }
};


reservationDayRadioYes.addEventListener('click', checkPlaces);
reservationDayRadioYes.addEventListener('click', handleSchedule);



//
reservationDayRadioNon.addEventListener('click', () => {
    reservationDay.removeAttribute('disabled');
    reservationTimeOfDay.classList.add('hideDiv');
    reservationTime.classList.add('hideDiv');
    closeMessage.classList.add('hideDiv');
    validation.classList.add('hideDiv');
    document.querySelector('.day-available-places').classList.add('hideDiv');
})

reservationTime.addEventListener('change', ()=>{
    validation.classList.remove('hideDiv');
    reservationTime.options[reservationTime.options.selectedIndex].setAttribute('selected', 'selected');
    reservationTimeInputField.value = reservationTime.options[reservationTime.selectedIndex].value;
})

reservationTime.addEventListener('click', checkPlaces);


validation.addEventListener('click', () => {
        formReservationTime.classList.remove('hideDiv');
        secondaryForm.classList.remove('hideDiv');
        reservationBtn.classList.remove('hideDiv');
        reservationDate.remove();
        reservationTimeOfDay.remove();
        validation.remove();
        reservationTimeInputField.setAttribute('disabled', 'true');
        reservationTime.remove();
})

reservationBtn.addEventListener('click', () => {
    reservationDay.removeAttribute('disabled');
    reservationTimeInputField.removeAttribute('disabled');
    reservationGuestQuantity.removeAttribute('disabled');

})

if(document.querySelector('#setUserDefaultChoice')){
    document.querySelector('#setUserDefaultChoice').addEventListener('click', () => {
        reservationGuestQuantity.value = document.querySelector('#setUserDefaultChoice').name;
        document.querySelector('.show-reservation-div').classList.remove('hideDiv');
        reservationGuestQuantity.setAttribute('disabled', 'true');
        document.querySelector('.userChoices').classList.add('hideDiv');
    })

    document.querySelector('#userNewChoice').addEventListener('click', () => {
        document.querySelector('.userChoices').classList.add('hideDiv');
    })

}


///////////////reservationUtils///////////////////
//

const totalOfDayReservations = (value) => {
    let sum = 0;
    value.forEach(element => {
        sum += element[1]
    })
    return sum;
}

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

    //adding 15min to open hour until close hour - 1 hour
    while (open < close) {
        open = addMinutes(open, 15);
        openArray.push(open);
    }

    //get current hour
    let today = new Date();
    let time = today.getHours();

    //getting the reservation day Timestamp
    let reservationDate = reservationDay.value;
    reservationDate = reservationDate.split("-");
    let newReservationDate = new Date( reservationDate[0], reservationDate[1] - 1, reservationDate[2]);

    if (Date.now() >= newReservationDate.getTime()){
        // display only hours > current hour
        let availableOpenArray = openArray.map(item =>formatTimeObject(item));
        return availableOpenArray.filter(e => e.substring(0,2) > time);
    } else {
        // display all hours
        return openArray.map(item =>formatTimeObject(item));
    }
}

// display select input with available reservation hours
function displayArrivalTimeDiv (schedule) {
    let htmlDiv = '<option value="">Veuillez choisir une heure d\'arrivée</option>';

    schedule.forEach(element => {
        htmlDiv += '<option value="' + element + '" class="me-2 schedule-proposal">' + element + '</option>';
    })

    reservationTime.innerHTML = htmlDiv;
}




