<template>
    <div class="weather">
        <form class="form-inline" v-on:submit.prevent="onSubmit">
            <div class="form-group">
                <label for="city"> Select City:</label>
                <div class="col-md-6">
                    <select name="city" id="city" class="form-control" @change="getVenues()" v-model="city">
                        <option v-for="city in cities" :key="city" :value="city">{{city}}</option>
                    </select>
                    <small class="text-danger" v-if="cityError !== null">
                        {{cityError}}
                    </small>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
        <Venues props-name="venues"/>
    </div>
</template>

<script>
import Axios from 'axios';
import Venues from './VenuesComponent';

export default {
    name: 'app',
    components: {
        Venues
    },
    data() {
        return {
            cities: ['Tokyo', 'Yokohama', 'Kyoto', 'Osaka', 'Sapporo', 'Nagoya'],
            city: null,
            cityError: null,
            venues: null
        }
    },
    methods: {
        onSubmit: function(e) {
            e.preventDefault();
            if (!this.city) {
                return this.cityError = 'Please select city first'
            }
            var city = e.target.city.value;
            Axios.get('/api/weather?city=' + city)
                .then(res => res);
        },
        getVenues: function () {
            Axios.get('/api/venues?city=' + this.city)
                .then(function(res) {
                    console.log(res.data);
                });
        },
        
    }
}
</script>