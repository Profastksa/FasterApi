<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.organization.profile')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('privacy.policy') }}
                    </div>
                </div>
            </div>

        </div>
        <div class="content-body">
            <section id="configuration">

                <div class="card">
                    <div class="card-header">
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                        <form action="{{route('store.privacy')}}" >
                        <div class="form-group">
                          <label for="">{{__('translation.privacy.policy')}}</label>
                          <textarea id='mytextarea' class="form-control"></textarea>
                        </div>
                        <button>jksa altigani</button>

                        </form>
            </section>
        </div>
    </div>
</div>

@push('scripts')
@section('script')

<script
src='https://cdn.tiny.cloud/1/twhrixacjh7gu2n28ekp4d2nvz4gr2obc0p6gq8l58lmbwba/tinymce/5/tinymce.min.js' referrerpolicy="origin">
</script>
<script>
  tinymce.init({
    selector: '#mytextarea'
  });
</script>
@endsection
