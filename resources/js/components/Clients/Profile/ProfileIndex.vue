<template>
    <div class="bg-white container p-4">
        <table>
            <tbody>
            <tr>
                <th class="text-gray-600 pr-3">Name</th>
                <td>{{ client.name }}</td>
            </tr>
            <tr>
                <th class="text-gray-600 pr-3">Email</th>
                <td>{{ client.email }}</td>
            </tr>
            <tr>
                <th class="text-gray-600 pr-3">Phone</th>
                <td>{{ client.phone }}</td>
            </tr>
            <tr>
                <th class="text-gray-600 pr-3">Address</th>
                <td>{{ client.address }}, {{ client.postcode + ' ' + client.city }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

export default ({
    name: "ProfileIndex",
    props: [
        'client'
    ]
})
</script>

<style scoped>

</style>
