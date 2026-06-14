<?php

namespace App\Services;

use App\Models\Audit\AuditInit;
use App\Models\AuditNotificationLetter;

class AuditInitService {

    /**
     * Function to store new audit init
     * @param $payload
     */
    public function store($payload)
    {
        $exp_date = explode(' - ', $payload['audit_time']);
        $start = $exp_date[0];
        $end = $exp_date[1];
        $payload['start_time'] = $start;
        $payload['end_time'] = $end;
        unset($payload['audit_time']);

        AuditInit::create($payload);

        return true;
    }

    /**
     * Function to store new notification letter
     *
     * @param $payload
     * @return bool
     */
    public function storeNotificationLetter($payload)
    {
        AuditNotificationLetter::create($payload);

        return true;
    }

    /**
     * Function to update current notification letter
     * @param $payload
     * @param $id
     *
     * @return bool
     */
    public function updateNotificationLetter($payload, $id)
    {
        AuditNotificationLetter::where('id', $id)
            ->update($payload);

        return true;
    }

    public function deleteNotificationLetter($id)
    {
        AuditNotificationLetter::find($id)->delete();

        return true;
    }
}
