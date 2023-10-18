<template>
    <div class="container">
        <div>
            <div class="flex space-between">
                <div class="w-10/12">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                        <li class="mr-2" v-for="tab in tabs">
                            <a
                                @click="switchTab(tab)"
                                href="#"
                                :class="tab.selected ? 'border-blue-600' : 'border-gray-400'"
                                class="inline-flex items-center justify-center p-3 border-b-2 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group"
                                aria-current="page"
                            >
                                <svg :class="tab.selected ? 'text-blue-600' : 'text-gray-400'" class="w-4 h-4 mr-2  dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" :fill="tab.fill" viewBox="0 0 20 20">
                                    <path :stroke="tab.stroke" :stroke-linecap="tab.strokeLinecap" :stroke-linejoin="tab.strokeLineJoin" :stroke-width="2" :d="tab.d"/>
                                </svg><span :class="tab.selected ? 'text-blue-600' : 'text-gray-400'">{{tab.title}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="w-2/12 text-center p-3 bg-white rounded-br rounded-bl rounded-3xl bold">
                    {{localClient.name}}
                </div>
            </div>
        </div>
        <div class="border-l border-r border-b border-t border-ep-border-color">
            <component :client="localClient" v-bind:is="currentTabComponent" @setNewLocalClient="setNewLocalClient"></component>
        </div>
    </div>
</template>

<script>
import {formatDateTimeRange} from '../../utility'
import {Tabs} from '../../data'

import BookingsIndex from './Bookings/BookingIndex.vue'
import JournalsIndex from "./Journals/JournalsIndex.vue";
import ProfileIndex from "./Profile/ProfileIndex.vue";
export default {
    name: 'ClientShow',
    props: ['client'],
    data() {
        return {
            currentTab: 'Journals',
            localClient: this.client,
            tabs: Tabs
        }
    },
    created(){
        this.localClient.bookings.forEach((booking, index) => {
            const formattedRange = formatDateTimeRange(booking.start, booking.end)
            Vue.set(this.localClient.bookings[index], 'formattedRange', formattedRange)
        })
        this.localClient.journals.forEach((booking, index) => {
            Vue.set(this.localClient.journals[index], 'showMenu', false)
        })
    },
    computed: {
        currentTabComponent(){
            if(this.currentTab === 'Bookings'){
                return BookingsIndex;
            } else if (this.currentTab === 'Journals'){
                return JournalsIndex;
            } else if (this.currentTab === 'Profile'){
                return ProfileIndex;
            }
        }
    },
    methods: {
        switchTab(newTab) {
            this.tabs.forEach(tab => tab.selected = false);
            newTab.selected = true;
            this.currentTab = newTab.title;
        },
        setNewLocalClient(newLocalClient){
            this.localClient = newLocalClient;
        }
    }
}
</script>
<style scoped>
a{
    text-decoration: none;
    color: grey;
}
</style>
