<?php

namespace App\Models;

use Hamcrest\BaseMatcher;
use Illuminate\Database\Eloquent\Model;

use Event, App\Events\UserSignup;
use DB, Input;

class IAgency extends BaseModel
{
    use AuthTrait;

    protected $guarded = ['id', 'password'];
    protected $table = null;
    protected $ins_name = 'agency';

    public $hidden = ['password'];

    public function __construct()
    {
        parent::__construct();

        $this->table = table_name($this->ins_name);

        $this->createRule = [
            'name'              =>      'string',
            'name_in_charge'    =>      'string',
            'city_id'           =>      'required|numeric',
            'province_id'       =>      'required|numeric',
            'location_detail'   =>      'string',
            'username'          =>      'required|unique:' . table_name($this->ins_name),
            'password'          =>      'required|min:6|regex:/^(?=.*[a-zA-Z])(?=.*[\d])[a-zA-Z\d].+$/',
            'phone'             =>      'numeric|min:11',
            'email'             =>      'email',
            'status'            =>      'numeric',
            'memo'              =>      'string',
        ];

        $this->updateRule = [
            'id'       => 'required|numeric',
            'password' => 'min:6|regex:/^(?=.*[a-zA-Z])(?=.*[\d])[a-zA-Z\d].+$/',
            'phone'    => 'required',
            'email'    => 'required|email',
        ];
        
        $this->messages = [
            'username.required' => '用户名必填',
            'username.unique' => '用户名已被使用',
            'password.required' => '密码必填',
            'password.regex' => '密码不符合要求，必选包含字母和数字',
            'password.min' => '密码必须大于6位',
            'phone.required' => '手机号码必填',
            'email.required' => '电子邮箱必填',
            'email.email' => '邮箱格式有误'
        ];
    }

    /**
     * 创建
     */
    public function c($rq = NULL)
    {
        $this->guarded = arr_except_vals($this->guarded, ['password']);

        if (!$rq) {
            $rq = rq();
        }
        
        return parent::c($rq);
    }

    public function toggle()
    {
        $s = !rq('s');
        $agency = rq('id');
        $s ? $event = 'enable' : $event = 'disable';
        $this->eventFire($event, $agency);
        
        return [
            'status' => $this->where('id', $agency)->update(['status'=> $s]),
            'd'=> $s
        ];
    }
    
    public function searchHospital()
    {
        $agency = rq('id');
        
        $data = DB::table('i_mark')->select('i_hospital.name as hospital_name','i_hospital.city_id as city_id'
            ,'i_hospital.province_id as province_id')
        ->where('agency_id', $agency)
        ->where('hospital_id', '!=', -1)
        ->leftJoin('i_hospital', 'i_mark.hospital_id', '=', 'i_hospital.id')
        ->groupBy('i_mark.hospital_id')->get();
        
        return ss($data);
    }

    public function r()
    {
        if (rq('log') && Input::has('where.id')) {
            $this->eventFire('r', Input::get('where.id'));
        }

        return parent::r();
    }

    /**
     * 更新
     */
    public function u($rq = NULL)
    {
        // 代理只能修改自己
        if (he_is('agency')) {
            if (rq('id') != uid()) {
                abort(403);
            }
        }

        $this->guarded = arr_except_vals($this->guarded, ['password']);

        if (!$rq) {
            $rq = rq();
        }

        if (isset($rq['ended_at']) && $rq['ended_at'] == 'Invalid date') {
            unset($rq['ended_at']);
        }
        if (isset($rq['started_at']) && $rq['started_at'] == 'Invalid date') {
            unset($rq['started_at']);
        }
        return parent::u($rq);
    }

    public function valid()
    {
        $data = $this->whereNotNull('started_at')->whereRaw('ended_at > now() and status=1')->get();

        return ss($data);
    }

    public function todo()
    {   
        // 获取过期设置

        $data = $this->select('*')
            ->whereRaw('timestampdiff(day, created_at, now()) < 2')
            ->orWhereRaw('(ended_at is not null and datediff(ended_at, now()) between 0 and 10)')
            ->get();
        return ss($data);
    }

    public function me()
    {
        $data = $this->where('id', uid())->first();
        return ss($data);
    }

    public function change_password($row = null)
    {
        $row = $row ? $row : rq();

        $ins = $this->find($row['id']);
        $ins->password = hash_password($row['password']);
        $r = $ins->save();
        return $r ? ss($r) : ee(1);
    }

    /**
     * 触发事件
     */
    public function eventFire($method, $data= null)
    {
        if ($method === 'c') {
            $response = Event::fire(new UserSignup);
        }

        parent::eventFire($method, $data);
    }

    /**
     * 关联Mark
     */
    public function mark()
    {
         return $this->hasMany('App\Models\IMark', 'agency_id');
    }

    public function robot()
    {
         return $this->hasMany('App\Models\IRobot', 'agency_id');
    }

    /**
     * 关联已销售的Mark
     *
     * @todo 待完成
     */
    public function markLeased()
    {
         return $this->hasMany('App\Models\IMark', 'agency_id');
    }

    /**
     * 关联库存的Mark
     *
     * @todo 待完成
     */
    public function markStock()
    {
         return $this->hasMany('App\Models\IMark', 'agency_id');
    }

    /**
     * 关联机器人销售记录
     */
    public function robotLeaseLog()
    {
         return $this->hasMany('App\Models\VRobotLeaseLog', 'agency_id');
    }

    public function hospital()
    {
        return $this->belongsToMany('App\Models\IHospital', 'r_agency_hospital', 'agency_id', 'hospital_id');
    }
}
