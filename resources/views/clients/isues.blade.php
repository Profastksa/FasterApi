@extends('layouts.master')
@push('links')
<meta name="csrf-token" content="{{ csrf_token() }}">

    <style id='inline_style'>
        h4 {
            font-weight: bold;
        }

        h2 {
            margin-top: 50px;
        }

        .breaker{
            page-break-before: always;
        }
    </style>
@endpush
@section('content')

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{ __('translation.clients.management') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('clients') }}
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">
            </div>
        </div>
        <div class="content-body">
            <!-- Zero configuration table -->
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        {{-- <li><a data-action="close"><i class="ft-x"></i></a></li> --}}
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body ">
                                <ul class="HiddenInPrint nav nav-tabs nav-linetriangle no-hover-bg "
                                    style="border-bottom-color:#1e9ff2">
                                    <li class="nav-item ">
                                        <a class="nav-link active" id="base-tab41" data-toggle="tab" aria-controls="tab41"
                                            href="#tab41" aria-expanded="true">{{ __('translation.data.issue') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " id="base-tab42" data-toggle="tab" aria-controls="tab42"
                                            href="#tab42" aria-expanded="false">{{ __('translation.file.issue') }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content px-1 pt-1 ">
                                    <div role="tabpanel" class="tab-pane active" id="tab41" aria-expanded="true"
                                        aria-labelledby="base-tab41">
                                        <p>
                                        <div class="card-content collapse show">
                                            <div class="card-body card-dashboard" id='card-dashboard' >
                                                @include('clients.billDesign')
                                            </div>

                                            <div>
                                                <!-- Cancel Issue Section -->
                                                <button id="send-otp" class="btn btn-primary">الغاء الكشف</button>
                                                <div id="otp-section" style="display: none;">
                                                    <form id="verify-otp-form">
                                                        @csrf
                                                        <div class="col-md-6">
                                                            <div class="form-group posision-relative">
                                                                <label for="">ادخل رمز التحقق</label>
                                                                <input type="text" name="otp" class="form-control" placeholder="رمز التحقق">
                                                            </div>
                                                            <div class="form-group posision-relative">
                                                                <label for=""></label>
                                                                <button type="submit" class="btn btn-success"> تحقق من الرمز</button>

                                                            </div>
                                                        </div>

                                                        <div id="otp-message"></div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                        </p>
                                    </div>
                                    <div class="tab-pane " id="tab42" aria-labelledby="base-tab42">
                                        <p>
                                        <form action="{{ route('UploadFiles', $id) }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="">{{ __('translation.add.file') }}</label>
                                                <input type="file" class="form-control" name="file" id=""
                                                    accept="image/*" onchange="this.form.submit()"
                                                    aria-describedby="helpId" placeholder="">
                                            </div>
                                        </form>
                                        <hr>
                                        <div>
                                            @foreach ($ClientStatementIsues->Photos as $item)
                                                <div class="d-flex justify-content-between align-items-center m-1">
                                                    <div class="col-md-3">
                                                        <img src="{{ $item->photo }}" width="70px" height="70px"
                                                            alt="" />
                                                    </div>
                                                    <div>
                                                        <a target="_blank" href="{{ route('showFile', $item->id) }}"
                                                            class="btn btn-sm btn-outline-info">
                                                            <span>
                                                                <svg style="width:15px;height:15px" viewBox="0 0 24 24">
                                                                    <path fill="currentColor"
                                                                        d="M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C12.36,19.5 12.72,19.5 13.08,19.45C13.03,19.13 13,18.82 13,18.5C13,17.94 13.08,17.38 13.24,16.84C12.83,16.94 12.42,17 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12C17,12.29 16.97,12.59 16.92,12.88C17.58,12.63 18.29,12.5 19,12.5C20.17,12.5 21.31,12.84 22.29,13.5C22.56,13 22.8,12.5 23,12C21.27,7.61 17,4.5 12,4.5M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M18,14.5V17.5H15V19.5H18V22.5H20V19.5H23V17.5H20V14.5H18Z" />
                                                                </svg>
                                                            </span>
                                                        </a>
                                                        <a href="{{ route('downloadImage', $item->id) }}"
                                                            class="btn btn-sm btn-outline-success">
                                                            <span>
                                                                <svg style="width:15px;height:15px" viewBox="0 0 24 24">
                                                                    <path fill="currentColor"
                                                                        d="M5,20H19V18H5M19,9H15V3H9V9H5L12,16L19,9Z" />
                                                                </svg>
                                                            </span>
                                                        </a>
                                                        <a href="{{ route('DeletImage2', $item->id) }}"
                                                            class="btn btn-sm
                                                    btn-outline-danger">
                                                            <span>
                                                                <svg style="width:14px;height:14px" viewBox="0 0 24 24">
                                                                    <path fill="currentColor"
                                                                        d="M20.37,8.91L19.37,10.64L7.24,3.64L8.24,1.91L11.28,3.66L12.64,3.29L16.97,5.79L17.34,7.16L20.37,8.91M6,19V7H11.07L18,11V19A2,2 0 0,1 16,21H8A2,2 0 0,1 6,19Z" />
                                                                </svg>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
        </div>
        </section>
        <!--/ Zero configuration table -->
    </div>
    </div>

    @push('scripts')
     <script>
       document.getElementById('send-otp').addEventListener('click', function() {
    fetch(`{{ route('client.issue.cancel', $id) }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('otp-message').innerText = data.message;
        document.getElementById('otp-section').style.display = 'block';
        document.getElementById('send-otp').style.display = 'none';

    });
});

document.getElementById('verify-otp-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch(`{{ route('client.issue.verify-otp', $id) }}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('otp-message').innerText = data.message;
        if (data.message === 'Issue cancelled successfully') {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

     </script>
     @endpush
@endsection
