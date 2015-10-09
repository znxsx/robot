<div class="container panel">
  <div class="panel-body">
      
    <form ng-submit="SIns.cu_bat(SIns.current_row)"
          name="form_mark_bind"
          class="form-inline" 
          ng-controller="CPageMark">
        @if(he_is('agency'))
            <input type="hidden" ng-init="SIns.cu_bat_data.agency_id = {{uid()}}">
        @elseif(he_is('employee'))
            <input type="hidden" ng-init="SAgency.get_all_rec()">
        @endif

        {{--[:SIns.current_row:]--}}
        <div class="error form-group">
            <p class="error" ng-if="form_mark_bind.mark_list.$error.laRowNumMatch && form_mark_bind.mark_list.$touched">
                编号总数与行数不匹配</p>

            <p class="error" ng-if="form_mark_bind.mark_list.$invalid && form_mark_bind.$touched">请检查表单输入</p>

            <div ng-if="SIns.invalid_mark_list.length">
                以下mark已存在：
                <div class="error" ng-repeat="l in SIns.invalid_mark_list"> [:l:]</div>
            </div>
        </div>
        <div class="form-group pull-left">
            <label class="control-label">Mark编号列表</label>
        </div>
        <div class="form-group pull-right">
            <label class="control-label">Mark输入总数</label>
            <input ng-model="SIns.cu_bat_data.bind_amount"
                   class="form-control"
                   type="number"
                   name="bind_amount"
                   required>
        </div>
        <div class="form-group col-md-12">
            <textarea ng-model="SIns.cu_bat_data.mark_block"
                      class="form-control col-md-12"
                      rows="10"
                      name="mark_list"
                      style="width:100%" 
                      cols="175"
                      array-receiver="SIns.cu_bat_data.mark_list"
                      la-row-num-match="SIns.cu_bat_data.bind_amount"
                      placeholder="每行一条Mark编号，行数需与总数相等，总数尽量不超过500条"
                      required>
                </textarea>
        </div>
        @if(he_is('employee'))
            <div class="form-group pull-right">
                <label class="control-label">
                  <button type="submit" class="btn btn-primary" ng-disabled="form_mark_bind.$invalid">绑定</button>
                </label>
                <select class="form-control"
                        name="agency_id"
                        ng-init="SIns.cu_bat_data.agency_id = 1"
                        ng-model="SIns.cu_bat_data.agency_id"
                        ng-options="l.id as l.name for l in SAgency.all_rec | orderBy: 'id'"
                        required>
                </select>
            </div>
        @endif
        <!-- <div class="form-group">
            <label>医院</label>
            <select class="form-control"
                    name="hospital_id"
                    ng-init="SIns.cu_bat_data.hospital_id = 1"
                    ng-model="SIns.cu_bat_data.hospital_id"
                    ng-options="l.id as l.name for l in SHospital.all_rec | orderBy: 'id'"
                    required>
            </select>
        </div> -->
    </form>
  </div>
</div>
