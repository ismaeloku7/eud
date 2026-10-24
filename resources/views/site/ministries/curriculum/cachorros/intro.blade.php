<div class="container-xl desktop_extralarge:pl-[50px] desktop_extralarge:pr-[50px] desktop:px-10 tablet:px-6">
  <div class="border-t border-solid border-dark_border pt-16 mobile:border-0 mobile:pt-11">
    <a class="social-share mb-7 inline-block" href="javascript:void(0);">
      <img src="{{ asset('images/Share-ic-big.png') }}" alt="">
    </a>
    <h2 class="mb-4">
      <strong>
        Achievement Classes
      </strong>
    </h2>
    <div class="-mx-12 flex flex-wrap desktop:-mx-6">
      <div class="w-1/2 px-12 desktop_large:mb-16 desktop_large:w-full desktop:px-6">
        <p class="mobile:text-justify">
          The three Cachorros achievement classes are Squirrels (age 3), Little Lambs (age 4) and Beavers (age 5).
        </p>
        <p class="mobile:text-justify">
          The Cachorros achievement classes have been designed in such a way that some requirements increase in
          difficulty following the child's growth rate, both in age and knowledge. Thus, you will notice that when one
          requirement appears in all three classes (Squirrels, Little Lambs and Beavers), the level of difficulty will
          differ as well as the suggested activities.
        </p>
        <p class="mobile:text-justify">
          Assessment activities are also included.
        </p>

        <livewire:ministries.curriculum-resources :ministry="$ministry" />
      </div>
      <div class="w-1/2 px-12 desktop_large:w-full desktop:px-6">
        <blockquote class="mb-16 ml-0">
          <h2>
            “The work of education and training should commence with the babyhood of the child; for then the
            mind is the most impressible, and the lessons given are remembered.”
          </h2>
          <p class="text-right">Child Guidance, p. 26</p>
        </blockquote>

      </div>
    </div>
  </div>
</div>

<style>
  @media(max-width: 767px) {
    .achievement-tabs-nav {
      margin-left: -1.5rem;
      margin-right: -1.5rem;
    }
  }
</style>
