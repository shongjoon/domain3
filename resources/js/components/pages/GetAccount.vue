<template>
    <div class="">
        <div class="flex">
            <div class="pr-4 flex1">
                <el-card class="box-card" style="height: 512px; width: 401px">
                    <div slot="header" class="clearfix">
                        <span>구입 관리</span>
                    </div>
                    <div class="text item flex flex-col">
                        <div class="flex">
                            <span class="w-1/5">계정 : </span>
                            <span class="w-4/5">
                                <el-input
                                    placeholder="Please input"
                                    v-model="account"
                                ></el-input>
                            </span>
                        </div>

                        <div class="flex mt-3">
                            <span class="w-1/5"> 비고 : </span>
                            <span class="w-4/5">
                                <el-input
                                    placeholder="Please input"
                                    v-model="notice"
                                ></el-input>
                            </span>
                        </div>
                        <div class="flex mt-3">
                            <span class="w-1/5">구입갯수 : </span>
                            <span class="w-4/5">
                                <el-input
                                    placeholder="Please input"
                                    v-model="get_no"
                                ></el-input>
                            </span>
                        </div>
                        <div class="flex mt-3">
                            <span class="w-1/5">금액 : </span>
                            <span class="w-4/5">
                                <el-input
                                    placeholder="Please input"
                                    v-model="account_coin"
                                ></el-input>
                            </span>
                        </div>
                    </div>
                    <div class="text-center">
                        <el-button size="small" type="primary">등록</el-button>
                    </div>
                </el-card>
            </div>
            <div class="w-full">
                <el-table
                    style="width: 100%; height: 770px"
                    class="clickable-rows"
                    header-align="center"
                    :cell-style="{ padding: '0', height: '40px' }"
                    limit="10"
                    data=""
                >
                    <el-teble-column>test</el-teble-column>
                </el-table>
            </div>
        </div>
        <div>
            <div class="table_header"></div>
            <div></div>
        </div>
    </div>
</template>
<style scoped>
.text {
    font-size: 14px;
}

.item {
    margin-bottom: 18px;
}

.clearfix:before,
.clearfix:after {
    display: table;
    content: "";
}
.clearfix:after {
    clear: both;
}

.box-card {
    width: 480px;
}
.box-card div.text .flex span {
    text-align: center;
    align-self: center;
}
.table_header div.ivu-table-header table thead tr {
    background-color: #2db7f5 !important;
}
</style>
<script>
export default {
    data() {
        return {
            account: "",
            notice: "",
            get_no: "",
            account_coin: "ttest",
            count: 0,
            account_list: [],
            coin_list: [],
            coin_list_total: 0,
            pageSize: 10,
            nowData: [],
        };
    },
    beforeMount() {
        this.coinTotalList();
    },
    methods: {
        changePage(index) {
            let _start = (index - 1) * this.pageSize;
            let _end = index * this.pageSize;
            this.nowData = this.coin_list.slice(_start, _end);
            console.log("_start", _start);
            console.log("_end", _end);
            console.log("nowData", this.nowData);
        },
        async coinTotalList() {
            const res = await this.callApi("get", "api/get_coins");
            this.account_list = res.data.account_coin;
            this.coin_list = res.data.coin_list;
            // this.nowData = this.coin_list.slice(0, this.pageSize)
            // console.log(this.coin_list.length);
        },
    },
    mounted() {
        console.log("Component mounted.");
    },
    async created() {},
};
</script>
