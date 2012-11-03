@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('platform/dashboard::general.title') }}
@endsection

<!-- Page Content -->
@section ('content')
<section id="dashbaord">
    <div class="messages">
        <div class="alert alert-error">
            {{ Lang::line('platform/users::messages.insufficient_permissions') }}
        </div>
    </div>
</section>
@endsection
