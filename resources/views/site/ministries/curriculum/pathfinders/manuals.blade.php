<section class="bg-white pb-10 pt-24 mobile:pb-4 mobile:pt-12">
  <div class="container-xl desktop_extralarge:pl-[50px] desktop_extralarge:pr-[50px] desktop:px-10 tablet:px-6">
    <h5 class="mb-14 text-center uppercase mobile:mb-9">
      Manuals
    </h5>
    <div class="-mx-2 flex flex-wrap">
      <div class="w-1/6 px-2 tablet:mb-5 tablet:w-1/3 mobile-small:w-1/2">
        <div class="h-full rounded-xl bg-medium_blue bg-opacity-75 px-3 py-5 text-center">
          <a href="{{ route('resources.show', ['slug' => 'friendmanual']) }}">

            <img class="mb-1 inline-block align-top" src="{{ asset('images/friend.png') }}" alt="">
            <h6 class="mb-0 text-white">
              Friend
            </h6>
          </a>
        </div>
      </div>
      <div class="w-1/6 px-2 tablet:mb-5 tablet:w-1/3 mobile-small:w-1/2">
        <div class="h-full rounded-xl bg-medium_green bg-opacity-75 px-3 py-5 text-center">
          <a href="{{ route('resources.show', ['slug' => 'companionmanual']) }}">
            <img class="mb-1 inline-block align-top" src="{{ asset('images/companion.png') }}" alt="">
            <h6 class="mb-0 text-white">
              Companion
            </h6>
          </a>
        </div>
      </div>
      <div class="w-1/6 px-2 tablet:mb-5 tablet:w-1/3 mobile-small:w-1/2">
        <div class="h-full rounded-xl bg-dark_blue bg-opacity-75 px-3 py-5 text-center">
          <a href="{{ route('resources.show', ['slug' => 'explorermanual']) }}">

            <img class="mb-1 inline-block align-top" src="{{ asset('images/explorer.png') }}" alt="">
            <h6 class="mb-0 text-white">
              Explorer
            </h6>
          </a>
        </div>
      </div>
      <div class="w-1/6 px-2 tablet:mb-5 tablet:w-1/3 mobile-small:w-1/2">
        <div class="h-full rounded-xl bg-light_green bg-opacity-75 px-3 py-5 text-center">
          <a href="{{ route('resources.show', ['slug' => 'rangermanual']) }}">

            <img class="mb-1 inline-block align-top" src="{{ asset('images/ranger.png') }}" alt="">
            <h6 class="mb-0 text-white">
              Ranger
            </h6>
          </a>
        </div>
      </div>
      <div class="w-1/6 px-2 tablet:mb-5 tablet:w-1/3 mobile-small:w-1/2">
        <div class="h-full rounded-xl bg-medium_blue bg-opacity-75 px-3 py-5 text-center">
          <a href="{{ route('resources.show', ['slug' => 'voyagermanual']) }}">
            <img class="mb-1 inline-block align-top" src="{{ asset('images/voyager.png') }}" alt="">
            <h6 class="mb-0 text-white">
              Voyager
            </h6>
          </a>
        </div>
      </div>
      <div class="w-1/6 px-2 tablet:mb-5 tablet:w-1/3 mobile-small:w-1/2">
        <div class="h-full rounded-xl bg-medium_blue bg-opacity-75 px-3 py-5 text-center">
          <a href="{{ route('resources.show', ['slug' => 'guidemanual']) }}">
            <img class="mb-1 inline-block align-top" src="{{ asset('images/guide.png') }}" alt="">
            <h6 class="mb-0 text-white">
              Guide
            </h6>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
