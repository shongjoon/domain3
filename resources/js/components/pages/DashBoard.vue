<template>
    <div>
        <div
            class="
                _1adminOverveiw_table_recent
                _box_shadow
                _border_radious
                _mar_b30
                _p20
            "
        >
            <p class="_title0">
                전달사항
                <el-button @click="addModal = true" type="primary" size="small"
                    ><i class="el-icon-plus"></i> Add</el-button
                >
            </p>
            <el-table
                style="width: 100%; height: 246px"
                class="clickable-rows"
                :cell-style="{ padding: '0', height: '40px' }"
                :data="memos"
            >
                <el-table-column label="Id" prop="id" width="50">
                </el-table-column>
                <el-table-column
                    label="Memo"
                    prop="memo"
                    class=""
                    height="10px"
                >
                </el-table-column>
                <el-table-column
                    label="Created At"
                    prop="created_at"
                    width="150"
                >
                </el-table-column>
                <el-table-column
                    label="Updated At"
                    prop="updated_at"
                    width="150"
                >
                </el-table-column>
                <el-table-column width="150">
                    <template slot-scope="memoContent">
                        <div>
                            {{ memoContent.row.content }}
                        </div>
                        <div class="text-right">
                            <el-button
                                type="danger"
                                size="small"
                                style="cursor: pointer"
                                @click="
                                    showDeleteModal(
                                        memoContent.row.content,
                                        memoContent.row.id
                                    )
                                "
                                >삭제
                            </el-button>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
            <pagination
                class="mt-1"
                :data="pagenationData"
                @pagination-change-page="memoGet"
                :show-disabled="true"
            >
                <span slot="prev-nav">&lt; 이전</span>
                <span slot="next-nav">다음 &gt;</span>
            </pagination>
        </div>
        <div>
            <div class="table_header">
                만료 임박 도메인 {{ expire_date.length }}
            </div>
        </div>
        <el-table
            style="width: 100%; height: 615px"
            class="clickable-rows"
            :cell-style="{ padding: '0', height: '40px' }"
            :data="
                expireData.filter(
                    (data) =>
                        !search ||
                        data.site.description
                            .toLowerCase()
                            .includes(search.toLowerCase())
                )
            "
        >
            <el-table-column label="Id" prop="id" width="">
                <template slot="header" slot-scope="scope">
                    <el-input
                        @keyup.native.enter="searchData"
                        v-model="search"
                        size="mini"
                        placeholder="사이트 이름 + 엔터"
                    />
                </template>
            </el-table-column>
            <el-table-column label="Site" prop="site.description" width="">
            </el-table-column>
            <el-table-column label="Get Id" prop="get_id" width="">
            </el-table-column>
            <el-table-column label="Suatus" prop="status" width="">
            </el-table-column>
            <el-table-column label="Created At" prop="created_at" width="">
            </el-table-column>
            <el-table-column
                label="Expire Date"
                prop="expire_date"
                width=""
                sortable
            >
            </el-table-column>
        </el-table>
        <pagination
            class="mt-1"
            :data="expirePageData"
            @pagination-change-page="expireDomainGet"
            :show-disabled="true"
        >
            <span slot="prev-nav">&lt; 이전</span>
            <span slot="next-nav">다음 &gt;</span>
        </pagination>
        <Modal
            v-model="addModal"
            title="add tag"
            :mask-closable="false"
            :closable="false"
        >
            <Input v-model="data.memo" class="w-full" placeholder="Add memo" />
            <div slot="footer">
                <el-button type="default" @click="addModal = false"
                    >Close</el-button
                >
                <el-button type="primary" @click="addMemo">Add memo</el-button>
            </div>
        </Modal>
        <Modal v-model="deleteModal" width="360">
            <p slot="header" style="color: #f60; text-align: center">
                <Icon type="ios-information-circle"></Icon>
                <span>Delete confirmation</span>
            </p>
            <div style="text-align: center">
                <p>are you sure you want to do?</p>
            </div>
            <div slot="footer">
                <el-button type="default" @click="deleteModal = false"
                    >Close</el-button
                >
                <el-button type="primary" @click="deleteMemo">Delete</el-button>
            </div>
        </Modal>
    </div>
</template> 
<style scoped>
table._table tr td {
    text-align: center;
}
.table_header {
    background: #afd2b5;
    padding: 10px;
}
</style>
<script>
import pagination from "laravel-vue-pagination";
import { mapState, mapActions } from "vuex";
export default {
    components: {
        pagination,
    },
    data() {
        return {
            data: {
                memo: "",
            },
            editData: {
                memo: "",
            },
            pagenationData: {},
            expireData: [],
            expirePageData: {},
            addModal: false,
            editModal: false,
            deleteModal: false,
            deleteData: "",
            // memos: [],
            nowData: [],
            pageSize: 15,
            expire_date: [],
            pageCurrent: 1,
            search: "",
        };
    },

    beforeMount: function () {
        console.log("beforeMount");
        this.expireDomainGet();
        this.memoGet();
    },
    created() {
        console.log("created"); // 여기선 템플릿과 가상돔은 마운트 및 렌더링되지 않은 상태이다.
    },
    computed: {
        ...mapState({
            memos: (state) => state.memos,
        }),
    },
    mounted() {
        console.log("mounted");
    },
    methods: {
        async searchData(search) {
            // console.log(search);
            // console.log("a", search.target.value);

            const res = await this.callApi(
                "get",
                "api/get_domain?search=" + search.target.value
            );
            // console.log("res", res);
            if (res.status === 200) {
                this.expireData = res.data.data;
                this.expirePageData = res.data;
                // this.nowData = this.expire_date.slice(0, this.pageSize);
            } else {
                this.swr();
            }
        },
        ...mapActions(["memoGet"]),
        // async memoGet(page = 1) {
        //     const res = await this.callApi("get", "api/get_memos?page=" + page);
        //     if (res.status === 200) {
        //         this.memos = res.data.data;
        //         this.pagenationData = res.data;
        //     } else {
        //         this.swr();
        //     }
        // },
        async expireDomainGet(page = 1) {
            // console.log("expireDomainGet", this.data);
            const res = await this.callApi(
                "get",
                "api/get_domain?page=" + page
            );
            // console.log("res", res);
            if (res.status === 200) {
                this.expireData = res.data.data;
                this.expirePageData = res.data;
                // this.nowData = this.expire_date.slice(0, this.pageSize);
            } else {
                this.swr();
            }
        },
        async addMemo() {
            if (this.data.memo.trim() == "")
                return this.e("tag name is required");
            const res = await this.callApi(
                "post",
                "api/create_memo",
                this.data
            );
            if (res.status === 201) {
                var myAlarm = new Audio(
                    "/app/public/sound/sound1.mp3"
                );
                myAlarm.play(1);
                this.memos.unshift(res.data);
                this.s("memo added");
                this.addModal = false;
                this.data.memo = "";
            } else {
                if (res.status === 422) {
                    if (res.data.errors.memo) {
                        this.e(res.data.errors.memo[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        async deleteMemo() {
            const res = await this.callApi("post", "api/delete_memo", {
                id: this.deleteDataMemo,
            });

            if (res.status === 200) {
                // 이거 왜 실시간으로 삭제가 안되나???
                this.memos.splice(this.deleteDataMemo, 1);
                this.s("deleted success");
                this.deleteModal = false;
            } else {
                this.swr();
            }
        },
        showDeleteModal(memo, i) {
            this.deleteModal = true;
            this.deleteDataMemo = i;
        },
    },
    async created() {},
};
</script>