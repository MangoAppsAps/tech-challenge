const formatDateTimeRange = (start, end) => {
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
    };

    // TODO: In case there are services that goes longer than one entire day then we need to handle it later.
    const formattedStart = new Date(start).toLocaleDateString('en-GB', options, );
    const formattedEnd = new Date(end).toLocaleTimeString('en-GB', { hour: 'numeric', minute: 'numeric', hour12: false });
    return `${formattedStart} to ${formattedEnd}`;
}

export {formatDateTimeRange}
