<!-- 花园 -->

<script setup>
    import { Messager } from '@/api/ConnectCore';
    import { GlobelArea } from '@/stores/PiniaBox';
    import card_plantPot from '@/components/card_plantPot.vue';
    const GArea = GlobelArea();
</script>

<template>
    <!-- 盆栽 -->
    <div class="container">
        <div class="row">
            <div class="col-sm-3 mt-2" v-for="item in showPostsData">
                <card_plantPot :theData="item"></card_plantPot>
            </div>
        </div>
        <div class="d-grid" v-if="!allDone">
            <button type="button" class="btn btn-outline-secondary"
            @click="loadMore()">
                加载更多
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data(){return{
            postsData: {},
            showPostsData: {},
            loadNum: 0,
            allDone: false,
        }},
        methods: {
            loadMore(){
                // 加载更多盆栽
                if(this.postsData==undefined){this.allDone=true;return;}
                let i = this.loadNum;
                this.loadNum += 8;
                if(this.loadNum>this.postsData.length){
                    this.loadNum=this.postsData.length;
                    this.allDone = true;
                }
                for(i;i<this.loadNum;i++){
                    this.showPostsData[i] = this.postsData[i];
                }
            },
        },
        mounted(){
            Messager.getPostsData(1).then(res=>{
                if(res.mainData!=null){
                    this.postsData = res.mainData;
                    this.loadMore();
                }
            });
        },
    }
</script>

<style scoped>
</style>