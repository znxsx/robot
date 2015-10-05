@include('seg.head')
<body class="animated fadeIn" ng-app="base_app">
<section id="login-container">

    <div class="row">
        <div class="col-md-3" id="login-wrapper">
            <div class="panel panel-primary animated flipInY">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        睿米医疗机器人运营管理系统
                    </h3>
                </div>
                <div class="panel-body" ng-cloak>
                    <form ng-submit="c_form_auth.submit()"
                          name="formAuth"
                          ng-controller="CFormAuth as c_form_auth"
                          class="form-horizontal"
                          role="form">
                        <div class="form_container">
                            <p class="error" ng-if="c_form_auth.login_fail && c_form_auth.auth_type == 'login'"
                                    >用户名或密码错误</p>
                            <tabset justified="true">
                                <tab heading="厂商" select="c_form_auth.on_tab_change('employee', 'login')">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input required
                                                   name="username"
                                                   ng-model="c_form_auth.vals.username"
                                                   ng-model-options="{debounce: 300}"
                                                   type="username"
                                                   class="form-control"
                                                   id="username"
                                                   placeholder="用户名">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input required
                                                   name="password"
                                                   ng-model="c_form_auth.vals.password"
                                                   ng-model-options="{debounce: 300}"
                                                   type="password"
                                                   class="form-control"
                                                   id="password"
                                                   placeholder="密码">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit"
                                                    ng-disabled="formAuth.$invalid"
                                                    class="btn btn-primary btn-block">登录
                                            </button>
                                            <hr/>
                                        </div>
                                    </div>
                                </tab>
                                <tab heading="医院科室用户" select="c_form_auth.on_tab_change('department', 'login')">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input required
                                                   name="username"
                                                   ng-model="c_form_auth.vals.username"
                                                   ng-model-options="{debounce: 300}"
                                                   type="username"
                                                   class="form-control"
                                                   id="username"
                                                   placeholder="用户名">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input required
                                                   name="password"
                                                   ng-model="c_form_auth.vals.password"
                                                   ng-model-options="{debounce: 300}"
                                                   type="password"
                                                   class="form-control"
                                                   id="password"
                                                   placeholder="密码">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit"
                                                    ng-disabled="formAuth.$invalid"
                                                    class="btn btn-primary btn-block">登录
                                            </button>
                                            <hr/>
                                        </div>
                                    </div>
                                </tab>
                                <tab heading="代理商" select="c_form_auth.on_tab_change('agency', 'login')">
                                    <div class="form-group" ng-if="c_form_auth.auth_type == 'login'">
                                        <div class="col-md-12">
                                            <a ng-click="c_form_auth.auth_type = 'signup'"
                                               href="">我要注册</a>
                                        </div>
                                    </div>
                                    <div class="form-group" ng-if="c_form_auth.auth_type == 'signup'">
                                        <div class="col-md-12">
                                            <a ng-click="c_form_auth.auth_type = 'login'"
                                               href="">登录</a>
                                        </div>
                                    </div>
                                    <div class="login_fields">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input type="text"
                                                       name="username"
                                                       ng-minlength="{{conf('v_rule.user_name.min_length')}}"
                                                       ng-maxlength="{{conf('v_rule.user_name.max_length')}}"
                                                       la-pattern="{{conf('v_rule.user_name.pattern')}}"
                                                       la-exist="agency.username"
                                                       class="form-control"
                                                        {{--id="username"--}}
                                                       placeholder="用户名"
                                                       ng-model="c_form_auth.vals.username"
                                                       ng-model-options="{debounce: 300}"
                                                       ng-model-options="{debounce: 600}"
                                                       ng-model-options="{debounce: 300}"
                                                       required
                                                       autofocus>

                                                <div class="error"
                                                     ng-if="formAuth.username.$error.laExist && formAuth.username.$touched">
                                                    用户名已存在
                                                </div>
                                                <div class="error"
                                                     ng-if="formAuth.username.$invalid && formAuth.username.$touched"
                                                        >用户名长度应在{{conf('v_rule.user_name.min_length')}}
                                                    位至{{conf('v_rule.user_name.max_length')}}之间，由数字或字母组成
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input type="password"
                                                       name="password"
                                                       ng-minlength="{{conf('v_rule.password.min_length')}}"
                                                       ng-maxlength="{{conf('v_rule.password.max_length')}}"
                                                       la-pattern="{{conf('v_rule.password.pattern')}}"
                                                       ng-model="c_form_auth.vals.password"
                                                       ng-model-options="{debounce: 300}"
                                                       class="form-control"
                                                       placeholder="密码"
                                                       id="password_field"
                                                       required>

                                                <div class="error"
                                                     ng-if="formAuth.password.$invalid && formAuth.password.$touched"
                                                        >密码长度应在{{conf('v_rule.password.min_length')}}
                                                    位至{{conf('v_rule.password.max_length')}}之间，由数字或字母组成，至少包含一个字母
                                                </div>
                                                <span ng-if="c_form_auth.auth_type == 'signup'" la-toggle-input-type
                                                      la-target="password_field">按住看一眼</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div ng-if="c_form_auth.auth_type == 'signup'"
                                         class="signup_fields">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input required
                                                       name="name"
                                                       ng-model="c_form_auth.vals.name"
                                                       ng-model-options="{debounce: 300}"
                                                       type="text"
                                                       class="form-control"
                                                       id="name"
                                                       placeholder="公司名称">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <select class="form-control"
                                                        name="province_id"
                                                        ng-model="c_form_auth.vals.province_id"
                                                        ng-model-options="{debounce: 300}"
                                                        ng-options="l.id as l.name for l in SBase._.location.province"
                                                        required>
                                                    <option value="" selected>公司所在省份</option>
                                                </select>
                                                {{--<div class="" ng-repeat="l in SBase._.location.province"></div>--}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <select class="form-control"
                                                        ng-model="c_form_auth.vals.city_id"
                                                        ng-model-options="{debounce: 300}"
                                                        ng-options="l.id as l.name for l in SBase._.location.city
                                                    | filter: {parent_id: c_form_auth.vals.province_id}"
                                                        name="province"
                                                        required>
                                                    <option value="" selected>公司所在市区</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input required
                                                       name="name_in_charge"
                                                       ng-model="c_form_auth.vals.name_in_charge"
                                                       ng-model-options="{debounce: 300}"
                                                       type="text"
                                                       class="form-control"
                                                       id="name_in_charge"
                                                       placeholder="负责人姓名">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input required
                                                       name="phone"
                                                       ng-model="c_form_auth.vals.phone"
                                                       ng-model-options="{debounce: 300}"
                                                       type="number"
                                                       class="form-control"
                                                       id="phone"
                                                       placeholder="手机">
                                                <div class="error"
                                                     ng-if="formAuth.phone.$invalid && formAuth.phone.$touched">
                                                    手机填写有误
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input required
                                                       type="email"
                                                       name="email"
                                                       ng-model="c_form_auth.vals.email"
                                                       ng-model-options="{debounce: 300}"
                                                       type="text"
                                                       class="form-control"
                                                       id="email"
                                                       placeholder="邮箱">
                                                <div class="error"
                                                     ng-if="formAuth.email.$invalid && formAuth.email.$touched">
                                                    邮箱填写有误
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" ng-if="c_form_auth.auth_type == 'login'">
                                        <div class="col-md-12">
                                            <button type="submit"
                                                    ng-disabled="formAuth.$invalid"
                                                    class="btn btn-primary btn-block">登录
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group" ng-if="c_form_auth.auth_type == 'signup'">
                                        <div class="col-md-12">
                                            <button type="submit"
                                                    ng-disabled="formAuth.$invalid"
                                                    class="btn btn-primary btn-block">注册
                                            </button>
                                        </div>
                                    </div>
                                </tab>
                            </tabset>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('seg.foot')
