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


reservationGuestQuantity.addEventListener('change', () => {
    document.querySelector('.show-reservation-div').classList.remove('hideDiv');
    reservationGuestQuantity.setAttribute('disabled', 'true');
})

const checkPlaces = async () => {
    try {
        const response = await  fetch('https://127.0.0.1:8000/api/reservations')
        const data = await response.json();
        if(!response.ok) {
            console.log(response.status);
            return;
        }

        let phpDate = reservationDay.value;

        const hoursForReservationDay = data.map(element => {
            if (element.reservationDay.substring(0,10) == phpDate) {
                return element.reservationTime;
            } else {
                return null;
            }
        })

        const cleanHours = hoursForReservationDay.filter((e)=>{
            return e !== null;
        })

        const hoursTab = cleanHours.map(e => {
            return e.substring(0,2);
        })

        const beforeMidiHours = hoursTab.filter((e) => {
            return e < 17;
        })

        const afterMidiHours = hoursTab.filter((e) => {
            return e > 17;
        })


        // display vailable hors
        const availableDayPlaces = 30 - hoursTab.length;
        const midiAvailablePlaces = 30 - beforeMidiHours.length;
        const soirAvailablePlaces = 30 - afterMidiHours.length;

        let htmlTextForDay = '<p class="mt-3">' + availableDayPlaces + ' places disponibles à cette date</p>'
        document.querySelector('.day-available-places').innerHTML = htmlTextForDay;

        let htmlTextForMidi = '<p class="mt-3">' + midiAvailablePlaces + ' places disponibles pour ce créneaux</p>'
        document.querySelector('.midi-available-places').innerHTML = htmlTextForMidi;

        let htmlTextForSoir = '<p class="mt-3">' + soirAvailablePlaces + ' places disponibles pour ce créneaux</p>'
        document.querySelector('.soir-available-places').innerHTML = htmlTextForSoir;

    } catch (e) {
        console.log(e);
    }
}

//selecting the day name of the reservation day
reservationDay.addEventListener('change', (e) => {
    let phpDate = e.target.value;
    //console.log(phpDate);
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

    try {
        const response = await fetch('https://127.0.0.1:8000/api/weekDays');
        const data = await response.json();

        if(!response.ok) {
            console.log(response.status);
            return;
        }
        //console.log(data);

        const apiDataForReservationDay = data.find(({title}) => title === reservationDayName);
        //console.log(apiDataForReservationDay);

        if (apiDataForReservationDay.open) {
            reservationTimeOfDay.classList.remove('hideDiv');
            reservationDay.setAttribute('disabled', 'true');
            document.querySelector('.day-available-places').classList.remove('hideDiv');

            let schedules = apiDataForReservationDay.dailySchedule;
            //console.log(schedules);

            if (schedules.length > 1) {
                reservationTimeOfDay.classList.remove('hideDiv');
                reservationMidi.addEventListener('click', () => {
                    reservationTime.classList.remove('hideDiv');
                    document.querySelector('.midi-available-places').classList.remove('hideDiv');
                    //console.log(schedules[0]);
                    let schedule = getFormatSchedule(schedules[0]);
                    displayArrivalTimeDiv(schedule);
                });

                reservationSoir.addEventListener('click', () => {
                    reservationTime.classList.remove('hideDiv');
                    document.querySelector('.soir-available-places').classList.remove('hideDiv');
                    //console.log(schedules[1]);
                    let schedule = getFormatSchedule(schedules[1]);
                    displayArrivalTimeDiv(schedule);
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
    //checkPlaces();

};

reservationDayRadioYes.addEventListener('click', handleSchedule);
reservationDayRadioYes.addEventListener('click', checkPlaces);

//
reservationDayRadioNon.addEventListener('click', () => {
    reservationDay.removeAttribute('disabled');
    reservationTimeOfDay.classList.add('hideDiv');
    reservationTime.classList.add('hideDiv');
    closeMessage.classList.add('hideDiv');
    validation.classList.add('hideDiv');
    document.querySelector('.day-available-places').classList.add('hideDiv');
})

// reservationTime.addEventListener('click', () => {
//     if(reservationGuestQuantity.value == '') {
//         reservationGuestQuantity.focus();
//         reservationTime.setAttribute('disabled', 'true');
//         alert('Vous devez remplir ce champ');
//     } else {
//         return;
//     }
// })
// reservationGuestQuantity.addEventListener('click', ()=> {
//     reservationTime.removeAttribute('disabled');
// })

reservationTime.addEventListener('change', ()=>{
    validation.classList.remove('hideDiv');
    reservationTime.options[reservationTime.options.selectedIndex].setAttribute('selected', 'selected');
    reservationTimeInputField.value = reservationTime.options[reservationTime.selectedIndex].value;
})



validation.addEventListener('click', () => {
        formReservationTime.classList.remove('hideDiv');
        secondaryForm.classList.remove('hideDiv');
        reservationBtn.classList.remove('hideDiv');
        reservationDate.remove();
        reservationTimeOfDay.remove();
        validation.remove();
        reservationTimeInputField.setAttribute('disabled', 'true');
        //reservationGuestQuantity.setAttribute('disabled', 'true');
        reservationTime.remove();
})

reservationBtn.addEventListener('click', () => {
    reservationDay.removeAttribute('disabled');
    reservationTimeInputField.removeAttribute('disabled');
    reservationGuestQuantity.removeAttribute('disabled');

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

    reservationTime.innerHTML = htmlDiv;
}




