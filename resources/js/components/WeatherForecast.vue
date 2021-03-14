<template>
    <div id="weather" v-bind:style="bodyStyle">
        <h3 class="center">Weather App for Japan Travelers</h3>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <form class="form-inline" v-on:submit.prevent="onSubmit">
                    <div class="row fullWidth">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 fullWidth" id="selectCity">
                            <label for="city"> Select City:</label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 fullWidth">
                            <select name="city" id="city" class="form-control" v-model="city">
                                <option v-for="city in cities" :key="city" :value="city">{{city}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row fullWidth" v-if="cityError !== null">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center">
                            <label class="text-danger">
                                {{cityError}}
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 fullWidth">
                        <button type="submit" class="btn btn-success fullWidth">Submit</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" v-if="Object.keys(weather).length != 0">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 center">
                        <img class="img-fluid icon img-thumbnail" v-bind:src="weather.icon_path">
                        <label for="icon" class="description center fullWidth" id="description">{{weather.description}}</label>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <label for="main">Main: </label>
                        {{weather.main}} <br>
                        <label for="day">Timestamp: </label>
                        {{weather.is_day ? 'Day Time':  'Night Time'}} <br>
                        <label for="icon">Icon: </label>
                        {{weather.icon}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="venues.length != 0">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <Venues v-bind:venues="venues"/>
            </div>
        </div>
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
            venues: [],
            weather: {},
            bodyStyle: {
                backgroundColor: 'powderBlue',
                color: 'black'
            }
        }
    },
    methods: {
        async onSubmit(e) {
            e.preventDefault();
            if (!this.city) {
                return this.cityError = 'Please select city first'
            }
            var city = e.target.city.value;

            // for getting weather information
            this.weather = await Axios.get('/api/weather?city=' + city)
                            .then(res =>{
                                return res.data;
                            })
                            .catch(() => {
                                this.weather = {};
                            });
            if (Object.keys(this.weather).length != 0) {
                if (this.weather.is_day) {
                    this.bodyStyle = {
                        backgroundColor: 'powderBlue',
                        color: 'black'
                    }
                } else {
                    this.bodyStyle = {
                        backgroundColor: '#4c408e',
                        color: 'white'
                    }
                }
            }

            // for getting values
            this.venues = await Axios.get('/api/venues?city=' + this.city)
                            .then(res => {
                                return res.data;
                            })
                            .catch(() => {
                                this.venues = {};
                            })
            this.cityError = null;
        }
    }
}
</script>