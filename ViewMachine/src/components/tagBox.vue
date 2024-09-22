<!-- 标签盒子 -->

<script setup>
    import { Messager } from '@/api/ConnectCore';
    import { GlobelArea } from '@/stores/PiniaBox';
    import card_plantPot from '@/components/card_plantPot.vue';
    const GArea = GlobelArea();
</script>

<template>
    <div class="row">
        <div class="col">
            <h3>作者</h3>
            <span class="badge text-bg-warning" v-for="i in tagsData">
                <span v-if="i[1]==2">{{ i[0] }}</span>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h3>系列</h3>
            <span class="badge text-bg-info" v-for="i in tagsData">
                <span v-if="i[1]==3">{{ i[0] }}</span>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h3>角色</h3>
            <span class="badge text-bg-success" v-for="i in tagsData">
                <span v-if="i[1]==4">{{ i[0] }}</span>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h3>兽种</h3>
            <span class="badge text-bg-danger" v-for="i in tagsData">
                <span v-if="i[1]==5">{{ i[0] }}</span>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h3>描述</h3>
            <span class="badge text-bg-secondary" v-for="i in tagsData">
                <span v-if="i[1]==1">{{ i[0] }}</span>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["theData"],
        data(){return{
            tagsData: {},
        }},
        methods: {
            myfunc1(){},
        },
        mounted(){
            this.tagsData = this.theData;
        },
        watch: {
            tagsData:{
                handler(newData,oldData){
                    this.tagsData = newData;
                },
                immediate: true,
                deep: true,
            },
        },
    }
</script>

<style scoped>
</style>