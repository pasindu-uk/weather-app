<template>
    <div>
        <div class="flex justify-end mt-4">
            <button v-on:click="highest" class="bg-red-500 rounded-full py-2 px-4">Hottest First</button>
            <button v-on:click="reset" class="bg-violet-400 rounded-full py-2 px-4 ml-3">Reset Order</button>
        </div>
        <div class="grid grid-cols-12 gap-4 mt-3">
            <div class="col-span-6">
                <h2 v-if="processedData.length != 0" class="text-4xl">{{ processedData.data.tableheaders.locationOne }}</h2>
            </div>
            <div class="col-span-6">
                <h2 v-if="processedData.length != 0" class="text-4xl">{{ processedData.data.tableheaders.locationTwo }}</h2>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-4 mt-3">
            <div class="col-span-6">
                <div v-if="processedData.length != 0" class="grid grid-cols-12 gap-4 mt-3"  v-for="row in processedData.data.tabledata.locationOne" v-bind:key="row.id">
                    <div class="col-span-6">
                        {{ moment(row.timestamp).format("ddd, DD MMM DD, YYYY [at] HH:mm a") }}
                    </div>
                    <div class="col-span-3">
                        {{ row.celsius }}&#8451;
                    </div>
                    <div class="col-span-3">
                        {{ row.fahrenheit }}&#8457;
                    </div>
                </div>
            </div>
            <div class="col-span-6">
                <div v-if="processedData.length != 0" class="grid grid-cols-12 gap-4 mt-3"  v-for="row in processedData.data.tabledata.locationTwo" v-bind:key="row.id">
                    <div class="col-span-6">
                        {{ moment(row.timestamp).format("ddd, DD MMM DD, YYYY [at] HH:mm a") }}
                    </div>
                    <div class="col-span-3">
                        {{ row.celsius }}&#8451;
                    </div>
                    <div class="col-span-3">
                        {{ row.fahrenheit }}&#8457;
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';

export default {
    mounted() {
        console.log('Dashboard Data Mounted.');
    },

    data() {
        return {
            order: '',
            processedData: [],
        }
    },

    created() {
        this.moment = moment;
        this.getData();
    },

    methods: {
        getData() {
            var url = '/api/fetch/data?order='+this.order;
            fetch(url, {
                method: 'GET'
            })
                .then(res => res.json())
                .then(res => {
                    this.processedData = res;
                    console.log(this.processedData.data.tableheaders.locationOne);
                })
                .catch((err) => console.log(err))
        },

        highest() {
            this.order = 'highest';
            this.getData();
        },

        reset() {
            this.order = '';
            this.getData();
        },
    }
}
</script>
