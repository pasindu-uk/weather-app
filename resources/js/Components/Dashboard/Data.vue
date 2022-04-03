<template>
    <div>
        <div class="flex justify-end mt-4">
            <button v-on:click="testMethod" class="bg-red-500 rounded-full py-2 px-4">Hottest First</button>
            <button class="bg-violet-400 rounded-full py-2 px-4 ml-3">Reset Order</button>
        </div>
        <div class="grid grid-cols-12 gap-4 mt-3">
            <div class="col-span-6">
                <h2 class="text-4xl">Location 1</h2>
            </div>
            <div class="col-span-6">
                <h2 class="text-4xl">Location 2</h2>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-4 mt-3">
            <div class="col-span-6">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-6">
                        Wed, 10 July 2021, 16:00 pm
                    </div>
                    <div class="col-span-3">
                        33^c
                    </div>
                    <div class="col-span-3">
                        100^F
                    </div>
                </div>
            </div>
            <div class="col-span-6">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-6">
                        Wed, 10 July 2021, 16:00 pm
                    </div>
                    <div class="col-span-3">
                        33^c
                    </div>
                    <div class="col-span-3">
                        100^F
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    mounted() {
        console.log('Dashboard Data Mounted.');
    },

    data() {
        return {
        }
    },

    created() {
    },

    methods: {
        testMethod() {
            alert('testing');
        },
    }
}
</script>
