<template>
    <div>
        
        <div>
        <!--========== ADMIN SIDE MENU one ========-->
        <div class="_1side_menu" >
            <div class="_1side_menu_logo">
            <h3 style="text-align:center;">Logo Image</h3>
            <!--<img src="/img/logo.jpg" style="width: 108px;margin-left: 68px;"/>-->
            </div>

            <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
            <div class="_1side_menu_content">
            <div class="_1side_menu_img_name">
                <!-- <img class="_1side_menu_img" src="/pic.png" alt="" title=""> -->
                <p class="_1side_menu_name">Admin</p>
            </div>

            <!--~~~ MENU LIST ~~~~~~-->
            <div class="_1side_menu_list">
                <ul class="_1side_menu_list_ul">
                    <li><router-link to="/DashBoard"><Icon type="ios-speedometer" /> Dashboard</router-link></li>
                    <li><router-link to="Accountlist"><Icon type="ios-stopwatch" /> Account List</router-link></li>
                    <li><router-link to="DomainList"><Icon type="ios-star-outline" /> Domain List</router-link></li>
                    <li><router-link to="SiteList"><Icon type="logo-twitter" /> Site List</router-link></li>
                    <li><router-link to="GetAccount"><Icon type="logo-snapchat" /> Get Account</router-link></li>
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
                    <Icon type="ios-list" />
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
    	        <router-view/>
			</div>
		</div>
    </div>
</template>

<script>

export default {
    
}
</script>