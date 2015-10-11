<section id="main-content">
    <!--tiles start-->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">查询条件</h3>
                    <div class="actions pull-right">
                        <i class="fa fa-chevron-down" i-toggle data-toggle="collapse" data-target="#form_query" aria-expanded="false" aria-controls="collapseExample"></i>
                    </div>
                </div>
                <div class="panel-body">
                    <div role="grid" id="example_wrapper" class="dataTables_wrapper form-inline no-footer">
                        <div class="row col-md-12 search_panel" ng-if="SIns.show_search_panel">
                            <form class="collapse" id="form_query">
                                <div class="form-group">
                                    <input class="form-control"
                                           ng-model-options="{debounce: 300}"
                                           ng-model="SIns.cond.where.id"
                                           placeholder="编号搜索">
                                </div>
                                <div class="form-group">
                                    <input class="form-control"
                                           ng-model-options="{debounce: 300}"
                                           ng-model="SIns.cond.where_has.doctor.name"
                                           placeholder="医生姓名">
                                </div>
                                <div class="form-group">
                                    <input class="form-control"
                                           ng-model-options="{debounce: 300}"
                                           ng-model="SIns.cond.where.name"
                                           placeholder="名称">
                                </div>
                                <div class="form-group">
                                    <select class="form-control"
                                            name="province_id"
                                            ng-model="SIns.cond.where.province_id"
                                            ng-options="l.id as l.name for l in SBase._.location.province"
                                            required>
                                        <option value="" selected>所在省份</option>
                                    </select>
                                    <select class="form-control"
                                            ng-model="SIns.cond.where.city_id"
                                            ng-options="l.id as l.name for l in SBase._.location.city
                                                    | filter: {parent_id: SIns.cond.where.province_id}"
                                            name="province"
                                            required>
                                        <option value="" selected>所在市区</option>
                                    </select>
                                </div>
                                {{--<div class="form-group">--}}
                                {{--<div>--}}
                                {{--代理类型：--}}
                                {{--<label for="agency_type_any">不限--}}
                                {{--<input ng-model="SIns.cond.where_has.agency." id="agency_type_any" type="radio" name="agency_type" value="1"--}}
                                {{--checked>--}}
                                {{--</label>--}}

                                {{--<label for="agency_type_self">自营--}}
                                {{--<input ng-model="SIns.cond.where_has.agency." id="agency_type_self" type="radio" name="agency_type" value="2">--}}
                                {{--</label>--}}

                                {{--<label for="agency_type_agency">代理--}}
                                {{--<input ng-model="SIns.cond.where_has.agency." id="agency_type_agency" type="radio" name="agency_type" value="3">--}}
                                {{--</label>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dataTables_length" id="example_length">
                                    <button class="btn btn-default fr"
                                            ng-click="SIns.popup_edit(null)">创建
                                    </button>
                                </div>
                            </div>
                        </div>
                        <table
                                id="example"
                                class="table
                               table-striped
                               table-bordered
                               dataTable
                               no-footer"
                                cellspacing="0"
                                width="100%"
                                aria-describedby="example_info"
                                style="width: 100%;">
                            <thead>
                            <tr role="row">
                                <th>id</th>
                                <th>所在地区</th>
                                <th>医院</th>
                                <th>医生人数</th>
                                <th>科室数</th>
                                <th>代理数</th>
                                <th>备注</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="odd"
                                ng-repeat="row in SIns.current_page_data | orderBy: row.id ">
                                <td class="sorting_1">[:row.id:]</td>
                                <td>
                                    <span ng-repeat="l in SBase._.location.province |filter:{id: row.province_id}:true">[:l.name:]</span>
                                    •
                                    <span ng-repeat="l in SBase._.location.city |filter:{id: row.city_id }:true">[:l.name :]</span>
                                </td>
                                <td>[:row.name:]</td>
                                <td>[:row.doctor.length:]</td>
                                <td>[:row.department.length:]</td>
                                <td>[:row.agency.length:]</td>
                                <td title="[:row.memo:]" >
                                    <button href="" ng-if="row.memo.length>0"  ng-click="SIns.popup_edit(row,0)">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    {{-- <i class="icon-file-alt"></i> --}}
                                    </button>
                                    <a href="#modal" ng-if="row.memo.length==0">             </a>
                                </td>
                    </div>
                                <td class="edit col-md-2">
                                    <span class="tool_wrapper">
                                        <button class="btn btn-default" href="" ng-click="SIns.popup_edit(row,0)">
                                            编辑
                                        </button>
                                        <button class="btn btn-default" href=""
                                                ui-sref="base.department_doctor({hid: row.id})">
                                            科室/医生
                                        </button>
                                        {{--<span href="" class="curp delete"--}}
                                              {{--ng-click="SIns.d(row.id)">删除</span>--}}
                                    </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-xs-6">
                            </div>
                            <pagination
                                    {{--boundary-links="true"--}}
                                    total-items="SIns.total_items"
                                    items-per-page="SIns.items_per_page"
                                    ng-model="SIns.cond.pagination"
                                    ng-change="SIns.change_page(SIns.cond.pagination)"
                                    class="pagination-md"
                                    previous-text="<"
                                    next-text=">"
                                    first-text="第一页"
                                    {{--items-per-page="5"--}}
                                    last-text="最后一页"
                                    >
                            </pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
