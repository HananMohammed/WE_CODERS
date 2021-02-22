@extends('admin.layouts.app')

@section('title', 'Blogs')

@section('content')
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">@lang('admin.blogs')</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.adminPanel')}}" class="text-muted">@lang('admin.adminPanel')</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.blogs.index')}}" class="text-muted">@lang('admin.blogs')</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--end::Subheader-->
    @include('admin.homepage.blog.form_store')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid mt-5" id="kt_content">
        <!--begin::Container-->
        <div class="container">
            @if(!empty($errors->any()))
                <div class="alert alert-custom alert-light-danger fade show mb-5" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <ol>
                            @if($errors->any())
                                {!! implode('',$errors->all('<li>:message</li>')) !!}
                            @endif
                        </ol>
                    </div>
                    <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                        </button>
                    </div>
                </div>
        @endif

        <!--begin::Card-->
            <div class="card card-custom gutter-b" style="width: 100%;">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">@lang('admin.blogs')</h3>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        <a href="javascript:void(0)" class="btn btn-primary font-weight-bolder d-flex" data-toggle="modal" data-target="#newsModal">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"></rect>
                                <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>@lang('admin.new-section')</a>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-checkable " id="kt_datatable">
                                    <thead>
                                    <tr role="row">
                                        <th>@lang('dashboard.id')</th>
                                        <th>@lang('admin.image')</th>
                                        <th>@lang('admin.title')</th>
                                        <th>@lang('admin.description')</th>
                                        <th>@lang('admin.created_by')</th>
                                        <th>@lang('admin.actions')</th>
                                    </tr>
                                    </thead>
                                    @if(count($blogs)>0)
                                        <tbody>
                                        @foreach($blogs as $blog)
                                            <tr>
                                                <td>{{$blog->id}}</td>
                                                <td><img src="{{asset_public('storage/uploads/'.$blog->image)}}" style="width: 100px;height: 60px;"></td>
                                                <td>{{$blog->title}}</td>
                                                <td>{{$blog->text}}</td>
                                                <td>{{$blog->user()->pluck('name')[0]}}</td>
                                                <td nowrap="nowrap">{{ $blog->id }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
@section('scripts')
    <script src="{{ asset_public('admin/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{asset_public('admin/assets/js/pages/crud/forms/widgets/bootstrap-timepicker.js')}}"></script>
    <script>
        $(".modal").on("hidden.bs.modal", function(){
            $(".modal-body1").html("");
        });
        $(document).on("click", ".lessonEdit", function () {
            let lessonId = $(this).attr('data-lesson');
            url = currentLocation+'/'+lessonId
            urlEdit = currentLocation+'/'+lessonId+'/edit'
            $('#newsEditForm').attr("action", url)
            console.log(lessonId)
            $.ajax({
                url: urlEdit,
                type: 'GET',
                dataType: 'JSON',
                success: function (data) {
                    console.log(data)
                    $("#edit_title_en").attr("value",data.title.en)
                    $("#edit_title_ar").attr("value",data.title.ar)
                    $("#edit_text_en").attr("value",data.text.en)
                    $("#edit_text_ar").attr("value",data.text.ar)
                    $("#edit_kt_timepicker_2").attr("value",data.time)
                 }
            });
        });
    </script>
   <script>
       var KTBootstrapTimepicker = function () {

           // Private functions
           var demos = function () {
               // minimum setup
               $('#kt_timepicker_2, #kt_timepicker_2_modal').timepicker({
                   minuteStep: 1,
                   defaultTime: '',
                   showSeconds: true,
                   showMeridian: false,
                   snapToStep: true
               });
               $('#edit_kt_timepicker_2, #kt_timepicker_2_modal').timepicker({
                   minuteStep: 1,
                   defaultTime: '',
                   showSeconds: true,
                   showMeridian: false,
                   snapToStep: true
               });
             }

           return {
               // public functions
               init: function() {
                   demos();
               }
           };
       }();

       jQuery(document).ready(function() {
           KTBootstrapTimepicker.init();
       });
   </script>
    <script type="text/javascript">
        $( document ).ready(function() {

// begin first table
            var table = $('#kt_datatable');
            console.log(table);
            table.DataTable({
                responsive: true,
                retrieve: true,
                paging: true,
                // DOM Layout settings
                dom: `<'row'<'col-sm-12'tr>>
<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

                lengthMenu: [5, 10, 25, 50],

                pageLength: 10,

                language: {
                    'lengthMenu': 'Display _MENU_',
                },

                // Order settings
                order: [[1, 'desc']],

                headerCallback: function(thead, data, start, end, display) {
                    thead.getElementsByTagName('th')[0].innerHTML = `
    <label class="checkbox checkbox-single">
        <input type="checkbox" value="" class="group-checkable"/>
        <span></span>
    </label>`;
                },
                columnDefs: [
                    {
                        targets: 0,
                        title: 'ID',
                        width: '30px',
                        className: 'dt-left',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            return `
        <label class="checkbox checkbox-single">
            <input type="checkbox" value="" class="checkable"/>
            <span></span>
        </label>`;
                        },
                    },
                    {
                        targets: -1,
                        orderable: false,
                        width: '125px',
                        render: function(data, type, full, meta) {
                            // href="`+currentLocation+`/${data}/edit"
                            return `
            <a href="${currentLocation}/blogs/${data}"class="btn btn-sm btn-clean btn-icon" title="Delete" onclick="event.preventDefault();
                        document.getElementById('delete-operator-form-${data}').submit();">
                <span class="svg-icon svg-icon-md">
                    <svg class="delete" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"></rect>
                            <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                            <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                        </g>
                    </svg>
                </span>
                <form id="delete-operator-form-${data}" action="${currentLocation}/${data}" method="POST" style="display: none;">
                    @csrf
                            @method('DELETE')
                            </form>
                        </a>`;
                        },
                    },
                    {
                        targets: 2,
                        title:'{{__('admin.title')}}' ,
                        width: '75px',
                        render: function(data, type, full, meta) {
                            var status = {
                                0: {'title': 'No', 'class': ' label-light-danger'},
                                1: {'title': 'Yes', 'class': ' label-light-primary'},
                            };
                            if (typeof status[data] === 'undefined') {
                                return data;
                            }
                            return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title + '</span>';
                        },
                    },
                ],
            });

        });
    </script>
    <script>
        "use strict";

        // Class definition
        var KTContactsEdit = function () {
            // Base elements
            var avatar;

            var initAvatar1 = function() {
                avatar = new KTImageInput('kt_contacts_edit_avatar1');
            }
            return {
                // public functions
                init: function() {
                    initAvatar1();
                }
            };
        }();


        jQuery(document).ready(function() {
            KTContactsEdit.init();
        });
    </script>
    @if(session()->has('success'))
        <script>Swal.fire("Good Job", "{{session()->get('success')}}", "success");</script>
    @endif
@endsection
