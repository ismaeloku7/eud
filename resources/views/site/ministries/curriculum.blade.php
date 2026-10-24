@if (view()->exists("site.ministries.curriculum.{$ministry->slug}.index"))
    @include("site.ministries.curriculum.{$ministry->slug}.index")
@else
    <div class="container-xl py-20 text-center text-primary">
        <p>{{ __('ministries.no_curriculum') }}</p>
    </div>
@endif
