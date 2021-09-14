<template>
    <div>
        <div>
            <!--========== ADMIN SIDE MENU one ========-->
            <div class="_1side_menu">
                <div class="_1side_menu_logo">
                    <h3 style="text-align: center">Domain Administrate</h3>
                    <!--<img src="/img/logo.jpg" style="width: 108px;margin-left: 68px;"/>-->
                </div>

                <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
                <div class="_1side_menu_content">
                    <!--~~~ MENU LIST ~~~~~~-->
                    <div class="_1side_menu_list">
                        <ul class="_1side_menu_list_ul">
                            <li>
                                <router-link to="/home"
                                    ><i class="el-icon-goods" />
                                    Dashboard</router-link
                                >
                            </li>
                            <li>
                                <router-link to="Accountlist"
                                    ><i class="el-icon-goods" /> Account
                                    List</router-link
                                >
                            </li>
                            <li>
                                <router-link to="DomainList"
                                    ><i class="el-icon-goods" /> Domain
                                    List</router-link
                                >
                            </li>
                            <li>
                                <router-link to="SiteList"
                                    ><i class="el-icon-goods" /> Site
                                    List</router-link
                                >
                            </li>
                            <li>
                                <router-link to="GetAccount"
                                    ><i class="el-icon-goods" /> Get
                                    Account</router-link
                                >
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--========== ADMIN SIDE MENU ========-->

            <!--========= HEADER ==========-->
            <div class="header">
                <div class="_2menu _box_shadow">
                    <div class="_2menu_logo">
                        <ul class="open_button">
                            <li>
                                <i class="el-icon-goods" />
                            </li>
                            <!--<li><Icon type="ios-albums" /></li>-->
                        </ul>
                    </div>
                </div>
            </div>
            <!--========= HEADER ==========-->
        </div>
        <div class="content">
            <div class="container-fluid">
                <router-view />
            </div>
        </div>
    </div>
</template>

<script>

export default {};
</script>