<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IMessage extends BaseModel
{
    protected $guarded = ['id'];
    protected $ins_name = 'privatemessage';
  
    public $timestamps = false;

    function __construct() {
        parent::__construct();
    }

    public $createRule = [
    	'messagecontent'=> 'required',
    	'recipienttype'=> 'required',
    	'recipientid'=> 'required'
    ];

    public function c($rq = null)
    {
    	$type = [
    		'employee' => 1,
    		'agency' => 2,
    		'doctor' => 3
    	];

    	$rq = rq();

    	$rq['senderid'] = uid();
    	$rq['sendername'] = username();
        if (he_is('agency')) {
            $rq['org'] = sess('org');
        }

        if (he_is('employee')) {
            $rq['org'] = sess('org');
        }
    	// return his_chara()[0];
    	$rq['sendertype'] = $type[his_chara()[0]];
    	if (his_chara()[0] == 'agency') {
    		$rq['recipienttype'] = 1;
    		$rq['recipientid'] = 1;
    		$rq['recipientname'] = 'admin';
    	}elseif (his_chara()[0] == 'employee') {
	    	$rq['recipienttype'] = $type[$rq['recipienttype']];
    	}

        // 验证发信规则
        $valid = $this->verify($rq);
        if (!$valid) {
            return ee(2);
        }
        $rq['sendtime'] = date("Y-m-d H:i:s");

    	return parent::c($rq);
    }

    public function verify($rq = null)
    {
        if ($rq['sendertype'] == 1) {
            return true;
        };

        if ($rq['sendertype'] == 2 && $rq['recipientname'] == 'admin') {
            return true;
        };
        return true;
    }

    public function read()
    {
        $id = rq('id');
        $data = $this->find($id);
        $res = 0;
        if($data->recipientid == uid()){
            $data->read = 1;
            $res = $data->save();
        }
        return ss($res);
    }
}
