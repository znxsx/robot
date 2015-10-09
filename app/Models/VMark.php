<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Input;
use DB;

class VMark extends IMark
{

    protected $guarded = ['id'];

    protected $ins_name = 'mark';

    public function __construct()
    {
        $this->table = table_name($this->ins_name, 'v');
    }

    public function r_() {
        $sql = 'select * from i_mark where 1=1 ';
        $where = [];

        if(Input::has('where.cust_id')) {
            $sql .= ' and i_mark.cust_id = ?';
            $where[] = Input::get('where.cust_id');
        }
        $status = Input::get('where.status');
        if(!empty($status)) {
            $id = array_map('intval',$status);
            $id = implode(",",$id);
            $sql .= ' and i_mark.status in ('.$id.')';
        }
        $selling_status = Input::get('where.selling_status');
        if(!empty($selling_status)) {
            $sub_sql = ' and ( 1=1 ';
            if(in_array(1,$selling_status)) {
                $sub_sql .= ' or sold = 0';
            }
            if(in_array(1,$selling_status)) {
                $sub_sql .= ' or agency_id > 0';
            }
            if(in_array(2,$selling_status)) {
                $sub_sql .= ' or hospital_id > 0';
            }
            $sub_sql .= ')';
            $sql .= $sub_sql;
        }

        $pagination = Input::get("pagination",1);
        $offset = 0;
        $perpage = 50;

        $result = DB::select(DB::raw($sql),$where);
        $r = [
            'count' => count($result),
            'main'  => array_slice($result,($pagination - 1) * $perpage,$perpage),
        ];

        return ss($r);

    }

    public function __r_()
    {
        if ( ! rq('where') && he_is('employee'))
            return $this->r();

        //$builder = $this->r_builder();
        $builder = $this;
        $rq = rq();
        if (rq('where') || he_is('agency'))
        {
            if (he_is('agency'))
            {
                $builder = $builder->where('agency_id', uid());
            }

            $where = $rq['where'];
            if ( ! empty($where['status_type_id']))
            {
                $status = $where['status_type_id'];
                switch ($status)
                {
                    case 1:
                        $builder = $builder->where(['used_at' => null, 'damaged_at' => null]);
                        break;
                    case 2:
                        $builder = $builder->whereNotNull('used_at')->where('damaged_at', null);
                        break;
                    case 3:
                        $builder = $builder->where('agency_id', '<>', 1);
                        break;
                    case 4:
                        $builder = $builder->whereNotNull('damaged_at');
                        break;
                    case 5:
                        $builder = $builder/*->whereNotNull('damaged_at')*/
                        ->whereNotNull('replacement_id');
                        break;
                }
            }

            if ( ! empty($where['selling_status_type_id']))
            {
                $status = $where['selling_status_type_id'];
                switch ($status)
                {
                    case 1:
                        $builder = $builder->where('agency_id', 1);
                        break;
                    case 2:
                        $builder = $builder->where('agency_id', '<>', 1);
                        break;
                }
            }

            if ( ! empty($where['agency_name']))
            {
                $v = $where['agency_name'];
                $builder = $builder->where('agency_name', 'like', '%' . $v . '%');
            }

            if ( ! empty($where['hospital_name']))
            {
                $v = $where['hospital_name'];
                $builder = $builder->where('hospital_name', 'like', '%' . $v . '%');
            }

            if ( ! empty($where['doctor_name']))
            {
                $v = $where['doctor_name'];
                $builder = $builder->where('doctor_name', 'like', '%' . $v . '%');
            }

            if ( ! empty($where['from_created_at']) && ! empty($where['to_created_at']))
            {
                $builder = $builder->where('created_at', '>', Carbon::parse($where['from_created_at']));
                $builder = $builder->where('created_at', '<', Carbon::parse($where['to_created_at']));
            } elseif ( ! empty($where['from_created_at']))
            {
                $builder = $builder->where('created_at', '>', Carbon::parse($where['from_created_at']));
            } elseif ( ! empty($where['to_created_at']))
            {
                $builder = $builder->where('created_at', '<', Carbon::parse($where['to_created_at']));
            }

            if ( ! empty($where['from_sold_at']) && ! empty($where['to_sold_at']))
            {
                $builder = $builder->where('sold_at', '>', Carbon::parse($where['from_sold_at']));
                $builder = $builder->where('sold_at', '<', Carbon::parse($where['to_sold_at']));
            } elseif ( ! empty($where['from_sold_at']))
            {
                $builder = $builder->where('sold_at', '>', Carbon::parse($where['from_sold_at']));
            } elseif ( ! empty($where['to_sold_at']))
            {
                $builder = $builder->where('sold_at', '<', Carbon::parse($where['to_sold_at']));
            }

            if ( ! empty($where['from_used_at']) && ! empty($where['to_used_at']))
            {
                $builder = $builder->where('used_at', '>', Carbon::parse($where['from_used_at']));
                $builder = $builder->where('used_at', '<', Carbon::parse($where['to_used_at']));
            } elseif ( ! empty($where['from_used_at']))
            {
                $builder = $builder->where('used_at', '>', Carbon::parse($where['from_used_at']));
            } elseif ( ! empty($where['to_used_at']))
            {
                $builder = $builder->where('used_at', '<', Carbon::parse($where['to_used_at']));
            }

            if ( ! empty($where['from_damaged_at']) && ! empty($where['to_damaged_at']))
            {
                $builder = $builder->where('damaged_at', '>', Carbon::parse($where['from_damaged_at']));
                $builder = $builder->where('damaged_at', '<', Carbon::parse($where['to_damaged_at']));
            } elseif ( ! empty($where['from_damaged_at']))
            {
                $builder = $builder->where('damaged_at', '>', Carbon::parse($where['from_damaged_at']));
            } elseif ( ! empty($where['to_damaged_at']))
            {
                $builder = $builder->where('damaged_at', '<', Carbon::parse($where['to_damaged_at']));
            }

            if ( ! empty($where['from_archive_at']) && ! empty($where['to_archive_at']))
            {
                $builder = $builder->where('archive_at', '>', Carbon::parse($where['from_archive_at']));
                $builder = $builder->where('archive_at', '<', Carbon::parse($where['to_archive_at']));
            } elseif ( ! empty($where['from_archive_at']))
            {
                $builder = $builder->where('archive_at', '>', Carbon::parse($where['from_archive_at']));
            } elseif ( ! empty($where['to_archive_at']))
            {
                $builder = $builder->where('archive_at', '<', Carbon::parse($where['to_archive_at']));
            }

            if ( ! empty($where['from_surgery_at']) && ! empty($where['to_surgery_at']))
            {
                $builder = $builder->where('surgery_at', '>', Carbon::parse($where['from_surgery_at']));
                $builder = $builder->where('surgery_at', '<', Carbon::parse($where['to_surgery_at']));
            } elseif ( ! empty($where['from_surgery_at']))
            {
                $builder = $builder->where('surgery_at', '>', Carbon::parse($where['from_surgery_at']));
            } elseif ( ! empty($where['to_surgery_at']))
            {
                $builder = $builder->where('surgery_at', '<', Carbon::parse($where['to_surgery_at']));
            }

            //if ( ! empty($where['surgery_date']))
            //{
            //    $v = $where['surgery_date'];
            //    switch ($v)
            //    {
            //
            //    }
            //}
        }

        if (array_key_exists('archive_at', $rq['where']))
            $builder = $builder->where('archive_at', $rq['where']['archive_at']);

        if(he_is('department'))
        {
            $dep_ins = M('department');
            $dep_ins = $dep_ins->where('id', uid())->first();
            $builder = $this->whereHas('hospital', function($q) use ($dep_ins)
            {
                $q->where('id', $dep_ins->hospital_id);
            });
        }

        $builder = $builder->limit(50);
        $main = $builder->get();

        return ss([
            'main'  => $main,
            'count' => $builder->count(),
        ]);
    }
}
