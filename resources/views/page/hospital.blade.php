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
                        <i class="fa fa-chevron-down" i-toggle data-toggle="collapse" data-target="#form_query"
                           aria-expanded="false" aria-controls="collapseExample"></i>
                    </div>
                </div>
                <div class="panel-body">
                    <div role="grid" id="example_wrapper" class="dataTables_wrapper form-inline no-footer">
                        <div class="row col-md-12 search_panel" ng-if="SIns.with_search">
                            <form class=" form-horizontal" id="form_query">
                                <div class="form-group">
                                    <label class="control-label col-md-1">编号</label>
                                    <div class="col-md-8">
                                        <input class="form-control"
                                               ng-model-options="{debounce: 300}"
                                               ng-model="SIns.cond.where.id"
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-1">地区</label>
                                    <div class="col-md-8">
                                        <select class="form-control"
                                                name="province_id"
                                                ng-model="SIns.cond.where.province_id"
                                                ng-options="l.id as l.name for l in SBase._.location.province"
                                        >
                                            <option value="" selected>所在省份</option>
                                        </select>
                                        <select class="form-control"
                                                ng-model="SIns.cond.where.city_id"
                                                ng-options="l.id as l.name for l in SBase._.location.city
                                                            | filter: {parent_id: SIns.cond.where.province_id}"
                                                name="province"
                                        >
                                            <option value="" selected>所在市区</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-1">名称</label>
                                    <div class="col-md-8">
                                        <input class="form-control"
                                               ng-model-options="{debounce: 300}"
                                               ng-model="SIns.cond.where.name"
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-1">医生</label>
                                    <div class="col-md-8">
                                        <input class="form-control"
                                               ng-model-options="{debounce: 300}"
                                               ng-model="SIns.cond.where_has.doctor.name"
                                               placeholder="">
                                    </div>
                                    <div class="col-md-1 pull-right">
                                        <button class="btn-custom" ng-click="SIns.refresh()">查询</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <table id="example"  class="table  table-striped  table-bordered dataTable  no-footer" aria-describedby="example_info">
                <thead>
                    <tr role="row">
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
                        <td class="sorting_1">[:row.id:]</td>
                        <td>
                            <span ng-repeat="l in SBase._.location.province |filter:{id:row.province_id}:equalsId">[:l.name:]</span>
                            •<span ng-repeat="l in SBase._.location.city |filter:{id: row.city_id }:equalsId">[:l.name :]</span>
                        </td>
                        <td>[:row.name:]</td>
                        <td>[:row.department.length:]</td>
                        <td>[:row.doctor.length:]</td>
                        <td>[:row.agency.length:]</td>
                        <td title="[:row.memo:]" >
                            <button href="" ng-if="row.memo.length>0"  ng-click="SIns.popup_edit(row,1)">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                {{-- <i class="icon-file-alt"></i> --}}
                            </button>
                            <a href="#modal" ng-if="row.memo.length==0">             </a>
                        </td>
                        <td class="edit col-md-2">
                            <span class="tool_wrapper">
                                <button class="btn-custom" href=""
                                        ui-sref="base.department_doctor({hid: row.id})">
                                    管理科室/医生
                                </button>
                                <button class="btn-custom" href="" ng-click="SIns.popup_edit(row,0)">
                                    编辑
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
                <div class="pull-right">
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
</section>
