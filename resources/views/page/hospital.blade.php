{{-- 医院列表页
router:
controller:CPageHospital
url:
--}}
<section id="main-content">
    <!--tiles start-->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default black-border">
                <div class="panel-heading">
                    <h3 class="panel-title">查询条件</h3>

                    <div class="actions pull-right">
                        <i class="fa fa-chevron-up" i-toggle data-toggle="collapse" data-target="#form_query"
                           aria-expanded="false" aria-controls="collapseExample"></i>
                    </div>
                </div>
                <div class="panel-body">
                    <div role="grid" id="example_wrapper" class="dataTables_wrapper form-inline no-footer">
                        <div class="row col-md-12 search_panel" ng-if="SIns.with_search">

                        </div>
                    </div>
                    <form class="collapse in form-horizontal" id="form_query" style="width:100%">
                        <div class="form-group">
                            <label class="control-label col-md-1">编号</label>

                            <div class="col-md-6">
                                <input class="form-control"
                                       ng-model-options="{debounce: 300}"
                                       ng-model="SIns.cond.where.id"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-1">地区</label>

                            <div class="col-md-3">
                                <select name="province_id"
                                        chosen
                                        class="form-control"
                                        update="SBase._.location.province"
                                        ng-model="SIns.cond.where.province_id"
                                        ng-options="l.id as l.name for l in SBase._.location.province">
                                    <option value="">不限</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="city_id"
                                        chosen
                                        class="form-control"
                                        update="SIns.cond.where.province_id"
                                        ng-model="SIns.cond.where.city_id"
                                        ng-options="l.id as l.name for l in SIns.cond.where.province_id&&SBase._.location.city|| []| filter: {parent_id: SIns.cond.where.province_id}:true">
                                    <option value="">不限</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-1">名称</label>

                            <div class="col-md-6">
                                <input class="form-control"
                                       ng-model-options="{debounce: 300}"
                                       ng-model="SIns.cond.where.name"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-1">医生</label>

                            <div class="col-md-6">
                                <input class="form-control"
                                       ng-model-options="{debounce: 300}"
                                       ng-model="SIns.cond.where.doctor"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="form-group col-md-12 text-right">
                            <button class="btn-primary btn-custom btn " ng-click="SIns.refresh()">查询</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="example" class="table  table-striped  table-bordered dataTable table-hover no-footer"
                   aria-describedby="example_info">
                <thead>
                <tr role="row" class="info">
                    <th>编号</th>
                    <th>地区</th>
                    <th>医院名称</th>
                    <th>科室</th>
                    <th>医生</th>
                    <th>代理商</th>
                    <th>备注</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr class="odd"
                    ng-repeat="row in SIns.current_page_data | orderBy: row.id ">
                    <td class="sorting_1 col-md-1">[:row.id:]</td>
                    <td class="col-md-2">
                        <span ng-repeat="l in SBase._.location.province |filter:{id:row.province_id}:equalsId">[:l.name:]</span>
                        •<span ng-repeat="l in SBase._.location.city |filter:{id: row.city_id }:equalsId">[:l.name :]</span>
                    </td>
                    <td class="col-md-2">[:row.name:]</td>
                    <td class="col-md-1">[:row.count_department:]</td>
                    <td class="col-md-1">[:row.count_doctor:]</td>
                    <td class="col-md-1">[:row.count_agency:]</td>
                    <td class="col-md-2" title="[:row.memo:]">
                        <button class="btn-default btn-custom btn btn-sm" href="" ng-if="row.memo.length>0" ng-click="SIns.popup_edit(row,1)">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            {{-- <i class="icon-file-alt"></i> --}}
                        </button>
                        <a href="#modal" ng-if="row.memo.length==0"> </a>
                    </td>
                    <td class="edit col-md-2 hospital-list-edit">
                            <span class="tool_wrapper">
                                <a class="btn-primary btn-custom btn btn-sm" target="_blank"
                                   href="#/hospital/department_doctor/[:row.id:]?log=1">
                                    管理科室/医生
                                </a>
                                <button class="btn-primary btn-custom btn btn-sm"
                                        ui-sref="base.hospital.edit({hid:row.id})">
                                    编辑
                                </button>
                                {{--<span href="" class="curp delete"--}}
                                {{--ng-click="SIns.d(row.id)">删除</span>--}}
                            </span>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="pagination_wrapper" ng-init="pagination = SIns.cond.pagination || 1">
                <span class="pull-left">记录: [:(pagination-1)* default_paginataion_limit +  (SIns.total_items/SIns.total_items) || 0:] / [:SIns.total_items:]</span>
                <pagination
                        {{--boundary-links="true"--}}
                        total-items="SIns.total_items"
                        items-per-page="default_paginataion_limit"
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
</section>
