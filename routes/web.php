<?php

use Illuminate\Support\Facades\Route;

Route::get('login-page',[App\Http\Controllers\Controller::class,'loginPage'])->middleware('guest')->name('login.page');
Route::post('login',[App\Http\Controllers\Controller::class,'login'])->name('login');
Route::get('pay/{student_id}/{month}/{amount}/{currency}',[\App\Http\Controllers\Admin\Billings\BillingsController::class,'pay'])->name('pay');
Route::get('success/{month}',[\App\Http\Controllers\Admin\Billings\BillingsController::class,'success'])->name('success');

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout',[\App\Http\Controllers\Controller::class,'logout'])->name('logout');
    Route::get('/', [\App\Http\Controllers\Admin\Dashboard\DashboardController::class,'index'])->name('admin.dashboard');
    Route::resource('students', \App\Http\Controllers\Admin\Students\StudentsController::class);
    Route::put('student/update/{id}', [\App\Http\Controllers\Admin\Students\StudentsController::class,'update'])->name('student.update');
    Route::get('students/delete/{id}', [\App\Http\Controllers\Admin\Students\StudentsController::class,'delete'])->name('students.delete');

//teachers
    Route::get('teachers', [\App\Http\Controllers\Admin\Teachers\TeachersController::class,'index'])->name('teachers.index');
    Route::get('teachers/create', [\App\Http\Controllers\Admin\Teachers\TeachersController::class,'create'])->name('teachers.create');
    Route::post('teachers/store', [\App\Http\Controllers\Admin\Teachers\TeachersController::class,'store'])->name('teachers.store');
    Route::get('teachers/edit/{id}', [\App\Http\Controllers\Admin\Teachers\TeachersController::class,'edit'])->name('teachers.edit');
    Route::post('teachers/update/{id}', [\App\Http\Controllers\Admin\Teachers\TeachersController::class,'update'])->name('teachers.update');
    Route::get('teachers/delete/{id}', [\App\Http\Controllers\Admin\Teachers\TeachersController::class,'delete'])->name('teachers.delete');
    Route::get('teacher-remove-student/{teacher_id}/{student_id}', [\App\Http\Controllers\Admin\Teachers\TeachersController::class,'removeStudent'])->name('teacher.remove.student');
    Route::get('teacher-add-student/{teacher_id}', [\App\Http\Controllers\Admin\Teachers\TeachersController::class,'addStudent'])->name('teacher.add.student');


    //courses
    Route::get('courses', [\App\Http\Controllers\Teacher\Courses\CoursesController::class,'index'])->name('courses.index');
    Route::get('courses/create', [\App\Http\Controllers\Teacher\Courses\CoursesController::class,'create'])->name('courses.create');
    Route::post('courses/store', [\App\Http\Controllers\Teacher\Courses\CoursesController::class,'store'])->name('courses.store');
    Route::get('courses/edit/{id}', [\App\Http\Controllers\Teacher\Courses\CoursesController::class,'edit'])->name('courses.edit');
    Route::post('courses/update/{id}', [\App\Http\Controllers\Teacher\Courses\CoursesController::class,'update'])->name('courses.update');
    Route::get('courses/delete/{id}', [\App\Http\Controllers\Teacher\Courses\CoursesController::class,'delete'])->name('courses.delete');

    //lessons
    Route::get('course-lessons/{month}/{course_id}', [\App\Http\Controllers\Teacher\Lessons\LessonsController::class,'index'])->name('course.lessons');
    Route::get('lessons/create/{month}/{course_id}', [\App\Http\Controllers\Teacher\Lessons\LessonsController::class,'create'])->name('lessons.create');
    Route::post('course/lessons/store/{month}/{course_id}', [\App\Http\Controllers\Teacher\Lessons\LessonsController::class,'store'])->name('course.lessons.store');
    Route::get('lessons/edit/{id}', [\App\Http\Controllers\Teacher\Lessons\LessonsController::class,'edit'])->name('lessons.edit');
    Route::post('lessons/update/{id}', [\App\Http\Controllers\Teacher\Lessons\LessonsController::class,'update'])->name('lessons.update');
    Route::get('lessons/delete/{id}', [\App\Http\Controllers\Teacher\Lessons\LessonsController::class,'delete'])->name('lessons.delete');

    //teacher courses
    Route::get('teacher-courses/{id}', [\App\Http\Controllers\Admin\Teachers\TeachersController::class,'teacherCourses'])->name('teacher.courses');
    Route::post('teacher-courses/store/{id}', [\App\Http\Controllers\Admin\Teachers\TeachersController::class,'storeTeacherCourses'])->name('teacher.courses.store');
    Route::get('teacher-course-lessons/{month}/{course_id}', [\App\Http\Controllers\Admin\Teachers\TeachersController::class,'teacherCourseLessons'])->name('teacher.course.lessons');
    Route::post('teacher-course-lessons/store/{month}/{course_id}', [\App\Http\Controllers\Admin\Teachers\TeachersController::class,'storeTeacherCourseLessons'])->name('teacher.course.lessons.store');
    Route::get('delete-teacher-course/{id}', [\App\Http\Controllers\Admin\Teachers\TeachersController::class,'deleteTeacherCourse'])->name('delete.teacher.course');
    Route::get('teacher-course-lessons/delete/{id}/{month}', [\App\Http\Controllers\Admin\Teachers\TeachersController::class,'deleteTeacherCourseLesson'])->name('delete.teacher.course.lesson');
    Route::get('teacher-course-lessons/edit/{id}', [\App\Http\Controllers\Admin\Teachers\TeachersController::class,'editTeacherCourseLesson'])->name('edit.teacher.course.lesson');


    //billings
    Route::get('billings/{month}', [\App\Http\Controllers\Admin\Billings\BillingsController::class,'index'])->name('billings.index');
    Route::get('paid-billings/{month}', [\App\Http\Controllers\Admin\Billings\BillingsController::class,'paidBillings'])->name('paid.billings');
    Route::get('salaries/{month}',[\App\Http\Controllers\Admin\Billings\BillingsController::class,'salaries'])->name('salaries.index');
    Route::get('salaries-amount/{month}',[\App\Http\Controllers\Admin\Billings\BillingsController::class,'salariesAmount'])->name('salaries.amount');
});
