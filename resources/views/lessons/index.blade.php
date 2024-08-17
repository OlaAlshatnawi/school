@extends('layouts.master')

@section('title')
    {{ __('manage') . ' ' . __('lesson') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('manage') . ' ' . __('lesson') }}
            </h3>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card search-container">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ __('create') . ' ' . __('lesson') }}
                        </h4>
                        <form class="pt-3 add-lesson-form" id="create-form" action="{{ route('lesson.store') }}"
                            method="POST" novalidate="novalidate">
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ __('class') . ' ' . __('section') }} <span class="text-danger">*</span></label>
                                    <select name="class_section_id" id="class_section_id" class="class_section_id form-control">
                                        <option value="">--{{ __('select') }}--</option>
                                        @foreach ($class_section as $section)
                                            <option value="{{ $section->id }}" data-class="{{ $section->class->id }}">
                                                {{ $section->class->name . ' ' . $section->section->name . ' - ' . $section->class->medium->name }} {{$section->class->streams->name ?? ''}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ __('subject') }} <span class="text-danger">*</span></label>
                                    <select name="subject_id" id="subject_id" class="subject_id form-control">
                                        <option value="">--{{ __('select') }}--</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ __('lesson_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" placeholder="{{ __('lesson_name') }}"
                                        class="form-control" />
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ __('lesson_description') }} <span class="text-danger">*</span></label>
                                    <textarea id="description" name="description" placeholder="{{ __('lesson_description') }}" class="form-control"></textarea>
                                </div>
                            </div>


                            <h4 class="mb-3">{{ __('files') }}</h4>

                            <div class="form-group">

                                <div class="row file_type_div" id="file_type_div">
                                    <div class="form-group col-md-2">
                                        <label>{{ __('type') }} </label>
                                        <select id="file_type" name="file[0][type]" class="form-control file_type">
                                            <option value="">--{{ __('select') }}--</option>
                                            <option value="file_upload">{{ __('file_upload') }}</option>
                                            <option value="youtube_link">{{ __('youtube_link') }}</option>
                                            <option value="video_upload">{{ __('video_upload') }}</option>
                                            {{-- <option value="other_link">{{ __('other_link') }}</option> --}}
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3" id="file_name_div" style="display: none">
                                        <label>{{ __('file_name') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="file[0][name]" class="file_name form-control"
                                            placeholder="{{ __('file_name') }}" required>
                                    </div>
                                    <div class="form-group col-md-3" id="file_thumbnail_div" style="display: none">
                                        <label>{{ __('thumbnail') }} <span class="text-danger">*</span></label>
                                        <input type="file" name="file[0][thumbnail]" class="file_thumbnail form-control"
                                            required>
                                    </div>
                                    <div class="form-group col-md-3" id="file_div" style="display: none">
                                        <label>{{ __('file_upload') }} <span class="text-danger">*</span></label>
                                        <input type="file" name="file[0][file]" class="file form-control" placeholder=""
                                            required>
                                    </div>
                                    <div class="form-group col-md-3" id="file_link_div" style="display: none">
                                        <label>{{ __('link') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="file[0][link]" class="file_link form-control"
                                            placeholder="{{ __('link') }}" required>
                                    </div>

                                    <div class="form-group col-md-1 col-md-1 pl-0 mt-4">
                                        <button type="button" class="btn btn-inverse-success btn-icon add-lesson-file">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-3 extra-files"></div>
                            </div>
                            <input class="btn btn-theme" id="create-btn" type="submit" value={{ __('submit') }}>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ __('list') . ' ' . __('lesson') }}
                        </h4>
                        <div id="toolbar">
                            <div class="row">
                                <div class="col">
                                    <select name="filter_subject_id" id="filter_subject_id" class="form-control">
                                        <option value="">{{ __('all') }}</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}">
                                                {{ $subject->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select name="filter_class_section_id" id="filter_class_section_id"
                                        class="form-control">
                                        <option value="">{{ __('all') }}</option>
                                        @foreach ($class_section as $class)
                                            <option value="{{ $class->id }}">
                                                {{ $class->class->name . '-' . $class->section->name .' '. $class->class->medium->name}} {{$class->class->streams->name ?? ''}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select name="filter_lesson_id" id="filter_lesson_id" class="form-control">
                                        <option value="">{{ __('all') }}</option>
                                        @foreach ($lessons as $lesson)
                                            <option value="{{ $lesson->id }}">
                                                {{ $lesson->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                            data-url="{{ route('lesson.show', 1) }}" data-click-to-select="true"
                            data-side-pagination="server" data-pagination="true"
                            data-page-list="[5, 10, 20, 50, 100, 200, All]" data-search="true" data-toolbar="#toolbar"
                            data-show-columns="true" data-show-refresh="true" data-fixed-columns="true"
                            data-fixed-number="2" data-fixed-right-number="1" data-trim-on-search="false"
                            data-mobile-responsive="true" data-sort-name="id" data-sort-order="desc"
                            data-maintain-selected="true" data-export-types='["txt","excel"]'
                            data-query-params="CreateLessionQueryParams"
                            data-export-options='{ "fileName": "lesson-list-<?= date('d-m-y') ?>" ,"ignoreColumn":
                            ["operate"]}'
                            data-show-export="true">
                            <thead>
                                <tr>
                                    <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                                        {{ __('id') }}</th>
                                    <th scope="col" data-field="no" data-sortable="false">{{ __('no.') }}</th>
                                    <th scope="col" data-field="name" data-sortable="true">{{ __('name') }}</th>
                                    <th scope="col" data-field="description" data-sortable="true">
                                        {{ __('description') }}</th>
                                    <th scope="col" data-field="class_section_name" data-sortable="true">
                                        {{ __('class_section') }}</th>
                                    <th scope="col" data-field="subject_name" data-sortable="true">
                                        {{ __('subject') }}</th>
                                    <th scope="col" data-field="file" data-formatter="fileFormatter"
                                        data-sortable="true">{{ __('file') }}</th>
                                    <th scope="col" data-field="created_at" data-sortable="true"
                                        data-visible="false"> {{ __('created_at') }}</th>
                                    <th scope="col" data-field="updated_at" data-sortable="true"
                                        data-visible="false"> {{ __('updated_at') }}</th>
                                    <th scope="col" data-field="operate" data-sortable="false"
                                        data-events="lessonEvents">{{ __('action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                {{ __('edit') . ' ' . __('lesson') }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="pt-3 edit-lesson-form" id="edit-form" action="{{ url('lesson') }}"
                            novalidate="novalidate">
                            <input type="hidden" name="edit_id" id="edit_id" value="" />
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label>{{ __('class') . ' ' . __('section') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="class_section_id" id="edit_class_section_id"
                                            class="class_section_id form-control">
                                            <option value="">--{{ __('select') }}--</option>
                                            @foreach ($class_section as $section)
                                                <option value="{{ $section->id }}"
                                                    data-class="{{ $section->class->id }}">
                                                    {{ $section->class->name . ' ' . $section->section->name . ' - ' . $section->class->medium->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-12 col-md-6">
                                        <label>{{ __('subject') }} <span class="text-danger">*</span></label>
                                        <select name="subject_id" id="edit_subject_id" class="subject_id form-control">
                                            <option value="">--{{ __('select') }}--</option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->name.' - '.$subject->type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label>{{ __('lesson_name') }} <span class="text-danger">*</span></label>
                                        <input type="text" id="edit_name" name="name"
                                            placeholder="{{ __('lesson_name') }}" class="form-control" />
                                    </div>

                                    <div class="form-group col-sm-12 col-md-6">
                                        <label>{{ __('lesson_description') }} <span class="text-danger">*</span></label>
                                        <textarea id="edit_description" name="description" placeholder="{{ __('lesson_description') }}"
                                            class="form-control"></textarea>
                                    </div>
                                </div>

                                <h4 class="mb-3">{{ __('files') }}</h4>
                                <div class="row edit_file_type_div" id="edit_file_type_div">
                                    <input type="hidden" id="edit_file_id" name="edit_file[0][id]" />
                                    <div class="form-group col-md-2"  style="pointer-events: none">
                                        <label>{{ __('type') }}</label>
                                        <select id="edit_file_type" name="edit_file[0][type]"
                                            class="form-control file_type">
                                            <option value="">--{{ __('select') }}--</option>
                                            <option value="file_upload">{{ __('file_upload') }}</option>
                                            <option value="youtube_link">{{ __('youtube_link') }}</option>
                                            <option value="video_upload">{{ __('video_upload') }}</option>
                                            {{-- <option value="other_link">{{ __('other_link') }}</option> --}}
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3" id="file_name_div" style="display: none">
                                        <label>{{ __('file_name') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="edit_file[0][name]" class="file_name form-control"
                                            placeholder="{{ __('file_name') }}" required>
                                    </div>
                                    <div class="form-group col-md-3" id="file_thumbnail_div" style="display: none">
                                        <label>{{ __('thumbnail') }} <span class="text-danger">*</span></label>
                                        <input type="file" name="edit_file[0][thumbnail]"
                                            class="file_thumbnail form-control">
                                        <div style="width: 60px">
                                            <img src="" id="file_thumbnail_preview" class="w-100">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3" id="file_div" style="display: none">
                                        <label>{{ __('file_upload') }} <span class="text-danger">*</span></label>
                                        <input type="file" name="edit_file[0][file]" class="file form-control"
                                            placeholder="">
                                        <a href="" target="_blank" id="file_preview" class="w-100"></a>
                                    </div>
                                    <div class="form-group col-md-3" id="file_link_div" style="display: none">
                                        <label>{{ __('link') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="edit_file[0][link]" class="file_link form-control"
                                            placeholder="{{ __('link') }}" required>
                                    </div>

                                    <div class="form-group col-md-1 pl-0 mt-4">
                                        <button type="button" class="btn btn-icon btn-inverse-danger remove-lesson-file">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-3 edit-extra-files"></div>
                                <div>
                                    <div class="form-group pl-0 mt-4">
                                        <button type="button" class="col-md-3 btn btn-inverse-success edit-lesson-file">
                                            {{ __('add_new_files') }} <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ __('close') }}</button>
                                <input class="btn btn-theme" type="submit" value={{ __('edit') }} />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
