<div class="">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="col-md-12">
				<h3 class="panel-title pull-left">设备信息</h3>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title text-left">
				 基本信息
			</h3>
		</div>
		<div class="panel-body">
			<div class="col-md-12">
				<dl class="dl-horizontal">
					<dt>编号</dt>
					<dd>[:SIns.current_row.cust_id:]</dd>
					<dt>状态</dt>
					<dd>
						<span ng-if="SIns.current_row.lease_type_id == -1">返回库存</span>
						<span ng-if="SIns.current_row.lease_type_id == 1">出售</span>
						<span ng-if="SIns.current_row.lease_type_id == 2">出租</span>
						<span ng-if="SIns.current_row.lease_type_id == 3">免费合作</span>
					</dd>
					<dt>生产日期</dt>
					<dd>[:SIns.current_row.created_at | date : 'yyyy-MM-dd':]</dd>
					<dt>代理商</dt>
					<dd>[:SIns.current_row.last_agency.name:]</dd>
					<dt>医院</dt>
					<dd>[:SIns.current_row.last_hospital.name:]</dd>
					<dt>已用Mark</dt>
					<dd>0</dd>
					<dt>负责人</dt>
					<dd>[:SIns.current_row.employee.name:]</dd>
					<dt>提示</dt>
					<dd>无</dd>
				</dl>
			</div>
			<div class="col-md-12">
				<a class="btn btn-primary pull-right" ui-sref="base.robot.edit({id : SIns.current_row.id})">修改设备信息</a>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title text-left">
				维修记录
			</h3>
		</div>
		<div class="panel-body">
			<div class="col-md-12">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>时间</th>
							<th>类型</th>
							<th>记录人</th>
							<th>备注</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="log in SIns.current_row.robot_log">
							<td>[:log.created_at | laDate :]</td>
							<td>[:SIns.robot_fix_type[log.action_type-1].name:]</td>
							<td>[:log.employee.name:]</td>
							<td>[:log.memo | limitTo: 20:]</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-12">
				<a class="btn btn-primary pull-right" ui-sref="base.robot.log({id: SIns.current_row.id})">新建记录</a>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title text-left">
				 租售记录
			</h3>
		</div>
		<div class="panel-body">
			<div class="col-md-12">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th class="col-md-3">时间</th>
							<th>类型</th>
							<th class="col-md-3">代理商</th>
							<th class="col-md-3">医院</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="log in SIns.current_row.robot_lease_log" ng-class="{'bg-info' : log.recent}">
							<td>
								<span ng-if="log.lease_type_id == 2 || log.lease_type_id == 3">
									[:log.lease_started_at | laDate :] 到 [:log.lease_ended_at | laDate :]
								</span>
								<span ng-if="(log.lease_type_id * log.lease_type_id) == 1">
									[:log.created_at | laDate :]
								</span>
							</td>
							<td>
								<span ng-if="log.lease_type_id == -1">返回库存</span>
								<span ng-if="log.lease_type_id == 1">出售</span>
								<span ng-if="log.lease_type_id == 2">出租</span>
								<span ng-if="log.lease_type_id == 3">免费合作</span>
							</td>
							<td>[:log.agency.name:]</td>
							<td>[:log.hospital.name:]</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="col-md-12">
				<a class="btn btn-primary pull-right" ui-sref="base.robot.lease({id: SIns.current_row.id})">设置销售状态</a>
			</div>
		</div>
	</div>

</div>