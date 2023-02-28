const reservationDay = document.querySelector('#reservation_reservationDay');
const dayNameField = document.querySelector(".day-name-field");
//const dayField = document.querySelector('.day-field');
const reservationDayRadioYes = document.querySelector('#reservationDayRadioYes');
//const reservationDayRadioNon = document.querySelector('#reservationDayRadioNon');
//const reservationMidi = document.querySelector('#reservationMidi');
//const reservationSoir =document.querySelector('#reservationSoir');
const reservationDate = document.querySelector('#reservationDate');
const reservationTimeOfDay =document.querySelector('#reservationTimeOfDay');
const closeMessage = document.querySelector('.close-message');
const reservationTime = document.querySelector('#reservationTime');
//const formReservationTime = document.querySelector('.form-reservation-time');
const validation = document.querySelector('#validation');
const reservationBtn = document.querySelector('.reservation-btn');
//const secondaryForm = document.querySelector('.secondary-display');
const reservationTimeInputField = document.querySelector('#reservation_reservationTime');
const reservationGuestQuantity = document.querySelector('#reservation_guestQuantity');
const maxCapacity = document.querySelector('#max-capacity').textContent;


let API_HOST;
const loadEnv = async () => {
    try {
        const response = await  fetch(`config/.env`)
        const data = await response.json();
        if(!response.ok) {
            console.log(response.status);
            return;
        }

        API_HOST = data.API_HOST;


    } catch(e) {
        console.log(e)
    }
}
window.addEventListener('load', loadEnv);

//on change of number of guests input, show date of reservation input and disable number of guests input
reservationGuestQuantity.addEventListener('change', () => {
    document.querySelector('.show-reservation-div').classList.remove('hideDiv');
    reservationGuestQuantity.setAttribute('disabled', 'true');
})

//call API reservations
//checks if the restaurant is open once or twice for the chosen date
//checks available places for the chosen date
//add available places inputs in hidden div outside the form
const checkPlaces = async () => {
    try {//'/labouchedesgouts/api/reservations'
        const response = await  fetch(`${API_HOST}/reservations`)
        const data = await response.json();
        if(!response.ok) {
            console.log(response.status);
            return;
        }

        let phpDate = reservationDay.value;

        const hoursForReservationDay = data.map(element => {
            if (element.reservationDay.substring(0,10) === phpDate) {
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

        let htmlTextForDay = '<p class="mt-3 reservation-messages-text">' + availableDayPlaces + ' places disponibles à cette date</p>'
        document.querySelector('.day-available-places').innerHTML = htmlTextForDay;

        let htmlTextForMidi = '<p class="mt-3 reservation-messages-text">' + midiAvailablePlaces + ' places disponibles pour ce créneaux</p>'
        document.querySelector('.midi-available-places').innerHTML = htmlTextForMidi;

        let htmlTextForSoir = '<p class="mt-3 reservation-messages-text">' + soirAvailablePlaces + ' places disponibles pour ce créneaux</p>'
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
    document.querySelector('.day-field').textContent = reservationDay;

});



//call API weekDays
//if restaurant is open, check if it's open once or twice, if not ask chose new data
//show available places in every case
//disable arrival hours select input in case the number of guest is > to available places
//(using available places inputs in hidden div outside the form)
const handleSchedule = async () => {

    let reservationDayName = dayNameField.textContent;

    try {//'/labouchedesgouts/api/weekDays'
        const response = await fetch(`${API_HOST}/weekDays`);
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
                if((document.querySelector('.availableDayPlaces').value)*1 < (reservationGuestQuantity.value)*1) {
                    document.querySelector('.day-available-places').classList.remove('hideDiv');
                    reservationTime.setAttribute('disabled', 'true');
                    alert('Action impossible, nombre de places disponibles insuffisant.');//test
                } else {
                    reservationTime.removeAttribute('disabled');
                }
            }

            if (schedules.length > 1) {
                reservationTimeOfDay.classList.remove('hideDiv');
                document.querySelector('#reservationMidi').addEventListener('click', () => {
                    if((reservationGuestQuantity.value)*1 <= (document.querySelector('.midiAvailablePlaces').value)*1){
                        reservationTime.classList.remove('hideDiv');
                        document.querySelector('.midi-available-places').classList.remove('hideDiv');
                        let schedule = getFormatSchedule(schedules[0]);
                        displayArrivalTimeDiv(schedule);
                    } else {
                        reservationTime.setAttribute('disabled', 'true');
                        reservationTime.classList.remove('hideDiv');
                        document.querySelector('.midi-available-places').classList.remove('hideDiv');
                        alert('Action impossible, nombre de places disponibles insuffisant.');//test
                    }
                });

                document.querySelector('#reservationSoir').addEventListener('click', () => {
                    if((reservationGuestQuantity.value)*1 <= (document.querySelector('.soirAvailablePlaces').value)*1){
                        reservationTime.classList.remove('hideDiv');
                        document.querySelector('.soir-available-places').classList.remove('hideDiv');
                        let schedule = getFormatSchedule(schedules[1]);
                        displayArrivalTimeDiv(schedule);
                    } else {
                        reservationTime.classList.remove('hideDiv');
                        reservationTime.setAttribute('disabled', 'true');
                        document.querySelector('.soir-available-places').classList.remove('hideDiv');
                        alert('Action impossible, nombre de places disponibles insuffisant.');//test
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

//reset to make new choice of reservation day
document.querySelector('#reservationDayRadioNon').addEventListener('click', () => {
    reservationDay.removeAttribute('disabled');
    reservationTimeOfDay.classList.add('hideDiv');
    reservationTime.classList.add('hideDiv');
    closeMessage.classList.add('hideDiv');
    validation.classList.add('hideDiv');
    document.querySelector('.day-available-places').classList.add('hideDiv');
})

//when the hour of arrival is chosen, set attribute selected on the chosen option
//set the actual form input for arrival hour with the chosen option
//show a validation radio
reservationTime.addEventListener('change', ()=>{
    validation.classList.remove('hideDiv');
    reservationTime.options[reservationTime.options.selectedIndex].setAttribute('selected', 'selected');
    reservationTimeInputField.value = reservationTime.options[reservationTime.selectedIndex].value;
})

reservationTime.addEventListener('click', checkPlaces);

//when validation radio is checked only display form inputs
//show div with user personal infos
validation.addEventListener('click', () => {
        document.querySelector('.form-reservation-time').classList.remove('hideDiv');
        document.querySelector('.secondary-display').classList.remove('hideDiv');
        reservationBtn.classList.remove('hideDiv');
        reservationDate.remove();
        reservationTimeOfDay.remove();
        validation.remove();
        reservationTimeInputField.setAttribute('disabled', 'true');
        reservationTime.remove();
})

//enables all form fields
reservationBtn.addEventListener('click', () => {
    reservationDay.removeAttribute('disabled');
    reservationTimeInputField.removeAttribute('disabled');
    reservationGuestQuantity.removeAttribute('disabled');

})

//if user connected handle default choices
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

//format hour in case h:mm to 0h:00
Date.prototype.getFullMinutes = function () {
    if (this.getMinutes() < 10) {
        return '0' + this.getMinutes();
    }
    return this.getMinutes();
};

function formatTimeObject(date) {
    return(date.getHours() + ':' +date.getFullMinutes());
}


function addMinutes(date, minutes) {
    const dateCopy = new Date(date);

    dateCopy.setMinutes(date.getMinutes() + minutes);

    return dateCopy;
}


function subtractMinutes(date, minutes) {
    // make copy with "Date" constructor
    const dateCopy = new Date(date);

    dateCopy.setMinutes(date.getMinutes() - minutes);

    return dateCopy;
}

//format schedule array: return array of hours every 15min after opening time until closing time - 1h
//handles case of a reservation during current day opening hours
function getFormatSchedule (schedule) {
    let open = new Date(schedule.openingTime);
    let close = subtractMinutes(new Date(schedule.closingTime), 60);

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
        // if array of available hours is empty alert message 'to late'
        if ((availableOpenArray.filter(e => e.substring(0,2) > time)).length > 0){
            return availableOpenArray.filter(e => e.substring(0,2) > time);
        } else {
            alert ('Il est trop tard pour réserver une place sur ce créneau, le restaurant va bientôt fermer. Merci pour votre compréhension.');
            document.querySelector('#reservationTimeOfDay>.form-check>.form-check-input').setAttribute('disabled', 'true');
        }

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




