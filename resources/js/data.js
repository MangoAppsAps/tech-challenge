const Tabs = [
    {
        title: 'Bookings',
        fill: 'none',
        d: 'M5 1v3m5-3v3m5-3v3M1 7h18M5 11h10M2 3h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z',
        stroke: 'currentColor',
        strokeLinecap: 'round',
        strokeLineJoin: 'round',
        strokeWidth: '2',
        selected: false
    },
    {
        title: 'Journals',
        fill: 'none',
        d: 'M10 16.5c0-1-8-2.7-9-2V1.8c1-1 9 .707 9 1.706M10 16.5V3.506M10 16.5c0-1 8-2.7 9-2V1.8c-1-1-9 .707-9 1.706',
        stroke: 'currentColor',
        strokeLinecap: 'round',
        strokeLineJoin: 'round',
        strokeWidth: '2',
        selected: true
    },
    {
        title: 'Profile',
        fill: 'currentColor',
        d: 'M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0' +
        ' 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z',
        stroke: 'none',
        strokeLinecap: 'round',
        strokeLineJoin: 'round',
        strokeWidth: '0',
        selected: false
    }
]

export {Tabs}
