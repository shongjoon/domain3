<template>
    <div>
        <el-card class="box-card" style="height: 280px; width: 600px">
            <div slot="header" class="clearfix">
                <span>계정 추가</span>
            </div>
            <div class="text item flex flex-col">
                <div class="flex">
                    <span class="w-1/5 self-center text-center"
                        >Email address :
                    </span>
                    <span class="w-4/5">
                        <el-input
                            v-model="add.account"
                            placeholder="Please input"
                        ></el-input>
                    </span>
                </div>
                <div class="flex mt-3">
                    <span class="w-1/5 self-center text-center">
                        API KEY :
                    </span>
                    <span class="w-4/5">
                        <el-input
                            v-model="add.api_key"
                            placeholder="Please input"
                        ></el-input>
                    </span>
                </div>
                <div class="flex mt-3">
                    <span class="w-1/5 self-center text-center">
                        SITE NAME :
                    </span>
                    <el-select
                        v-model="add.site_name"
                        placeholder="선택"
                        style="width: 80%"
                        filterable
                    >
                        <el-option
                            v-for="item in accountList"
                            :value="item.site_name"
                            :key="item.site_name"
                            :label="item.site_name"
                            >{{ item.site_name }}</el-option
                        >
                    </el-select>
                </div>
            </div>
            <div class="text-center">
                <el-button @click="addAccount" class="mt-2" type="primary"
                    >Add Account
                </el-button>
            </div>
        </el-card>
        <div>
            <div class="mt-1 mb-1 p-2 bg-orange-300">Account List</div>
            <el-table
                style="width: 100%; height: 665px"
                class="clickable-rows"
                header-align="center"
                :cell-style="{ padding: '0', height: '40px' }"
                :data="
                    accountList.filter(
                        (data) =>
                            !search ||
                            data.site_name
                                .toLowerCase()
                                .includes(search.toLowerCase())
                    )
                "
            >
                <el-table-column
                    label="site_name"
                    prop="site_name"
                    width="170"
                    align="center"
                >
                    <template slot="header" slot-scope="scope">
                        <el-input
                            @keyup.native.enter="searchData"
                            v-model="search"
                            size="mini"
                            placeholder="사이트 이름 + 엔터"
                        />
                    </template>
                </el-table-column>
                <el-table-column
                    label="Account"
                    prop="account"
                    width="240"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    label="Api Key"
                    prop="api_key"
                    width=""
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    label="Count"
                    prop="count"
                    width="80"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    label="Updated At"
                    prop="updated_at"
                    width="150"
                    align="center"
                >
                </el-table-column>
                <el-table-column width="130" label="Domain" align="center">
                    <template slot-scope="memoContent">
                        <div>
                            {{ memoContent.row.content }}
                        </div>
                        <div class="">
                            <el-button
                                type="primary"
                                size="small"
                                style="cursor: pointer"
                                @click="
                                    showDomains(
                                        memoContent.row.id
                                    )
                                "
                                >View Domain
                            </el-button>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column width="130" label="ETC" align="center">
                    <template slot-scope="memoContent">
                        <div>
                            {{ memoContent.row.content }}
                        </div>
                        <div class="">
                            <el-button
                                type="success"
                                size="small"
                                style="cursor: pointer"
                                @click="
                                    updateAccountInfo(
                                        memoContent.row.id
                                    )
                                "
                                >Domain Update
                            </el-button>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
            <pagination
                class="mt-1"
                :data="pageAccountList"
                @pagination-change-page="getAccount"
                :show-disabled="true"
                :limit="10"
            >
                <span slot="prev-nav">&lt; 이전</span>
                <span slot="next-nav">다음 &gt;</span>
            </pagination>
        </div>
    </div>
</template>
<style scoped>
</style>
<script>
import pagination from "laravel-vue-pagination";
export default {
    components: { pagination },
    data() {
        return {
            search: "",
            add: {
                account: "",
                api_key: "",
                site_name: "",
            },
            nowData: [],
            accountList: [],
            pageAccountList: {},
            pageSize: 15,
            sites: [],
        };
    },
    mounted() {},
    beforeMount() {
        this.getAccount();
        this.getSite();
    },
    methods: {
        async searchData(search) {
            // console.log(search);
            // console.log("a", search.target.value);
            const res = await this.callApi(
                "get",
                "api/get_accounts?search=" + search.target.value
            );
            // console.log('res',res);
            if (res.status === 200) {
                this.accountList = res.data.data;
                this.pageAccountList = res.data;
            } else {
                this.swr();
            }
        },
        showDomains(accountId) {
            console.log(accountId);
            let lint_domain = this.$router.resolve({
                path: "/DomainList",
                query: { account_id: accountId },
            });
            window.open(lint_domain.href, "_blank");
        },
        updateAccountInfo(id) {
            const res =  this.callApi("post", "api/update_account", {
                account_id: id,
            });

            if (res.data.success) {
                this.s(res.data.success);
            }
            if (res.data.error) {
                this.e(res.data.error);
            }
        },
        async addAccount() {
            const res = await this.callApi("post", "api/add_account", this.add);
            console.log('111',res)
            if (res.status === 200) {
                this.s();
            }
        },
        async getAccount(page = 1) {
            const res = await this.callApi(
                "get",
                "api/get_accounts?page=" + page
            );
            console.log("res.data", res);
            if (res.status === 200) {
                this.accountList = res.data.data;
                this.pageAccountList = res.data;
            } else {
                this.swr();
            }
        },
        async getSite() {
            const sites = await this.callApi("get", "api/get_site");
            if (sites.status === 200) {
                this.sites = sites.data;
            } else {
                this.swr();
            }
        },
    },
    async created() {
        // const res = await this.callApi("get", "app/get_accounts");
        // console.log("res.data", res.data);
        // if (res.status === 200) {
        //     this.accountList = res.data;
        //     this.nowData = this.accountList.slice(0, this.pageSize);
        // } else {
        //     this.swr();
        // }
        // const sites = await this.callApi("get", "app/get_site");
        // if (sites.status === 200) {
        //     this.sites = sites.data;
        // } else {
        //     this.swr();
        // }
    },
};
</script>
