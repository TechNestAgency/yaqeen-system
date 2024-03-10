@extends('layouts.index')

@section('content')

    <div class="page-content-wrapper border">

        <!-- Title -->
        <div class="row">
            <div class="col-6">
                <!-- Button trigger modal -->
                <button type="button" class="btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                    <i class="fas fa-plus-square me-3"></i>اضافة درس
                </button>
            </div>
            <div class="col-6 mb-3">
                <h1 class="h3 mb-2 mb-sm-0 text-end">الدروس</h1>
            </div>

        </div>

        <!-- Months -->
        <div class="row" style="margin-top: 30px">
            <div class="col-12 text-center">
                <a href="{{route('teacher.course.lessons',['month'=>1,'course_id'=>$course_id])}}" @if($month == '1') class="btn btn-secondary disabled" @else class="btn btn-primary" @endif>يناير</a>
                <a href="{{route('teacher.course.lessons',['month'=>2,'course_id'=>$course_id])}}" @if($month == '2') class="btn btn-secondary disabled" @else class="btn btn-primary" @endif>فبراير</a>
                <a href="{{route('teacher.course.lessons',['month'=>3,'course_id'=>$course_id])}}" @if($month == '3') class="btn btn-secondary disabled" @else class="btn btn-primary" @endif>مارس</a>
                <a href="{{route('teacher.course.lessons',['month'=>4,'course_id'=>$course_id])}}" @if($month == '4') class="btn btn-secondary disabled" @else class="btn btn-primary" @endif>أبريل</a>
                <a href="{{route('teacher.course.lessons',['month'=>5,'course_id'=>$course_id])}}" @if($month == '5') class="btn btn-secondary disabled" @else class="btn btn-primary" @endif>مايو</a>
                <a href="{{route('teacher.course.lessons',['month'=>6,'course_id'=>$course_id])}}" @if($month == '6') class="btn btn-secondary disabled" @else class="btn btn-primary" @endif>يونيو</a>
                <a href="{{route('teacher.course.lessons',['month'=>7,'course_id'=>$course_id])}}" @if($month == '7') class="btn btn-secondary disabled" @else class="btn btn-primary" @endif>يوليو</a>
                <a href="{{route('teacher.course.lessons',['month'=>8,'course_id'=>$course_id])}}" @if($month == '8') class="btn btn-secondary disabled" @else class="btn btn-primary" @endif>أغسطس</a>
                <a href="{{route('teacher.course.lessons',['month'=>9,'course_id'=>$course_id])}}" @if($month == '9') class="btn btn-secondary disabled" @else class="btn btn-primary" @endif>سبتمبر</a>
                <a href="{{route('teacher.course.lessons',['month'=>10,'course_id'=>$course_id])}}" @if($month == '10') class="btn btn-secondary disabled" @else class="btn btn-primary" @endif>أكتوبر</a>
                <a href="{{route('teacher.course.lessons',['month'=>11,'course_id'=>$course_id])}}" @if($month == '11') class="btn btn-secondary disabled" @else class="btn btn-primary" @endif>نوفمبر</a>
                <a href="{{route('teacher.course.lessons',['month'=>12,'course_id'=>$course_id])}}" @if($month == '12') class="btn btn-secondary disabled" @else class="btn btn-primary" @endif>ديسمبر</a>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center" style="direction: rtl">
            @foreach($lessons as $lesson)
                <div class="col-md-2 p-2">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-body">
                            <h5 class="card-title">{{$lesson->lesson_name}} </h5>
                            <p class="card-text">
                                اسم الطالب :
                                {{$lesson->student->user_name}}
                            </p>
                            <p class="card-text">اسم الدورة :
                                {{$lesson->course->course_name}}
                            </p>
                            <p class="card-text">تاريخ الدرس :
                                {{ date('d-m-Y', strtotime($lesson->lesson_date)) }}
                            </p>
                            <p class="card-text">
                                مدة الدرس :
                                {{$lesson->lesson_duration}}
                                ساعة
                            </p>
                            <a href="#" class="btn btn-danger deleteButton" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-url="{{route('delete.teacher.course.lesson',['id'=>$lesson->id,'month'=>$month])}}"> حذف !!!!</a><br>                            <!-- Edit Lesson Button -->
{{--                            <!-- Edit Lesson Button -->--}}
{{--                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editLessonModal" data-lesson='{"id": {{$lesson->id}}, "name": "{{$lesson->lesson_name}}", "date": "{{ date('Y-m-d', strtotime($lesson->lesson_date)) }}", "duration": "{{$lesson->lesson_duration}}"}'>تعديل</button>--}}
{{--                            <!-- Edit Lesson Modal -->--}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </div>
    <!-- Counter boxes END -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">تأكيد الحذف </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    هل تريد الحذف بالتأكيد ؟؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                    <a id="confirmDeleteButton" class="btn btn-danger">حذف</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var deleteButtons = document.querySelectorAll('.deleteButton');
            var confirmDeleteButton = document.getElementById('confirmDeleteButton');
            var deleteConfirmationModal = document.getElementById('deleteConfirmationModal');

            deleteButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    confirmDeleteButton.href = button.dataset.url;
                });
            });
        });
    </script>
    <!-- Modal -->
    <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true" style="direction: rtl">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCourseModalLabel">اضافه درس</h5>
                </div>
                <form action="{{route('teacher.course.lessons.store',['month'=>$month,'course_id'=>$course_id])}}" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="lesson_name" class="form-label">اسم الدرس</label>
                            <input type="text" class="form-control" id="lesson_name" name="lesson_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="lesson_date" class="form-label">التاريخ</label>
                            <input type="date" class="form-control" id="lesson_date" name="lesson_date" required>
                        </div>

                        <div class="mb-3">
                            <label for="lesson_duration" class="form-label">مدة الدرس</label>
                            <select class="form-control" name="lesson_duration" required>
                                <option value=".5">30 دقيقه</option>
                                <option value=".75">45 دقيقه</option>
                                <option value="1">1 ساعة</option>
                                <option value="1.25">ساعة وربع</option>
                                <option value="1.5">ساعة ونصف</option>
                                <option value="1.75">ساعة و 45 دقيقه</option>
                                <option value="2"> ساعاتان</option>
                            </select>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn btn-primary">اضافه </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

{{--    <div class="modal fade" id="editLessonModal{{$lesson->id}}" tabindex="-1" aria-labelledby="editLessonModalLabel{{$lesson->id}}" aria-hidden="true" style="direction: rtl">--}}
{{--        <div class="modal-dialog">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title" id="editLessonModalLabel{{$lesson->id}}">تعديل الدرس</h5>--}}
{{--                </div>--}}
{{--                <form action="{{route('edit.teacher.course.lesson', $lesson->id)}}" method="post">--}}
{{--                    @csrf--}}
{{--                    @method('PUT')--}}
{{--                    <div class="modal-body">--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="lesson_name" class="form-label">اسم الدرس</label>--}}
{{--                            <input type="text" class="form-control" id="lesson_name" name="lesson_name" value="{{$lesson->lesson_name}}" required>--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="lesson_date" class="form-label">التاريخ</label>--}}
{{--                            <input type="date" class="form-control" id="lesson_date" name="lesson_date" value="{{ date('Y-m-d', strtotime($lesson->lesson_date)) }}" required>--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="lesson_duration" class="form-label">مدة الدرس</label>--}}
{{--                            <input type="text" class="form-control" id="lesson_duration" name="lesson_duration" value="{{$lesson->lesson_duration}}" required>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="modal-footer">--}}
{{--                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>--}}
{{--                        <button type="submit" class="btn btn-primary">تحديث</button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <script>--}}
{{--        // JavaScript function to send data to the modal--}}
{{--        document.getElementById('editLessonModal').addEventListener('show.bs.modal', function (event) {--}}
{{--            // Button that triggered the modal--}}
{{--            var button = event.relatedTarget;--}}

{{--            // Extract info from data-* attributes--}}
{{--            var lesson = JSON.parse(button.getAttribute('data-lesson'));--}}

{{--            // Update the modal's content--}}
{{--            var modal = this;--}}
{{--            modal.querySelector('#lesson_name').value = lesson.name;--}}
{{--            modal.querySelector('#lesson_date').value = lesson.date;--}}
{{--            modal.querySelector('#lesson_duration').value = lesson.duration;--}}

{{--            // Update the form action attribute--}}
{{--            var formAction = "{{route('edit.teacher.course.lesson', 'id')}}";--}}
{{--            formAction = formAction.replace('id', lesson.id);--}}
{{--            modal.querySelector('form').action = formAction;--}}
{{--        });--}}
{{--    </script>--}}

@endsection
