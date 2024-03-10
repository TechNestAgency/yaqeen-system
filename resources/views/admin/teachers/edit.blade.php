@extends('layouts.index')

@section('content')
    <!-- Page main content START -->
    <div class="page-content-wrapper border">

        <!-- Title -->
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-2 mb-sm-0 text-end" >تعديل المعلم</h1>
            </div>

        </div><br>

        <!-- Card START -->
        <div class="card bg-transparent border" style="direction: rtl">

            <!-- Card header START -->
            <div class="card-header bg-light border-bottom">
                <!-- Search and select START -->
                <div class="row g-3 align-items-center justify-content-between">
                    <div class="col-md-3" style="display: none">
                        <!-- Short by filter -->
                        <form>
                            <select class="form-select js-choice border-0 z-index-9" aria-label=".form-select-sm">
                                <option value="">Sort by</option>
                                <option>Newest</option>
                                <option>Oldest</option>
                                <option>Accepted</option>
                                <option>Rejected</option>
                            </select>
                        </form>
                    </div>

                    <div>
                        <form action="{{route('teachers.update',$teacher->id)}}" method="post">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="user_name" class="form-control" id="exampleInputEmail1" value="{{$teacher->user_name}}" aria-describedby="emailHelp" placeholder="ادخل الاسم">
                            </div><br>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1" value="{{$teacher->email}}" aria-describedby="emailHelp" placeholder="ادخل الايميل">
                            </div> <br>

                            <button type="submit" class="btn btn-primary"> تعديل</button>
                        </form>
                    </div>
                    <div style="margin-top: 50px">
                        <div class="row">
                            <div class="col-6">
                                <h5>طلاب المعلم</h5>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">اضافه طالب</button>

                            </div>
                        </div><br>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center">الاسم</th>
                                <th scope="col" class="text-center">العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                               @foreach($students as $student)
                                   <tr>
                                       <td class="text-center">{{$student->user_name}}</td>
                                       <td class="text-center">
                                           <a href="{{route('teacher.remove.student',['teacher_id'=>$teacher->id,'student_id'=>$student->id])}}" class="btn btn-sm btn-danger mb-0">حذف</a>
                                       </td>
                                   </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Search and select END -->
            </div>


        </div>
        <!-- Card END -->
    </div>
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">اضافه طالب</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addStudentForm" method="get" action="{{route('teacher.add.student',['teacher_id'=>$teacher->id])}}">
                        @csrf
                        <div class="mb-3">
                            <label for="studentSelect" class="form-label">اختر الطالب</label>
                            <select class="form-select" id="studentSelect" name="student_id" required>
                                @foreach(\App\Models\User::where('user_type',\App\Models\User::USER_TYPE['student'])->get() as $student)
                                    <option value="{{$student->id}}">{{$student->user_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">اضافه</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Page main content END -->

@endsection
