<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Search Model
 *
 * @author      Ticketing
 * @author      OSS Dev Team
 * @package     TTS-TE\application\Modules\Searches\Models
 *
 * DST NOTE:
 * The created_at column stores Unix timestamps (seconds since 1970-01-01 UTC).
 * Previously this model converted timestamps to human-readable dates using a
 * hardcoded Oracle expression:
 *
 *     TO_DATE('19700101','yyyymmdd') + (("t"."created_at" + 7200)/24/60/60)
 *
 * The constant +7200 (= 2 hours) represents Egypt winter time (UTC+2).
 * Every time Egypt switched to summer time (UTC+3 = +10800 s) the value
 * had to be manually changed to +10800, and back again in autumn.
 *
 * FIX: Use Oracle's built-in timezone support instead.
 * We convert the Unix timestamp to a UTC TIMESTAMP WITH TIME ZONE and then
 * apply AT TIME ZONE 'Africa/Cairo'. Oracle's timezone data automatically
 * handles DST — no manual change is ever required again.
 *
 * Oracle expression used:
 *   FROM_TZ(
 *       CAST(DATE '1970-01-01' + "t"."created_at"/86400 AS TIMESTAMP),
 *       'UTC'
 *   ) AT TIME ZONE 'Africa/Cairo'
 *
 * The outer TO_CHAR formats it as 'DD-MM-YYYY HH24:MI:SS'.
 */
class Search_model extends MY_Model
{
    /**
     * get_ticket_quick_search()
     *
     * @param  array  $data_search  Associative array of WHERE conditions
     * @return object|false         CI DB result object or FALSE
     */
    public function get_ticket_quick_search($data_search)
    {
        if ( ! empty($data_search))
        {
            /*
             * DST-SAFE DATE CONVERSION
             * -------------------------
             * Oracle converts the stored UTC Unix timestamp to a
             * TIMESTAMP WITH TIME ZONE in 'Africa/Cairo', which
             * automatically applies UTC+2 in winter and UTC+3 in summer.
             *
             * No manual offset changes are needed during DST transitions.
             */
            $dst_safe_date_expr =
                "TO_CHAR(
                    FROM_TZ(
                        CAST(DATE '1970-01-01' + \"t\".\"created_at\" / 86400 AS TIMESTAMP),
                        'UTC'
                    ) AT TIME ZONE 'Africa/Cairo',
                    'DD-MM-YYYY HH24:MI:SS'
                ) AS created_at";

            $result = $this->db
                ->select(
                    "t.id,
                    {$dst_safe_date_expr},
                    ts.name status_name,
                    g.name group_name,
                    tc.name categrory,
                    sub.name sub_categorey,
                    cus.mobile mobile_num,
                    cus.second_mobile_no second_num,
                    serv.name service_type,
                    dev.name device_type,
                    t.service_identifier,
                    t.application_id,
                    cus.customer_name customer_name,
                    tex.text description,
                    user_.username creator_name,
                    u.username closed_by_user,
                    cty.name customer_type"
                )
                ->from('tickets t')
                ->where($data_search)
                ->join('tickets_statuses ts',      'ts.id = t.status_id',          'left')
                ->join('customers_info ci',         'ci.id = t.customers_info_id',  'left')
                ->join('area_codes ac',             'ac.id = ci.area_code_id',      'left')
                ->join('tickets_categories tc',     'tc.id = t.category_id',        'left')
                ->join('tickets_categories sub',    'sub.id = t.sub_category_id',   'left')
                ->join('customers_info cus',        'cus.id = t.customers_info_id', 'left')
                ->join('customer_types cty',        'cty.id = t.customer_type_id',  'left')
                ->join('groups g',                  'g.id = t.group_id',            'left')
                ->join('service_types serv',        'serv.id = t.service_type',     'left')
                ->join('device_types dev',          'dev.id = t.device_type',       'left')
                ->join('tickets_logs_texts tex',    'tex.ticket_id = t.id AND tex.log_type_id = 8', 'left')
                ->join('users user_',               'user_.id = t.created_by')
                ->join('users u',                   't.closed_by_user = u.id',      'left')
                ->order_by('t.id', 'DESC')
                ->get();

            if ($result)
            {
                return $result;
            }

            return FALSE;
        }
    }
}
