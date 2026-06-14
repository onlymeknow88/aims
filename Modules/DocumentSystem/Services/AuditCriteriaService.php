<?php

namespace App\Services;

use App\Models\Audit\AuditCriteria;
use App\Models\Audit\AuditSubCriteria;
use App\Models\Audit\AuditSubCriteriaAttribute;

class AuditCriteriaService
{

    /**
     * Function to store new criteria
     * @param $payload
     * @return true
     */
    public function storeCriteria($payload): bool
    {
        \App\Models\Audit\AuditCriteria::create($payload);

        return true;
    }

    /**
     * Function to update current criteria
     * @param $payload
     * @return true
     */
    public function update($payload): bool
    {
        $model = AuditCriteria::find($payload['id']);
        $model->name = $payload['name'];
        $model->total_point = $payload['total_point'];
        $model->save();

        return true;
    }

    /**
     * Function to delete criteria
     * @param $ids
     * @return void
     */
    public function delete($ids)
    {
        if (gettype($ids) != 'array') {
            $ids = [$ids];
        }
        if (count($ids) > 0) {
            for ($a = 0; $a < count($ids); $a++) {
                $m = AuditCriteria::find($ids[$a]);
                /**
                 * TODO: Check relation
                 */
                $m->delete();
            }
        }
    }

    /**
     * Function to create new sub criteria
     * @param $payload
     * @return AuditSubCriteria
     */
    public function storeSubCriteria($payload): AuditSubCriteria
    {
        $model = new AuditSubCriteria();
        $model->audit_criteria_id = $payload['criteria_id'];
        $model->name = $payload['name'];
        $model->target_point = $payload['target_point'];
        $model->save();

        return $model;
    }

    /**
     * Function to update current sub criteria
     *
     * @param $payload
     * @param $id
     * @return mixed
     */
    public function updateSubCriteria($payload, $id)
    {
        $model = AuditSubCriteria::find($id);
        $model->audit_criteria_id = $payload['criteria_id'];
        $model->name = $payload['name'];
        $model->target_point = $payload['target_point'];
        $model->save();

        return $model;
    }

    /**
     * Function to delete selected sub criteria
     *
     * @param $ids
     * @return void
     */
    public function deleteSubCriteria($ids)
    {
        if (gettype($ids) != 'array') {
            $ids = [$ids];
        }
        if (count($ids) > 0) {
            for ($a = 0; $a < count($ids); $a++) {
                $m = AuditSubCriteria::find($ids[$a]);
                /**
                 * TODO: Check relation
                 */
                $m->delete();
            }
        }
    }

    /**
     * Function to store sub criteria attribute
     *
     * @param $data
     * @return mixed
     */
    public function storeSubCriteriaAttribute($data)
    {
        AuditSubCriteriaAttribute::where('audit_sub_criteria_id', $data['sub_criteria_id'])
            ->delete();
        for ($b = 0; $b < count($data['description']); $b++) {
            $model = new AuditSubCriteriaAttribute();
            $model->audit_sub_criteria_id = $data['sub_criteria_id'];
            $model->point = $data['description'][$b]['point'];
            $model->description = $data['description'][$b]['desc'];
            $model->save();
        }

        return true;
    }
}
