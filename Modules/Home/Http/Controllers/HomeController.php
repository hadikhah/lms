<?php

namespace Modules\Home\Http\Controllers;

use Modules\Course\Repositories\CourseRepo;
use Modules\Course\Repositories\LessonRepo;
use Modules\RolePermissions\Models\Permission;
use Modules\User\Models\User;
use Illuminate\Support\Str;

class HomeController
{
    public function index()
    {
        return view('Home::index');
    }

    public function singleCourse($slug, CourseRepo $courseRepo, LessonRepo $lessonRepo)
    {
        $courseId = $this->extractId($slug, 'c');
        $course   = $courseRepo->findByid($courseId);
        $lessons  = $lessonRepo->getAcceptedLessons($courseId);

        if (request()->lesson) {
            $lesson = $lessonRepo->getLesson($courseId, $this->extractId(request()->lesson, 'l'));
        } else {
            $lesson = $lessonRepo->getFirstLesson($courseId);
        }
        return view('Home::singleCourse', compact('course', 'lessons', 'lesson'));
    }

    public function extractId($slug, $key)
    {
        return Str::before(Str::after($slug, $key . '-'), '-');
    }

    public function singleTutor(User $user)
    {
        abort_if(!$user->hasPermissionTo(Permission::PERMISSION_TEACH), 404);

        return view('Home::tutor', compact('user'));
    }
}
