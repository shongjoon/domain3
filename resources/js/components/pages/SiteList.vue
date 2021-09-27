<template>
    <div>
        <el-card class="box-card" style="height: 220px; width: 600px">
            <div slot="header" class="clearfix">
                <span>Site Add</span>
            </div>
            <div class="text item flex flex-col">
                <div class="flex">
                    <span class="w-1/5 self-center text-center">Name : </span>
                    <span class="w-4/5">
                        <el-input
                            placeholder="Please input"
                            v-model="site.name"
                        ></el-input>
                    </span>
                </div>

                <div class="flex mt-3">
                    <span class="w-1/5 self-center text-center">
                        Description :
                    </span>
                    <span class="w-4/5">
                        <el-input
                            placeholder="Please input"
                            v-model="site.description"
                        ></el-input>
                    </span>
                </div>
            </div>
            <div class="text-center">
                <el-button
                    class="mt-2"
                    size="small"
                    type="primary"
                    @click="addSite"
                    >Add Site
                </el-button>
            </div>
        </el-card>
        <div>
            <div class="mt-1 mb-1 p-2 bg-orange-300">Site List</div>

            <el-table
                style="width: 100%; height: 770px"
                class="clickable-rows"
                header-align="center"
                :cell-style="{ padding: '0', height: '40px' }"
                limit="10"
                :data="siteList"
            >
                <el-table-column label="Id" prop="id" align="center" width="80">
                </el-table-column>
                <el-table-column label="Name" prop="name" align="center">
                </el-table-column>
                <el-table-column
                    label="Description"
                    prop="description"
                    align="center"
                >
                </el-table-column>
                <el-table-column label="domain" align="center">
                    <template slot-scope="domainDetail">
                        <div class="">
                            <el-button
                                size="medium"
                                type="success"
                                style="cursor: pointer"
                                @click="showDomains(domainDetail.row.id)"
                                >도메인
                            </el-button>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
            <pagination
                class="mt-1"
                :data="pageSiteList"
                @pagination-change-page="getSite"
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
/* .el-card__body {
    padding: 10px;
} */
</style>

<script>
import pagination from "laravel-vue-pagination";
export default {
    components: { pagination },
    data() {
        return {
            search: '',
            nowData: [],
            siteList: [],
            pageSiteList: {},
            pageSize: 15,
            site: {},
        };
    },
    beforeMount() {
        this.getSite();
    },
    async created() {
        // const res = await this.callApi("get", "app/get_site");
        // if (res.status === 200) {
        //     this.siteList = res.data;
        //     this.nowData = this.siteList.slice(0, this.pageSize);
        // } else {
        //     this.swr();
        // }
    },
    methods: {
        getSiteList() {},
        async getSite(page = 1) {
            const res = await this.callApi("get", "api/get_site?page=" + page);
            console.log("res1", res.data);
            if (res.status === 200) {
                console.log(111);
                this.siteList = res.data.data;
                this.pageSiteList = res.data;
            } else {
                this.swr();
            }
        },
        showDomains(siteId) {
            console.log(siteId);
            let lint_domain = this.$router.resolve({
                path: "/DomainList",
                query: { siteId: siteId },
            });
            window.open(lint_domain.href, "_blank");
        },
        async addSite() {
                const res = await this.callApi("post", "api/add_site", this.site);
                if (res.status === 200) {
                    this.s();
                } else {
                    this.swr();
                }
        },
        // changePage(index) {
        //     let _start = (index - 1) * this.pageSize;
        //     let _end = index * this.pageSize;
        //     this.nowData = this.siteList.slice(_start, _end);
        // },
        // show(index) {
        //     let lint_domain = this.$router.resolve({
        //         path: "/DomainList",
        //         query: { id: index },
        //     });
        //     window.open(lint_domain.href, "_blank");
        // },
    },
};
</script>