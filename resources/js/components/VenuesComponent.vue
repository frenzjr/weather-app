<template>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive" id="venuesTable">
            <h4>List of Venues</h4>
            <table class="table">
                <thead>
                    <th>Name</th>
                    <th>Address</th>
                </thead>
                <tbody>
                    <tr v-if="venues.length == 0">
                        <td colspan="2">
                            No Place to Show.
                        </td>
                    </tr>
                    <tr v-for="venue in venues">
                        <td>{{venue.name}}</td>
                        <td>{{venue.address}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: 'venues',
    props: {
        venues: Array
    },
}
</script>