<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\AreaLocation
 *
 * @property string $id
 * @property string|null $section_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Section|null $section
 * @method static \Illuminate\Database\Eloquent\Builder|AreaLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AreaLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AreaLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|AreaLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AreaLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AreaLocation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AreaLocation whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AreaLocation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperAreaLocation {}
}

namespace App\Models{
/**
 * App\Models\AreaManager
 *
 * @property string $id
 * @property string|null $user_id
 * @property string|null $section_id
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Section|null $section
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|AreaManager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AreaManager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AreaManager query()
 * @method static \Illuminate\Database\Eloquent\Builder|AreaManager whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AreaManager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AreaManager whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AreaManager whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AreaManager whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AreaManager whereUserId($value)
 * @mixin \Eloquent
 */
	class IdeHelperAreaManager {}
}

namespace App\Models\COE{
/**
 * App\Models\COE\Category
 *
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\COE\Event> $events
 * @property-read int|null $events_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperCategory {}
}

namespace App\Models\COE{
/**
 * App\Models\COE\Event
 *
 * @property string $id
 * @property string|null $user_id
 * @property string|null $category_id
 * @property string|null $section_id
 * @property string $title
 * @property string $status
 * @property string|null $description
 * @property string|null $frequency
 * @property array|null $invited_emails
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property bool $notification_sent
 * @property bool $repeat
 * @property bool $must_send_email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $related_event_id
 * @property-read \App\Models\COE\Category|null $category
 * @property-read Event|null $related_event
 * @property-read \App\Models\Section|null $section
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereInvitedEmails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereMustSendEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereNotificationSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereRelatedEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereRepeat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperEvent {}
}

namespace App\Models{
/**
 * App\Models\Company
 *
 * @property string $id
 * @property string|null $user_id
 * @property string $company_name
 * @property string|null $document_code
 * @property string $address
 * @property string $email
 * @property string $phone_number
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $parent_company_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Department> $departments
 * @property-read int|null $departments_count
 * @property-read Company|null $parent
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\CompanyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDocumentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereParentCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUserId($value)
 * @mixin \Eloquent
 */
	class IdeHelperCompany {}
}

namespace App\Models{
/**
 * App\Models\Contractor
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Contractor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contractor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contractor query()
 * @mixin \Eloquent
 */
	class IdeHelperContractor {}
}

namespace App\Models{
/**
 * App\Models\Department
 *
 * @property string $id
 * @property string $company_id
 * @property string|null $head_id
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\DepartmentCode> $code
 * @property string|null $document_code
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read int|null $code_count
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User|null $head
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Section> $section
 * @property-read int|null $section_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\DepartmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereDocumentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereHeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperDepartment {}
}

namespace App\Models{
/**
 * App\Models\DepartmentCode
 *
 * @property string $id
 * @property string $department_id
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Department $department
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentCode whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentCode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperDepartmentCode {}
}

namespace App\Models\DocumentSystem{
/**
 * App\Models\DocumentSystem\Activity
 *
 * @property string $id
 * @property string $document_id
 * @property string|null $user_id
 * @property string|null $status_document
 * @property string|null $description
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentSystem\ActivityAttachment> $attachments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $attachments_count
 * @property-read \App\Models\DocumentSystem\Document $document
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereStatusDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereUserId($value)
 * @mixin \Eloquent
 */
	class IdeHelperActivity {}
}

namespace App\Models\DocumentSystem{
/**
 * App\Models\DocumentSystem\ActivityAttachment
 *
 * @property string $id
 * @property string $activity_id
 * @property string $path
 * @property float $file_size
 * @property string $file_type
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DocumentSystem\Activity $activity
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityAttachment whereActivityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityAttachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityAttachment whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityAttachment whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityAttachment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityAttachment wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityAttachment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperActivityAttachment {}
}

namespace App\Models\DocumentSystem{
/**
 * App\Models\DocumentSystem\Attachment
 *
 * @property string $id
 * @property string $document_id
 * @property string $file_name
 * @property string $file_type
 * @property float $file_size
 * @property string $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $status
 * @property-read \App\Models\DocumentSystem\Document $document
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperAttachment {}
}

namespace App\Models\DocumentSystem{
/**
 * App\Models\DocumentSystem\Category
 *
 * @property string $id
 * @property string $module_id
 * @property string $index
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentSystem\Mapping> $mappings
 * @property-read int|null $mappings_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperCategory {}
}

namespace App\Models\DocumentSystem{
/**
 * App\Models\DocumentSystem\Document
 *
 * @property string $id
 * @property string|null $department_id
 * @property string|null $mapping_id
 * @property string|null $area_manager_id
 * @property string|null $user_id
 * @property string|null $related_people
 * @property string $upload_type
 * @property int $document_level
 * @property int $status 1 for submit review, 2 for draft, 3 on rooting review, 4 for on revision, 5 for active
 * @property string|null $revision
 * @property string $title
 * @property string|null $description
 * @property string|null $sop_number
 * @property string|null $sop_add_win
 * @property string|null $sop_add_form
 * @property string|null $document_number
 * @property string|null $prefix_code
 * @property string|null $file_path
 * @property string|null $uncontrolled_file_path
 * @property string|null $doc_created
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $related_document_id
 * @property string $created_by
 * @property mixed|null $history_revision
 * @property string|null $parent_document
 * @property int $is_obsolate
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentSystem\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\AreaManager|null $areaManager
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentSystem\Attachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read \App\Models\User|null $createdby
 * @property-read \App\Models\Department|null $department
 * @property-read \App\Models\DocumentSystem\Mapping|null $mapping
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentSystem\InvitedPeople> $peoples
 * @property-read int|null $peoples_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Document exceptDraft()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereAreaManagerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDocCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDocumentLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDocumentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereHistoryRevision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereIsObsolate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereMappingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereParentDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document wherePrefixCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereRelatedDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereRelatedPeople($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereRevision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSopAddForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSopAddWin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSopNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUncontrolledFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUploadType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Document withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperDocument {}
}

namespace App\Models\DocumentSystem{
/**
 * App\Models\DocumentSystem\InvitedPeople
 *
 * @property string $id
 * @property string|null $user_id
 * @property string $document_id
 * @property int|null $user_type 1 for user that has been registered, 2 for users who are outside the system
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_notify_email
 * @property string $email
 * @property-read \App\Models\DocumentSystem\Document $document
 * @method static \Illuminate\Database\Eloquent\Builder|InvitedPeople newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvitedPeople newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvitedPeople query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvitedPeople whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvitedPeople whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvitedPeople whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvitedPeople whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvitedPeople whereIsNotifyEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvitedPeople whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvitedPeople whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvitedPeople whereUserType($value)
 * @mixin \Eloquent
 */
	class IdeHelperInvitedPeople {}
}

namespace App\Models\DocumentSystem{
/**
 * App\Models\DocumentSystem\Mapping
 *
 * @property string $id
 * @property string $category_id
 * @property string $index
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\DocumentSystem\ModuleCategory $category
 * @method static \Database\Factories\DocumentSystem\MappingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Mapping newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mapping newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mapping query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mapping whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mapping whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mapping whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mapping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mapping whereIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mapping whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mapping whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperMapping {}
}

namespace App\Models\DocumentSystem{
/**
 * App\Models\DocumentSystem\Module
 *
 * @property string $id
 * @property string $index
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $has_document_number
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentSystem\ModuleCategory> $categories
 * @property-read int|null $categories_count
 * @method static \Database\Factories\DocumentSystem\ModuleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Module newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Module newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Module query()
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereHasDocumentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperModule {}
}

namespace App\Models\DocumentSystem{
/**
 * App\Models\DocumentSystem\ModuleCategory
 *
 * @property string $id
 * @property string $module_id
 * @property string $index
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentSystem\Mapping> $mappings
 * @property-read int|null $mappings_count
 * @property-read \App\Models\DocumentSystem\Module $module
 * @method static \Database\Factories\DocumentSystem\ModuleCategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleCategory whereIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleCategory whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperModuleCategory {}
}

namespace App\Models{
/**
 * App\Models\Employee
 *
 * @property string $id
 * @property string|null $user_id
 * @property string|null $department_id
 * @property string|null $company_id
 * @property string|null $number
 * @property string $id_number
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $date_of_birth
 * @property string|null $gender
 * @property string|null $blood_type
 * @property string|null $marital_status
 * @property string|null $employee_status
 * @property \App\Models\Company|null $company
 * @property \App\Models\Department|null $department
 * @property string|null $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company|null $companys
 * @property-read \App\Models\Department|null $departments
 * @property-read \App\Models\FieldLeadership|null $field_leadership
 * @property-read \App\Models\Section $section
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\EmployeeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereBloodType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmployeeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereMaritalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUserId($value)
 * @mixin \Eloquent
 */
	class IdeHelperEmployee {}
}

namespace App\Models{
/**
 * App\Models\FieldLeadership
 *
 * @property string $id
 * @property string $date
 * @property string|null $ccow_id
 * @property string|null $company_id
 * @property string $detail_company
 * @property string|null $department_id
 * @property string|null $section_id
 * @property string|null $area_location_id
 * @property string|null $detail_location
 * @property string $pja_id
 * @property string $pjo_id
 * @property string|null $type
 * @property string|null $non_compliance_root
 * @property string|null $job
 * @property int|null $visit_time
 * @property string $status
 * @property string|null $requested
 * @property string|null $published
 * @property string $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AreaLocation|null $areaLocation
 * @property-read \App\Models\Company|null $ccow
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\Department|null $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FieldLeadershipMember> $members
 * @property-read int|null $members_count
 * @property-read \App\Models\AreaManager|null $pja
 * @property-read \App\Models\Employee|null $pjo
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FieldLeadershipPositive> $positives
 * @property-read int|null $positives_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FieldLeadershipQuestionPto> $questions
 * @property-read int|null $questions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FieldLeadershipRisk> $risks
 * @property-read int|null $risks_count
 * @property-read \App\Models\Section|null $section
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership query()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereAreaLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereCcowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereDetailCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereDetailLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereNonComplianceRoot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership wherePjaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership wherePjoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereRequested($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadership whereVisitTime($value)
 * @mixin \Eloquent
 */
	class IdeHelperFieldLeadership {}
}

namespace App\Models{
/**
 * App\Models\FieldLeadershipCategory
 *
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipCategory search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipCategory searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperFieldLeadershipCategory {}
}

namespace App\Models{
/**
 * App\Models\FieldLeadershipKtaAndTta
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipKtaAndTta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipKtaAndTta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipKtaAndTta query()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipKtaAndTta search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipKtaAndTta searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipKtaAndTta whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipKtaAndTta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipKtaAndTta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipKtaAndTta whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipKtaAndTta whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipKtaAndTta whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperFieldLeadershipKtaAndTta {}
}

namespace App\Models{
/**
 * App\Models\FieldLeadershipMember
 *
 * @property string $id
 * @property string|null $fl_id
 * @property string $type
 * @property string $employee_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $employee
 * @property-read \App\Models\FieldLeadership|null $fieldLeadership
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipMember whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipMember whereFlId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipMember whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipMember whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperFieldLeadershipMember {}
}

namespace App\Models{
/**
 * App\Models\FieldLeadershipParameter
 *
 * @property string $id
 * @property int $max_item_member
 * @property int $max_item_positive_condition
 * @property int $max_item_risk_condition
 * @property int $max_item_corrective_action
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipParameter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipParameter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipParameter query()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipParameter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipParameter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipParameter whereMaxItemCorrectiveAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipParameter whereMaxItemMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipParameter whereMaxItemPositiveCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipParameter whereMaxItemRiskCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipParameter whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperFieldLeadershipParameter {}
}

namespace App\Models{
/**
 * App\Models\FieldLeadershipPositive
 *
 * @property string $id
 * @property string|null $fl_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FieldLeadership|null $fieldLeadership
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPositive newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPositive newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPositive query()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPositive whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPositive whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPositive whereFlId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPositive whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPositive whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperFieldLeadershipPositive {}
}

namespace App\Models{
/**
 * App\Models\FieldLeadershipPotencyAndConsequnce
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPotencyAndConsequnce newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPotencyAndConsequnce newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPotencyAndConsequnce query()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPotencyAndConsequnce search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPotencyAndConsequnce searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPotencyAndConsequnce whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPotencyAndConsequnce whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPotencyAndConsequnce whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPotencyAndConsequnce whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipPotencyAndConsequnce whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperFieldLeadershipPotencyAndConsequnce {}
}

namespace App\Models{
/**
 * App\Models\FieldLeadershipQuestionPto
 *
 * @property string $id
 * @property string|null $fl_id
 * @property string $question
 * @property string $answer
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FieldLeadership|null $fieldLeadership
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipQuestionPto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipQuestionPto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipQuestionPto query()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipQuestionPto whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipQuestionPto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipQuestionPto whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipQuestionPto whereFlId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipQuestionPto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipQuestionPto whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipQuestionPto whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperFieldLeadershipQuestionPto {}
}

namespace App\Models{
/**
 * App\Models\FieldLeadershipRisk
 *
 * @property string $id
 * @property string|null $fl_id
 * @property string $risk_condition
 * @property string|null $category_id
 * @property string|null $type_id
 * @property string|null $potency_id
 * @property string $repair_action
 * @property string $due_date
 * @property string|null $type_action
 * @property string|null $supervisor
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FieldLeadershipCategory|null $category
 * @property-read \App\Models\FieldLeadership|null $fieldLeadership
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FieldLeadershipRiskFile> $files
 * @property-read int|null $files_count
 * @property-read \App\Models\FieldLeadershipPotencyAndConsequnce|null $potency
 * @property-read \App\Models\FieldLeadershipKtaAndTta|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRisk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRisk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRisk query()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRisk whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRisk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRisk whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRisk whereFlId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRisk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRisk wherePotencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRisk whereRepairAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRisk whereRiskCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRisk whereSupervisor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRisk whereTypeAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRisk whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRisk whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperFieldLeadershipRisk {}
}

namespace App\Models{
/**
 * App\Models\FieldLeadershipRiskFile
 *
 * @property string $id
 * @property string|null $fl_risk_id
 * @property string $file
 * @property string|null $type
 * @property string|null $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FieldLeadershipRisk|null $fieldLeadershipRisk
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRiskFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRiskFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRiskFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRiskFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRiskFile whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRiskFile whereFlRiskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRiskFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRiskFile whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRiskFile whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipRiskFile whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperFieldLeadershipRiskFile {}
}

namespace App\Models{
/**
 * App\Models\FieldLeadershipType
 *
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipType query()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldLeadershipType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperFieldLeadershipType {}
}

namespace App\Models\IbprBowty{
/**
 * App\Models\IbprBowty\Bowtie
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IbprBowty\BowtieActivity> $activity
 * @property-read int|null $activity_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IbprBowty\BowtieCca> $cca
 * @property-read int|null $cca_count
 * @property-read \App\Models\Company $ccow
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\Contractor|null $contractor
 * @property-read \App\Models\Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IbprBowty\BowtieEvent> $events
 * @property-read int|null $events_count
 * @property-read \App\Models\Employee|null $ohs
 * @property-read \App\Models\Employee|null $pja
 * @property-read \App\Models\AreaManager|null $pjs
 * @property-read \App\Models\Section $section
 * @property-read \App\Models\Contractor|null $sub_contractor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IbprBowty\BowtieTeam> $teams
 * @property-read int|null $teams_count
 * @method static \Illuminate\Database\Eloquent\Builder|Bowtie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bowtie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bowtie query()
 * @mixin \Eloquent
 */
	class IdeHelperBowtie {}
}

namespace App\Models\IbprBowty{
/**
 * App\Models\IbprBowty\BowtieActivity
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieActivity query()
 * @mixin \Eloquent
 */
	class IdeHelperBowtieActivity {}
}

namespace App\Models\IbprBowty{
/**
 * App\Models\IbprBowty\BowtieCca
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieCca newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieCca newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieCca query()
 * @mixin \Eloquent
 */
	class IdeHelperBowtieCca {}
}

namespace App\Models\IbprBowty{
/**
 * App\Models\IbprBowty\BowtieEvent
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IbprBowty\BowtieEventCmf> $cmf
 * @property-read int|null $cmf_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IbprBowty\BowtieEventCmfRepair> $cmf_repair
 * @property-read int|null $cmf_repair_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IbprBowty\BowtieEventImm> $imm
 * @property-read int|null $imm_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IbprBowty\BowtieEventImmRepair> $imm_repair
 * @property-read int|null $imm_repair_count
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieEvent query()
 * @mixin \Eloquent
 */
	class IdeHelperBowtieEvent {}
}

namespace App\Models\IbprBowty{
/**
 * App\Models\IbprBowty\BowtieEventCmf
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieEventCmf newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieEventCmf newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieEventCmf query()
 * @mixin \Eloquent
 */
	class IdeHelperBowtieEventCmf {}
}

namespace App\Models\IbprBowty{
/**
 * App\Models\IbprBowty\BowtieEventCmfRepair
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieEventCmfRepair newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieEventCmfRepair newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieEventCmfRepair query()
 * @mixin \Eloquent
 */
	class IdeHelperBowtieEventCmfRepair {}
}

namespace App\Models\IbprBowty{
/**
 * App\Models\IbprBowty\BowtieEventImm
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieEventImm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieEventImm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieEventImm query()
 * @mixin \Eloquent
 */
	class IdeHelperBowtieEventImm {}
}

namespace App\Models\IbprBowty{
/**
 * App\Models\IbprBowty\BowtieEventImmRepair
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieEventImmRepair newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieEventImmRepair newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieEventImmRepair query()
 * @mixin \Eloquent
 */
	class IdeHelperBowtieEventImmRepair {}
}

namespace App\Models\IbprBowty{
/**
 * App\Models\IbprBowty\BowtieLossCalculation
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IbprBowty\BowtieLossCalculationDetail> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\IbprBowty\BowtieEvent|null $event
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieLossCalculation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieLossCalculation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieLossCalculation query()
 * @mixin \Eloquent
 */
	class IdeHelperBowtieLossCalculation {}
}

namespace App\Models\IbprBowty{
/**
 * App\Models\IbprBowty\BowtieLossCalculationDetail
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieLossCalculationDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieLossCalculationDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieLossCalculationDetail query()
 * @mixin \Eloquent
 */
	class IdeHelperBowtieLossCalculationDetail {}
}

namespace App\Models\IbprBowty{
/**
 * App\Models\IbprBowty\BowtiePerformanceStandard
 *
 * @property-read \App\Models\Department $department
 * @property-read \App\Models\Section $section
 * @method static \Illuminate\Database\Eloquent\Builder|BowtiePerformanceStandard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtiePerformanceStandard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtiePerformanceStandard query()
 * @mixin \Eloquent
 */
	class IdeHelperBowtiePerformanceStandard {}
}

namespace App\Models\IbprBowty{
/**
 * App\Models\IbprBowty\BowtieTeam
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieTeam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieTeam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowtieTeam query()
 * @mixin \Eloquent
 */
	class IdeHelperBowtieTeam {}
}

namespace App\Models\IbprBowty{
/**
 * App\Models\IbprBowty\Ibpr
 *
 * @property-read \App\Models\Company $ccow
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\Contractor|null $contractor
 * @property-read \App\Models\Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IbprBowty\IbprForm> $forms
 * @property-read int|null $forms_count
 * @property-read \App\Models\Employee|null $pja
 * @property-read \App\Models\Employee|null $pjo
 * @property-read \App\Models\AreaManager|null $pjs
 * @property-read \App\Models\Section $section
 * @property-read \App\Models\Contractor|null $sub_contractor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IbprBowty\IbprTeam> $teams
 * @property-read int|null $teams_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ibpr newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ibpr newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ibpr query()
 * @mixin \Eloquent
 */
	class IdeHelperIbpr {}
}

namespace App\Models\IbprBowty{
/**
 * App\Models\IbprBowty\IbprForm
 *
 * @method static \Illuminate\Database\Eloquent\Builder|IbprForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IbprForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IbprForm query()
 * @mixin \Eloquent
 */
	class IdeHelperIbprForm {}
}

namespace App\Models\IbprBowty{
/**
 * App\Models\IbprBowty\IbprMasterBahaya
 *
 * @method static \Illuminate\Database\Eloquent\Builder|IbprMasterBahaya newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IbprMasterBahaya newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IbprMasterBahaya query()
 * @mixin \Eloquent
 */
	class IdeHelperIbprMasterBahaya {}
}

namespace App\Models\IbprBowty{
/**
 * App\Models\IbprBowty\IbprMasterHirarki
 *
 * @method static \Illuminate\Database\Eloquent\Builder|IbprMasterHirarki newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IbprMasterHirarki newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IbprMasterHirarki query()
 * @mixin \Eloquent
 */
	class IdeHelperIbprMasterHirarki {}
}

namespace App\Models\IbprBowty{
/**
 * App\Models\IbprBowty\IbprTeam
 *
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|IbprTeam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IbprTeam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IbprTeam query()
 * @mixin \Eloquent
 */
	class IdeHelperIbprTeam {}
}

namespace App\Models\KPP{
/**
 * App\Models\KPP\AgencyAuthority
 *
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|AgencyAuthority newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AgencyAuthority newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AgencyAuthority onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AgencyAuthority query()
 * @method static \Illuminate\Database\Eloquent\Builder|AgencyAuthority whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AgencyAuthority whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AgencyAuthority whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AgencyAuthority whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AgencyAuthority whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AgencyAuthority withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AgencyAuthority withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperAgencyAuthority {}
}

namespace App\Models\KPP{
/**
 * App\Models\KPP\Obedience
 *
 * @property string $id
 * @property string|null $company_id
 * @property string|null $rule_id
 * @property string|null $comment
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Obedience newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Obedience newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Obedience query()
 * @method static \Illuminate\Database\Eloquent\Builder|Obedience whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Obedience whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Obedience whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Obedience whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Obedience whereRuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Obedience whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Obedience whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperObedience {}
}

namespace App\Models\KPP{
/**
 * App\Models\KPP\Rule
 *
 * @property string $id
 * @property string $number
 * @property string $title
 * @property string|null $rule_type_id
 * @property string|null $agency_authority_id
 * @property string|null $description
 * @property string|null $created_by
 * @property string|null $approved_date
 * @property string|null $effective_date
 * @property string|null $expired_date
 * @property string $status
 * @property int $is_draft
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\KPP\AgencyAuthority|null $agencyAuthority
 * @property-read \App\Models\KPP\RuleStatus|null $ruleStatus
 * @property-read \App\Models\KPP\RuleType|null $ruleType
 * @method static \Illuminate\Database\Eloquent\Builder|Rule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rule query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereAgencyAuthorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereApprovedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereEffectiveDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereExpiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereIsDraft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereRuleTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperRule {}
}

namespace App\Models\KPP{
/**
 * App\Models\KPP\RuleExtractionStatus
 *
 * @method static \Illuminate\Database\Eloquent\Builder|RuleExtractionStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleExtractionStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleExtractionStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleExtractionStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleExtractionStatus withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleExtractionStatus withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperRuleExtractionStatus {}
}

namespace App\Models\KPP{
/**
 * App\Models\KPP\RuleStatus
 *
 * @method static \Illuminate\Database\Eloquent\Builder|RuleStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleStatus withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleStatus withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperRuleStatus {}
}

namespace App\Models\KPP{
/**
 * App\Models\KPP\RuleType
 *
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|RuleType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleType query()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RuleType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RuleType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RuleType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RuleType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RuleType withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleType withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperRuleType {}
}

namespace App\Models\MainDashboard{
/**
 * App\Models\MainDashboard\Banner
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner query()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperBanner {}
}

namespace App\Models\MainDashboard{
/**
 * App\Models\MainDashboard\General
 *
 * @method static \Illuminate\Database\Eloquent\Builder|General newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|General newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|General onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|General query()
 * @method static \Illuminate\Database\Eloquent\Builder|General withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|General withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperGeneral {}
}

namespace App\Models\MainDashboard{
/**
 * App\Models\MainDashboard\IncidentNotification
 *
 * @method static \Illuminate\Database\Eloquent\Builder|IncidentNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncidentNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncidentNotification onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|IncidentNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|IncidentNotification withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|IncidentNotification withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperIncidentNotification {}
}

namespace App\Models\MainDashboard{
/**
 * App\Models\MainDashboard\K3lhActivities
 *
 * @method static \Illuminate\Database\Eloquent\Builder|K3lhActivities newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|K3lhActivities newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|K3lhActivities onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|K3lhActivities query()
 * @method static \Illuminate\Database\Eloquent\Builder|K3lhActivities withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|K3lhActivities withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperK3lhActivities {}
}

namespace App\Models\MainDashboard{
/**
 * App\Models\MainDashboard\K3lhAward
 *
 * @method static \Illuminate\Database\Eloquent\Builder|K3lhAward newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|K3lhAward newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|K3lhAward onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|K3lhAward query()
 * @method static \Illuminate\Database\Eloquent\Builder|K3lhAward withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|K3lhAward withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperK3lhAward {}
}

namespace App\Models\MainDashboard{
/**
 * App\Models\MainDashboard\NewsAndUpdate
 *
 * @method static \Illuminate\Database\Eloquent\Builder|NewsAndUpdate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsAndUpdate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsAndUpdate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsAndUpdate query()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsAndUpdate withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsAndUpdate withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperNewsAndUpdate {}
}

namespace App\Models\MainDashboard{
/**
 * App\Models\MainDashboard\Performance
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Performance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Performance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Performance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Performance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Performance withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Performance withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperPerformance {}
}

namespace App\Models\MainDashboard{
/**
 * App\Models\MainDashboard\SafetyPerformance
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SafetyPerformance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SafetyPerformance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SafetyPerformance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SafetyPerformance query()
 * @method static \Illuminate\Database\Eloquent\Builder|SafetyPerformance withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SafetyPerformance withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperSafetyPerformance {}
}

namespace App\Models\MainDashboard{
/**
 * App\Models\MainDashboard\Slideshow
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Slideshow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slideshow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slideshow onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Slideshow query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slideshow withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Slideshow withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperSlideshow {}
}

namespace App\Models\MainDashboard{
/**
 * App\Models\MainDashboard\StrategicProject
 *
 * @method static \Illuminate\Database\Eloquent\Builder|StrategicProject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StrategicProject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StrategicProject onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StrategicProject query()
 * @method static \Illuminate\Database\Eloquent\Builder|StrategicProject withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StrategicProject withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperStrategicProject {}
}

namespace App\Models\Mcu{
/**
 * App\Models\Mcu\Doctor
 *
 * @property int $id
 * @property string $name
 * @property string $specialist
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereSpecialist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperDoctor {}
}

namespace App\Models\Mcu{
/**
 * App\Models\Mcu\FormulaBloodPressure
 *
 * @property int $id
 * @property string $status
 * @property int|null $normal_a
 * @property int|null $normal_b
 * @property int|null $pre_a_1
 * @property int|null $pre_b_1
 * @property int|null $pre_a_2
 * @property int|null $pre_b_2
 * @property int|null $ht1_a_1
 * @property int|null $ht1_b_1
 * @property int|null $ht1_a_2
 * @property int|null $ht1_b_2
 * @property int|null $ht2_a
 * @property int|null $ht2_b
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure query()
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure whereHt1A1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure whereHt1A2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure whereHt1B1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure whereHt1B2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure whereHt2A($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure whereHt2B($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure whereNormalA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure whereNormalB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure wherePreA1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure wherePreA2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure wherePreB1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure wherePreB2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaBloodPressure whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperFormulaBloodPressure {}
}

namespace App\Models\Mcu{
/**
 * App\Models\Mcu\FormulaDislipidemia
 *
 * @property int $id
 * @property string $status
 * @property int|null $col_total
 * @property int|null $tga
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaDislipidemia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaDislipidemia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaDislipidemia query()
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaDislipidemia whereColTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaDislipidemia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaDislipidemia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaDislipidemia whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaDislipidemia whereTga($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaDislipidemia whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperFormulaDislipidemia {}
}

namespace App\Models\Mcu{
/**
 * App\Models\Mcu\MedicalHistory
 *
 * @property string $id
 * @property string $employee_id
 * @property string|null $staff_id
 * @property string|null $doctor_id
 * @property int|null $doctor_spesialist_id
 * @property int|null $formula_blood_pressure_id
 * @property int|null $formula_dislipidemia_id
 * @property int|null $provider_id
 * @property string|null $medical_ex_type
 * @property string|null $medical_type
 * @property string|null $mcu_date
 * @property string|null $mcu_exp_date
 * @property string|null $mcu_review_date
 * @property string|null $complaint
 * @property string|null $previous_disease_history
 * @property string|null $family_disease_history
 * @property string|null $alergy
 * @property string|null $smoking
 * @property int|null $smoking_per_day
 * @property string|null $sports
 * @property string|null $sports_per_week
 * @property string|null $sports_type
 * @property string|null $alcohol
 * @property string|null $menstrual_menarche
 * @property string|null $menstrual_cycle
 * @property string|null $menstrual_pain
 * @property int|null $menstrual_period
 * @property int|null $pregnant_period
 * @property int|null $pregnant_spontan
 * @property int|null $pregnant_surgery
 * @property int|null $pregnant_abortion
 * @property string|null $contraception
 * @property string|null $contraception_type
 * @property string|null $previous_job
 * @property string|null $current_job
 * @property string|null $current_job_details
 * @property string|null $vaccination_hep_a1
 * @property string|null $vaccination_hep_a2
 * @property string|null $vaccination_hep_a3
 * @property string|null $vaccination_typhoid_1
 * @property string|null $vaccination_typhoid_3
 * @property string|null $vaccination_albendandazole
 * @property int|null $height
 * @property int|null $weight
 * @property int|null $bmi
 * @property string|null $nutritional_status
 * @property int|null $bmi_lower
 * @property int|null $bmi_upper
 * @property int|null $systolic_blood_pressure
 * @property int|null $diastolic_blood_pressure
 * @property int|null $arteries
 * @property int|null $rr
 * @property int|null $body_temperature
 * @property string|null $blood_pressure_status
 * @property string|null $heent
 * @property string|null $orodental_caries
 * @property string|null $orodental_gangren_radix
 * @property string|null $cardiovascular_system
 * @property string|null $respiratorus_system
 * @property string|null $digestivus_system
 * @property string|null $genitounrinarius_system
 * @property string|null $neuromuscular_system
 * @property string|null $fitness_test
 * @property string|null $visus_non_correction_od
 * @property string|null $visus_non_correction_os
 * @property string|null $visus_non_correction_ods
 * @property string|null $visus_correction_od
 * @property string|null $visus_correction_os
 * @property string|null $visus_correction_ods
 * @property string|null $visus_impression
 * @property string|null $visus_reading_test
 * @property string|null $visus_color_blind
 * @property string|null $visus_field_of_view
 * @property string|null $visus_notes
 * @property int|null $audiometry_right_air_conduction_500
 * @property int|null $audiometry_right_air_conduction_1000
 * @property int|null $audiometry_right_air_conduction_2000
 * @property int|null $audiometry_right_air_conduction_3000
 * @property int|null $audiometry_right_air_conduction_4000
 * @property int|null $audiometry_right_air_conduction_6000
 * @property int|null $audiometry_right_air_conduction_8000
 * @property int|null $audiometry_right_air_conduction_htl
 * @property int|null $audiometry_right_bone_conduction_500
 * @property int|null $audiometry_right_bone_conduction_1000
 * @property int|null $audiometry_right_bone_conduction_2000
 * @property int|null $audiometry_right_bone_conduction_3000
 * @property int|null $audiometry_right_bone_conduction_4000
 * @property int|null $audiometry_right_bone_conduction_6000
 * @property int|null $audiometry_right_bone_conduction_8000
 * @property int|null $audiometry_right_bone_conduction_htl
 * @property int|null $audiometry_left_air_conduction_500
 * @property int|null $audiometry_left_air_conduction_1000
 * @property int|null $audiometry_left_air_conduction_2000
 * @property int|null $audiometry_left_air_conduction_3000
 * @property int|null $audiometry_left_air_conduction_4000
 * @property int|null $audiometry_left_air_conduction_6000
 * @property int|null $audiometry_left_air_conduction_8000
 * @property int|null $audiometry_left_air_conduction_htl
 * @property int|null $audiometry_left_bone_conduction_500
 * @property int|null $audiometry_left_bone_conduction_1000
 * @property int|null $audiometry_left_bone_conduction_2000
 * @property int|null $audiometry_left_bone_conduction_3000
 * @property int|null $audiometry_left_bone_conduction_4000
 * @property int|null $audiometry_left_bone_conduction_6000
 * @property int|null $audiometry_left_bone_conduction_8000
 * @property int|null $audiometry_left_bone_conduction_htl
 * @property string|null $audiometry_conclusion
 * @property string|null $audiometry_impression
 * @property string|null $spirometry_fvc
 * @property string|null $spirometry_fev1
 * @property string|null $spirometry_impression
 * @property string|null $xray_thorax
 * @property string|null $ekg
 * @property string|null $treadmill
 * @property string|null $echocardiography
 * @property string|null $additional_diagnosis
 * @property string|null $blood_hb
 * @property string|null $blood_ht
 * @property int|null $blood_leukosit
 * @property int|null $blood_thrombosit
 * @property string|null $blood_eritrosit
 * @property int|null $blood_led
 * @property string|null $blood_type
 * @property string|null $blood_rhesus
 * @property int|null $blood_sgot
 * @property int|null $blood_sgpt
 * @property int|null $blood_gamma_gt
 * @property int|null $blood_cholesterol_total
 * @property int|null $blood_hdl
 * @property int|null $blood_ldl
 * @property int|null $blood_tga
 * @property string|null $blood_billirubin_total
 * @property int|null $blood_billirubin_direk
 * @property int|null $blood_billirubin_indirek
 * @property string|null $blood_dislipidemia
 * @property int|null $blood_gdpt
 * @property int|null $blood_g2pp
 * @property string|null $blood_hyperglycemic
 * @property int|null $blood_hba1c
 * @property string|null $blood_dm_status
 * @property string|null $jakarta_cardiovascular_score
 * @property string|null $jakarta_cardiovascular_risk_level
 * @property string|null $framingham_score
 * @property string|null $frammingham_risk_level
 * @property int|null $laboratory_ureum
 * @property int|null $laboratory_bun
 * @property int|null $laboratory_creatinin
 * @property int|null $laboratory_uric_acid
 * @property int|null $laboratory_uric_egfr
 * @property string|null $laboratory_hbsag
 * @property string|null $laboratory_anti_hbs
 * @property string|null $laboratory_anti_havlgm
 * @property string|null $laboratory_widal
 * @property string|null $laboratory_malary
 * @property string|null $laboratory_urinalysis_color
 * @property string|null $laboratory_urinalysis_clarity
 * @property string|null $laboratory_urinalysis_ph
 * @property string|null $laboratory_urinalysis_density
 * @property string|null $laboratory_urinalysis_protein
 * @property string|null $laboratory_urinalysis_glucose
 * @property string|null $laboratory_urinalysis_billirubin
 * @property string|null $laboratory_urinalysis_urobillin
 * @property string|null $laboratory_urinalysis_keton
 * @property string|null $laboratory_urinalysis_blood
 * @property string|null $laboratory_urinalysis_lekositesterase
 * @property string|null $laboratory_urinalysis_nitrit
 * @property int|null $laboratory_urinalysis_leukocyte_sediment
 * @property int|null $laboratory_urinalysis_erythrocyte
 * @property int|null $laboratory_urinalysis_epitel
 * @property string|null $laboratory_urinalysis_cylinder
 * @property string|null $laboratory_urinalysis_crystal
 * @property string|null $laboratory_urinalysis_bacteria
 * @property string|null $laboratory_urinalysis_etc
 * @property string|null $laboratory_urinalysis_amp
 * @property string|null $laboratory_urinalysis_met
 * @property string|null $laboratory_urinalysis_bdz
 * @property string|null $laboratory_urinalysis_coc
 * @property string|null $laboratory_urinalysis_opi
 * @property string|null $laboratory_urinalysis_thc
 * @property string|null $laboratory_urinalysis_feces_analysis
 * @property string|null $laboratory_urinalysis_feces_culture
 * @property string|null $additional_exam
 * @property string|null $findings
 * @property string|null $amc_matrix_compliance
 * @property string|null $doctor_status_review
 * @property string|null $doctor_suggestion
 * @property string|null $doctor_certificate_number
 * @property string|null $doctor_expiration
 * @property string|null $doctor_remark
 * @property string|null $doctor_referral_diagnosis
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Employee|null $doctor
 * @property-read \App\Models\Mcu\Doctor|null $doctor_spesialist
 * @property-read \App\Models\Employee $employee
 * @property-read \App\Models\Mcu\FormulaBloodPressure|null $formula_blood_pressure_data
 * @property-read \App\Models\Mcu\FormulaDislipidemia|null $formula_dislipidemia_data
 * @property-read \App\Models\Mcu\Provider|null $provider
 * @property-read \App\Models\Employee|null $staff
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAdditionalDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAdditionalExam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAlcohol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAlergy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAmcMatrixCompliance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereArteries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryConclusion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryImpression($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryLeftAirConduction1000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryLeftAirConduction2000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryLeftAirConduction3000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryLeftAirConduction4000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryLeftAirConduction500($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryLeftAirConduction6000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryLeftAirConduction8000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryLeftAirConductionHtl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryLeftBoneConduction1000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryLeftBoneConduction2000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryLeftBoneConduction3000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryLeftBoneConduction4000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryLeftBoneConduction500($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryLeftBoneConduction6000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryLeftBoneConduction8000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryLeftBoneConductionHtl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryRightAirConduction1000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryRightAirConduction2000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryRightAirConduction3000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryRightAirConduction4000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryRightAirConduction500($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryRightAirConduction6000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryRightAirConduction8000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryRightAirConductionHtl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryRightBoneConduction1000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryRightBoneConduction2000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryRightBoneConduction3000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryRightBoneConduction4000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryRightBoneConduction500($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryRightBoneConduction6000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryRightBoneConduction8000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereAudiometryRightBoneConductionHtl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodBillirubinDirek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodBillirubinIndirek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodBillirubinTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodCholesterolTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodDislipidemia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodDmStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodEritrosit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodG2pp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodGammaGt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodGdpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodHb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodHba1c($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodHdl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodHt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodHyperglycemic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodLdl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodLed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodLeukosit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodPressureStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodRhesus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodSgot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodSgpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodTga($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodThrombosit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBloodType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBmi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBmiLower($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBmiUpper($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereBodyTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereCardiovascularSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereComplaint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereContraception($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereContraceptionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereCurrentJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereCurrentJobDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereDiastolicBloodPressure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereDigestivusSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereDoctorCertificateNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereDoctorExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereDoctorReferralDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereDoctorRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereDoctorSpesialistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereDoctorStatusReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereDoctorSuggestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereEchocardiography($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereEkg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereFamilyDiseaseHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereFindings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereFitnessTest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereFormulaBloodPressureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereFormulaDislipidemiaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereFraminghamScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereFramminghamRiskLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereGenitounrinariusSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereHeent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereJakartaCardiovascularRiskLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereJakartaCardiovascularScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryAntiHavlgm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryAntiHbs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryBun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryCreatinin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryHbsag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryMalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUreum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUricAcid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUricEgfr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisAmp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisBacteria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisBdz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisBillirubin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisBlood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisClarity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisCoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisCrystal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisCylinder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisDensity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisEpitel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisErythrocyte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisEtc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisFecesAnalysis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisFecesCulture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisGlucose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisKeton($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisLekositesterase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisLeukocyteSediment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisMet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisNitrit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisOpi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisPh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisProtein($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisThc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryUrinalysisUrobillin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereLaboratoryWidal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereMcuDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereMcuExpDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereMcuReviewDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereMedicalExType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereMedicalType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereMenstrualCycle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereMenstrualMenarche($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereMenstrualPain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereMenstrualPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereNeuromuscularSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereNutritionalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereOrodentalCaries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereOrodentalGangrenRadix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory wherePregnantAbortion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory wherePregnantPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory wherePregnantSpontan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory wherePregnantSurgery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory wherePreviousDiseaseHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory wherePreviousJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereRespiratorusSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereRr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereSmoking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereSmokingPerDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereSpirometryFev1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereSpirometryFvc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereSpirometryImpression($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereSports($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereSportsPerWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereSportsType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereSystolicBloodPressure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereTreadmill($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereVaccinationAlbendandazole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereVaccinationHepA1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereVaccinationHepA2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereVaccinationHepA3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereVaccinationTyphoid1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereVaccinationTyphoid3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereVisusColorBlind($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereVisusCorrectionOd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereVisusCorrectionOds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereVisusCorrectionOs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereVisusFieldOfView($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereVisusImpression($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereVisusNonCorrectionOd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereVisusNonCorrectionOds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereVisusNonCorrectionOs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereVisusNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereVisusReadingTest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalHistory whereXrayThorax($value)
 * @mixin \Eloquent
 */
	class IdeHelperMedicalHistory {}
}

namespace App\Models\Mcu{
/**
 * App\Models\Mcu\Provider
 *
 * @property int $id
 * @property string $name
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Provider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Provider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Provider query()
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperProvider {}
}

namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperPermission {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperRole {}
}

namespace App\Models{
/**
 * App\Models\Section
 *
 * @property string $id
 * @property string $department_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AreaLocation> $area_locations
 * @property-read int|null $area_locations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AreaManager> $area_managers
 * @property-read int|null $area_managers_count
 * @property-read \App\Models\Department $department
 * @method static \Database\Factories\SectionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Section newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Section newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Section query()
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperSection {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $department_id
 * @property-read \App\Models\AreaManager|null $areaManager
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\Department|null $department
 * @property-read \App\Models\Employee|null $employee
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperUser {}
}

