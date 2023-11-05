import moment from "moment";

/**
 * Makes a datetime duration more readable to humans
 * 
 * @param {string} start 
 * @param {string} stop 
 * @returns {string}
 */
export function humanizeDatetimeDuration(start, stop) {
    const momentStart = moment(start, moment.ISO_8601, true);
    const momentStop = moment(stop, moment.ISO_8601, true);

    if(!momentStart.isValid() || !momentStop.isValid()){
        console.error('Unsupported date format');
        return start + ' to ' + stop;
    }

    if(momentStart.get(momentStop, 'day')){
        // The start and stop date is on the same day which
        // means we don't have to print the date twice.
        // Return eg. Sunday 5 November 2023, 14:00 to 15:00
        return momentStart.format('dddd D MMMM YYYY') + ', ' 
                + momentStart.format('HH:MM') + ' to ' 
                + momentStop.format('HH:MM');
    }

    // Returns eg. Sunday 5 November 2023 14:00 to Monday 6 November 2023 15:00
    return momentStart.format('dddd D MMMM YYYY HH:MM') + ' to ' 
            + momentStop.format('dddd D MMMM YYYY HH:MM');
}
