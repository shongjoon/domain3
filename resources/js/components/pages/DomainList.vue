<template>
    <div>
        <el-card class="box-card mb-3" style="height: 220px; width: 600px">
            <div slot="header" class="clearfix">
                <span>도메인추가</span>
            </div>
            <div class="text item flex flex-col">
                <div class="flex">
                    <span class="w-1/5 self-center text-center"
                        >Account :
                    </span>
                    <span class="w-4/5">
                        <el-select
                            class="w-full"
                            v-model="addSiteName.account"
                            placeholder="선택"
                            filterable
                        >
                            <el-option
                                v-for="item in accounts"
                                :value="item.account"
                                :key="item.account"
                                >{{ item.account }}</el-option
                            >
                        </el-select>
                    </span>
                </div>

                <div class="flex mt-3">
                    <span class="w-1/5 self-center text-center">
                        Domain :
                    </span>
                    <span class="w-4/5">
                        <el-input
                            placeholder="Please input"
                            v-model="addSiteName.name"
                        ></el-input>
                    </span>
                </div>
            </div>
            <div class="text-center">
                <el-button
                    class="mt-2"
                    size="small"
                    type="primary"
                    @click="cloudAddDomain"
                    >Add Domain
                </el-button>
            </div>
        </el-card>
        <div>
            <el-table
                style="width: 100%; height: 770px"
                class="clickable-rows"
                header-align="center"
                :cell-style="{ padding: '0', height: '40px' }"
                limit="10"
                :data="
                    domainList.filter(
                        (data) =>
                            !search ||
                            data.domain_account.site_name
                                .toLowerCase()
                                .includes(search.toLowerCase())
                    )
                "
            >
                <el-table-column
                    label="site.name"
                    prop="site.name"
                    align="center"
                    width="120"
                >
                    <template slot="header" slot-scope="scope">
                        <el-input
                            @keyup.native.enter="getDomainList"
                            v-model="search"
                            size="mini"
                            placeholder="이름+엔터"
                        />
                    </template>
                </el-table-column>
                <el-table-column
                    label="Name"
                    prop="name"
                    align="center"
                    width="160"
                >
                </el-table-column>
                <el-table-column
                    label="Get Id"
                    prop="get_id"
                    align="center"
                    width="130"
                >
                </el-table-column>
                <el-table-column
                    label="Account"
                    prop="domain_account.account"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    label="Dns"
                    prop="get_dns.length"
                    align="center"
                    width="50"
                >
                </el-table-column>
                <el-table-column
                    label="Dns"
                    prop="dns"
                    align="center"
                    width="50"
                >
                    <template slot-scope="Dns">
                        <div class="text-right">
                            <el-button
                                padding="5px 3px !important;"
                                type="primary"
                                size="mini"
                                style="cursor: pointer; padding: 5px 3px"
                                @click="showDomains(memoContent.row.id)"
                                >DNS
                            </el-button>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                    label="Created At"
                    prop="created_at"
                    align="center"
                    width="150"
                >
                </el-table-column>
                <el-table-column
                    label="Expire Data"
                    prop="expire_date"
                    align="center"
                    width="150"
                >
                </el-table-column>
                <el-table-column
                    label="Status"
                    prop="status"
                    align="center"
                    width="80"
                >
                </el-table-column>
                <el-table-column
                    label="Security"
                    prop="security_level"
                    align="center"
                    width="110"
                >
                </el-table-column>
                <el-table-column
                    label="SSL"
                    prop="ssl_setting"
                    align="center"
                    width="70"
                >
                </el-table-column>
                <el-table-column width="50" label="ETC" align="center">
                    <template slot-scope="domainDetail">
                        <div class="text-right">
                            <el-button
                                type="success"
                                size="mini"
                                style="cursor: pointer; padding: 5px 3px"
                                @click="showDomains(memoContent.row.id)"
                                >수정
                            </el-button>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
            <pagination
                class="mt-1"
                :data="pageDomainList"
                @pagination-change-page="getDomainList"
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
            domains: [],
            nowData: [],
            siteList: [],
            accounts: [],
            addSiteName: {},
            pageSize: 15,
            domainList: [],
            pageDomainList: {},
            // addDomain: false, 이걸 왜 만들었는지 까먹음
        };
    },
    beforeMount() {
        this.getAccountList();
        this.getDomainList();
    },
    created() {
        console.log("domainlist created");
    },
    methods: {
        async getDomainList(page=1) {
            const res = await this.callApi("post", "api/get_domain_list", {
                id: this.$route.query.id,
                account_id: this.$route.query.account_id,
                search: this.search,
                page: page,
                siteId: this.$route.query.siteId,
            });
            // console.log(res.data.data);
            this.domainList = res.data.data;
            this.pageDomainList = res.data;
        },
        async getAccountList() {
            const accounts = await this.callApi(
                "get",
                "api/get_accounts?select=true"
            );
            // console.log(accounts);
            if (accounts.status === 200) {
                this.accounts = accounts.data;
            } else {
                this.swr();
            }
        },
        // changePage(index) {
        //     let _start = (index - 1) * this.pageSize;
        //     let _end = index * this.pageSize;
        //     this.nowData = this.domains.slice(_start, _end);
        // },
        async cloudAddDomain() {
            const res = await this.callApi(
                "post",
                "api/cloud_add_domain",
                this.addSiteName
            );
            console.log("res", res);
            if (res.data.success) {
                this.s(res.data.success, "success");
            } else {
                this.e(res.data.error, "error");
            }
        },
    },
};
</script>