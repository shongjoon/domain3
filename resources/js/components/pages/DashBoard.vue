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

            <div class="_overflow _table_div">
                <table class="_table notice">
                    <tr class="text-white">
                        <td>memo</td>
                        <td class="w-1/6">날짜</td>
                        <td class="w-10">수정</td>
                        <td class="w-10">삭제</td>
                    </tr>
                    <tr v-for="(memo, i) in memos" :key="i">
                        <td>{{ memo.memo }}</td>
                        <td>{{ memo.created_at }}</td>
                        <td>
                            <el-button
                                type="success"
                                size="small"
                                @click="showEditModal(memo)"
                                >수정</el-button
                            >
                        </td>
                        <td>
                            <el-button
                                size="small"
                                type="danger"
                                @click="showDeleteModal(memo, i)"
                                >삭제</el-button
                            >
                        </td>
                    </tr>
                    <!-- ITEMS -->
                </table>
            </div>
        </div>
        <div>
            <div class="table_header">
                만료 임박 도메인 {{ expire_date.length }}
            </div>
            <Table border :columns="columns5" :data="nowData"></Table>
            <Page
                :total="expire_date.length"
                :pageSize="pageSize"
                @on-change="changePage"
                @on-page-size-change="_nowPageSize"
                simple
            />
        </div>

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
        <Modal
            v-model="editModal"
            title="Edit memo"
            :mask-closable="false"
            :closable="false"
        >
            <Input
                v-model="editData.memo"
                placeholder="Edit memo"
                class="w-full"
            />
            <div slot="footer">
                <el-button type="default" @click="editModal = false"
                    >Close</el-button
                >
                <el-button type="primary" @click="editMemo"
                    >edit memo</el-button
                >
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
                <el-button type="primary" @click="deleteTag">Delete</el-button>
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
export default {
    data() {
        return {
            columns5: [
                {
                    title: "site",
                    key: "site",
                    sortable: true,
                    width: 100
                    
                },
                {
                    title: "name",
                    key: "name",
                    sortable: true,
                },
                {
                    title: "get_id",
                    key: "get_id",
                    sortable: true,
                },
                {
                    title: "status",
                    key: "status",
                    sortable: true,
                    width: 100
                },
                {
                    title: "security_level",
                    key: "security_level",
                    sortable: true,
                    width: 100
                },
                {
                    title: "ssl",
                    key: "ssl_setting",
                    sortable: true,
                    width: 100
                },
                {
                    title: "ipv6",
                    key: "ipv6",
                    sortable: true,
                    width: 70
                },
                {
                    title: "created_at",
                    key: "created_at",
                    sortable: true,
                },
                {
                    title: "expire_date",
                    key: "expire_date",
                    sortable: true,
                    sortType: "desc",
                },
            ],

            data: {
                memo: "",
            },
            editData: {
                memo: "",
            },
            addModal: false,
            editModal: false,
            deleteModal: false,
            memos: [],
            nowData: [],
            pageSize: 15,
            expire_date: [],
            // pageCurrent: 1,
        };
    },

    methods: {
        changePage(index) {
            let _start = (index - 1) * this.pageSize;
            let _end = index * this.pageSize;
            // this.pageCurrent = index;
            this.nowData = this.expire_date.slice(_start, _end);
        },
        _nowPageSize(index) {
            console.log("_nowPageSize");
            //Get the current number of items that need to be displayed in real time
            this.pageSize = index;
        },

        async addMemo() {
            if (this.data.memo.trim() == "")
                return this.e("tag name is required");
            const res = await this.callApi(
                "post",
                "app/create_memo",
                this.data
            );

            if (res.status === 201) {
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
        async editMemo() {
            if (this.editData.memo.trim() == "")
                return this.e("memo is required");
            const res = await this.callApi(
                "post",
                "app/edit_memo",
                this.editData
            );
            if (res.status === 200) {
                this.s("memo has been edited");
                this.editModal = false;
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
        async deleteTag() {
            const res = await this.callApi(
                "post",
                "app/delete_memo",
                this.deleteData
            );
            if (res.status === 200) {
                this.memos.splice(this.deleteId, 1);
                this.s("deleted success");
                this.deleteModal = false;
            } else {
                this.swr();
            }
        },
        showEditModal(memo) {
            this.editData = memo;
            this.editModal = true;
        },
        showDeleteModal(memo, i) {
            this.deleteModal = true;
            this.deleteId = i;
            this.deleteData = memo;
        },
    },

    async created() {
        const res = await this.callApi("get", "app/get_memos");
        if (res.status === 200) {
            this.memos = res.data;
        } else {
            this.swr();
        }
        const expire_date = await this.callApi("get", "app/get_domain");
        console.log('expire_date',expire_date);
        if (expire_date.status === 200) {
            this.expire_date = expire_date.data.data;
            this.nowData = this.expire_date.slice(0, this.pageSize);
        } else {
            this.swr();
        }
    },
};
</script>