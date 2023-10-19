<template>
    <tr>
        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ journal.date }}</td>
        <td class="px-3 py-4 text-sm text-gray-500">{{ journal.description }}</td>
        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
            <button class="btn btn-danger btn-sm" @click="deleteJournal(journal)">Delete</button>
        </td>
    </tr>
</template>

<script>
import axios from 'axios';
import moment from 'moment';

export default {
    name: 'JournalTableRow',

    props: ['journal'],

    methods: {
        deleteJournal(journal) {
            axios.delete(`/clients/24/journals/${journal.id}`)
                .then((data) => {
                    window.location.href = data.data.url;
                });
        }
    },
}
</script>
