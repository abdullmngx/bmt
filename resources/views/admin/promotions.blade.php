@extends('admin.layouts.app')
@section('title', 'Promotions')
@section('content')
    <div class="row clearfix row-deck">
        <div class="col-12">
            <div class="card">
                <div class="body">
                    <h4 class="card-title">@yield('title')</h4>
                    <div class="mb-4 mt-4">
                        <form action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="summernote">Compose Mail</label>
                                        <textarea name="mail_content" id="summernote" cols="30" rows="10" class="summernote"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="file">Upload Emails (CSV Files only)</label>
                                        <input type="file" name="file" id="file">
                                    </div>
                                    <div class="form-group">
                                        @if ($errors->any())
                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger">{{ $error}}</div>
                                            @endforeach
                                        @endif
                                        @if (session()->has('message'))
                                            <div class="alert alert-success">{{ session('message') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Send Email</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('assets1/vendor/summernote/dist/summernote.js') }}"></script>
@endsection