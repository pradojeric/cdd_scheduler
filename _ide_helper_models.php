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
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models\Configurations{
/**
 * App\Models\Configurations\Building
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Building newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Building newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Building query()
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereUpdatedAt($value)
 */
	class Building extends \Eloquent {}
}

namespace App\Models\Configurations{
/**
 * App\Models\Configurations\Course
 *
 * @property int $id
 * @property int $department_id
 * @property string $name
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Configurations\Curriculum[] $curricula
 * @property-read int|null $curricula_count
 * @property-read \App\Models\Configurations\Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Section[] $sections
 * @property-read int|null $sections_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subject[] $subjects
 * @property-read int|null $subjects_count
 * @method static \Illuminate\Database\Eloquent\Builder|Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereUpdatedAt($value)
 */
	class Course extends \Eloquent {}
}

namespace App\Models\Configurations{
/**
 * App\Models\Configurations\Curriculum
 *
 * @property int $id
 * @property int $course_id
 * @property string $effective_sy
 * @property string $description
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Configurations\Course $course
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Configurations\CurriculumSubject[] $subjects
 * @property-read int|null $subjects_count
 * @method static \Illuminate\Database\Eloquent\Builder|Curriculum newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Curriculum newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Curriculum query()
 * @method static \Illuminate\Database\Eloquent\Builder|Curriculum whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Curriculum whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Curriculum whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Curriculum whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Curriculum whereEffectiveSy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Curriculum whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Curriculum whereUpdatedAt($value)
 */
	class Curriculum extends \Eloquent {}
}

namespace App\Models\Configurations{
/**
 * App\Models\Configurations\CurriculumSubject
 *
 * @property int $id
 * @property string $uuid
 * @property int $curriculum_id
 * @property int $year
 * @property int $term
 * @property string $code
 * @property string $title
 * @property int $lec_hours
 * @property int $lab_hours
 * @property int $lec_units
 * @property int $lab_units
 * @property string|null $prereq
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Configurations\Curriculum $curriuclum
 * @property-read mixed $total_units
 * @method static \Illuminate\Database\Eloquent\Builder|CurriculumSubject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CurriculumSubject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CurriculumSubject query()
 * @method static \Illuminate\Database\Eloquent\Builder|CurriculumSubject whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurriculumSubject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurriculumSubject whereCurriculumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurriculumSubject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurriculumSubject whereLabHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurriculumSubject whereLabUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurriculumSubject whereLecHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurriculumSubject whereLecUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurriculumSubject wherePrereq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurriculumSubject whereTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurriculumSubject whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurriculumSubject whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurriculumSubject whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurriculumSubject whereYear($value)
 */
	class CurriculumSubject extends \Eloquent {}
}

namespace App\Models\Configurations{
/**
 * App\Models\Configurations\Department
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Configurations\Course[] $courses
 * @property-read int|null $courses_count
 * @method static \Illuminate\Database\Eloquent\Builder|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereUpdatedAt($value)
 */
	class Department extends \Eloquent {}
}

namespace App\Models\Configurations{
/**
 * App\Models\Configurations\RoomType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RoomType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomType query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomType whereUpdatedAt($value)
 */
	class RoomType extends \Eloquent {}
}

namespace App\Models\Configurations{
/**
 * App\Models\Configurations\Settings
 *
 * @property int $id
 * @property string $school_year
 * @property int $term
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $current_school_year
 * @method static \Illuminate\Database\Eloquent\Builder|Settings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings query()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereSchoolYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereUpdatedAt($value)
 */
	class Settings extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Faculty
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $code
 * @property int $department_id
 * @property float $rate
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property-read \App\Models\Configurations\Department $department
 * @property-read mixed $active_status
 * @property mixed $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FacultySubject[] $preferredSubjects
 * @property-read int|null $preferred_subjects_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Schedule[] $schedules
 * @property-read int|null $schedules_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty active()
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty query()
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty whereUserId($value)
 */
	class Faculty extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FacultySubject
 *
 * @property int $id
 * @property int $faculty_id
 * @property string $subject_code
 * @property string $subject_title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FacultySubject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FacultySubject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FacultySubject query()
 * @method static \Illuminate\Database\Eloquent\Builder|FacultySubject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacultySubject whereFacultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacultySubject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacultySubject whereSubjectCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacultySubject whereSubjectTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacultySubject whereUpdatedAt($value)
 */
	class FacultySubject extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Room
 *
 * @property int $id
 * @property string $name
 * @property int $capacity
 * @property int $building_id
 * @property int|null $room_type_id
 * @property int $no_of_laboratories
 * @property int $status
 * @property int $is_room
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Configurations\Building $building
 * @property-read \App\Models\Configurations\RoomType|null $roomType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TimeSchedule[] $timeSchedules
 * @property-read int|null $time_schedules_count
 * @method static \Illuminate\Database\Eloquent\Builder|Room laboratory()
 * @method static \Illuminate\Database\Eloquent\Builder|Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room query()
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereBuildingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereIsRoom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereNoOfLaboratories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereRoomTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereUpdatedAt($value)
 */
	class Room extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Schedule
 *
 * @property int $id
 * @property string $school_year
 * @property int $term
 * @property int $section_id
 * @property int $subject_id
 * @property int|null $faculty_id
 * @property int $lab
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Faculty|null $faculty
 * @property-read \App\Models\Room $room
 * @property-read \App\Models\Section $section
 * @property-read \App\Models\Subject $subject
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TimeSchedule[] $timeSchedules
 * @property-read int|null $time_schedules_count
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereFacultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereLab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereSchoolYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereUpdatedAt($value)
 */
	class Schedule extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Section
 *
 * @property int $id
 * @property int $course_id
 * @property string $school_year
 * @property int $year
 * @property int $term
 * @property int $block
 * @property int $graduating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Configurations\Course $course
 * @property-read \App\Models\Configurations\Department $department
 * @property-read mixed $section_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Schedule[] $schedules
 * @property-read int|null $schedules_count
 * @method static \Illuminate\Database\Eloquent\Builder|Section newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Section newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Section query()
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereBlock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereGraduating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereSchoolYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereYear($value)
 */
	class Section extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Subject
 *
 * @property int $id
 * @property string $uuid
 * @property int $course_id
 * @property int $curriculum_id
 * @property int $year
 * @property int $term
 * @property string $code
 * @property string $title
 * @property int $lec_hours
 * @property int $lab_hours
 * @property int $lec_units
 * @property int $lab_units
 * @property string|null $prereq
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $active
 * @property-read \App\Models\Configurations\Course $course
 * @property-read \App\Models\Configurations\Curriculum $curriculum
 * @property-read mixed $total_units
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Schedule[] $schedules
 * @property-read int|null $schedules_count
 * @method static \Illuminate\Database\Eloquent\Builder|Subject active()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject termSubjects($term)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereCurriculumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereLabHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereLabUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereLecHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereLecUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject wherePrereq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereYear($value)
 */
	class Subject extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TimeSchedule
 *
 * @property int $id
 * @property int $schedule_id
 * @property int|null $room_id
 * @property string $start
 * @property string $end
 * @property int $lab
 * @property int $monday
 * @property int $tuesday
 * @property int $wednesday
 * @property int $thursday
 * @property int $friday
 * @property int $saturday
 * @property int $sunday
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $time
 * @property-read \App\Models\Room|null $room
 * @property-read \App\Models\Schedule $schedule
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereFriday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereLab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereMonday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereSaturday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereSunday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereThursday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereTuesday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereWednesday($value)
 */
	class TimeSchedule extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Faculty|null $faculty
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

