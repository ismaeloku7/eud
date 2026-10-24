@php($resourcesList = [
    ['title' => 'Decisive Encounters', 'image' => asset('images/Romans-pdf.png'), 'url' => route('resources.show', ['slug' => 'decisive-encounters']), 'video' => 'https://www.youtube.com/embed/Cg7ezwdyzhs?si=FptThhYLIUkoD6NP'],
    ['title' => 'Magna Opera: The Loveliest Song', 'image' => asset('images/Romans-pdf.png'), 'url' => route('resources.show', ['slug' => 'magna-opera-the-loveliest-song']), 'video' => 'https://www.youtube.com/embed/gC1Z_xET7nc?si=AQ8TrKt5Z74gn3tY'],
    ['title' => "The Earth is the Lord's: Caring for God's Creation", 'image' => asset('images/Romans-pdf.png'), 'url' => route('resources.show', ['slug' => 'the-earth-is-the-lords-called-to-care-for-creation']), 'video' => 'https://www.youtube.com/embed/UdEUfE6BbvI?si=pve2kWAeP_ewqIJN'],
    ['title' => 'The Fruit of the Spirit', 'image' => asset('images/Romans-pdf.png'), 'url' => route('resources.show', ['slug' => 'the-fruit-of-the-spirit']), 'video' => 'https://www.youtube.com/embed/4DxvhIbXgik?si=-enqz-sThHVGcyXd'],
    ['title' => '8 Questions God Wants to Ask You', 'image' => asset('images/Romans-pdf.png'), 'url' => route('resources.show', ['slug' => '8-questions-god-wants-to-ask-you']), 'video' => null],
    ['title' => 'Prayer as a Lifestyle: Living in Connection with God', 'image' => asset('images/Romans-pdf.png'), 'url' => route('resources.show', ['slug' => 'prayer-as-a-lifestyle']), 'video' => null],
    ['title' => 'Nothing at All, or Not: A Practical Study Guide on Ecclesiastes', 'image' => asset('images/Romans-pdf.png'), 'url' => route('resources.show', ['slug' => 'nothing-at-all-or-not']), 'video' => null],
])
<div class="container-xl desktop_extralarge:pl-[50px] desktop_extralarge:pr-[50px] desktop:px-10 tablet:px-6">
  <div class="border-t border-solid border-dark_border pt-16 mobile:border-0 mobile:pt-11">
    <a class="social-share mb-7 inline-block mobile:hidden" href="javascript:void(0);">
      <img src="{{ asset('images/Share-ic-big.png') }}" alt="">
    </a>
    <h2 class="mb-4">
      <strong>
        Introduction
      </strong>
    </h2>
    <div class="-mx-12 flex flex-wrap desktop:-mx-6">
      <div class="w-1/2 px-12 desktop_large:mb-16 desktop_large:w-full desktop:px-6">
        <p class="mobile:text-justify">
          Young Adults is the ministry within the Seventh-day Adventist Church that caters to adults ages 22 to 30/35.
          <br>
          <br>
          The story of the Adventist Youth Society, now titled Young Adults (YA), began in 1879 along a dusty country
          lane in Michigan with two young boys kneeling in prayer. Today that dusty lane has become a world-wide web of
          highways that links over 10 million Seventh-day Adventist young people in nearly every country on every
          continent of the globe.
          <br>
          <br>
          Our purpose is to lead young people into a saving relationship with Jesus Christ and help them embrace His
          call to discipleship. Four dynamic forces are strongly interwoven into the work and mission with young adults:
          grace, worship, community, and service.
        </p>
        <h6>
          <strong>
            Example > AREA MY CLUB:
          </strong>
        </h6>
        <p class="mobile:text-justify">
          SQUIRRELS: Req. #4: “Recognize the song of the ‘Cachorros’”
          <br>
          LITTLE LAMBS: Req. #4: “Learn the song and recognize the uniform of the ‘Cachorros’”
          <br>
          BEAVERS: Req. #3 and 4: “Know the song “Soy un Cachorro’ / Be able to explain ‘Cachorros’ uniform”.
          <br><br>
          
        </p>
        <h6>
          <strong>
            Resources
          </strong>
        </h6>
        <div class="-mx-3 mb-10 flex max-w-2xl flex-wrap">
          @foreach ($resourcesList as $item)
            <div @class(['px-3 w-1/3 mobile:mb-4 mobile:w-1/2'])>
              <img class="mb-2" src="{{ $item['image'] }}" alt="">
              <h6>
                <strong>
                  {{ $item['title'] }}
                </strong>
              </h6>
              <div class="download-document">

                <a class="mt-3 inline-block align-top text-medium_blue hover:text-medium_blue hover:underline"
                  href="javascript:void(0);">
                  <img class="mr-1 inline-block" src="{{ asset('images/Download_Icon_blue.svg') }}" alt="">
                  Download 1,35 MB
                </a>
              </div>
            </div>
            @if (isset($item['video']))
              <div class="w-1/2 mobile:mb-4 mobile:w-1/2">
                <div class="video-container aspect-video">
                  <iframe class="h-full w-full" src="{{ $item['video'] }}" frameborder="0" allowfullscreen>
                  </iframe>
                </div>
              </div>
            @endif
          @endforeach
        </div>
        
      </div>
      <div class="w-1/2 px-12 desktop_large:w-full desktop:px-6">
        <blockquote class="mb-16 ml-0">
          <h2>
            “But seek first the kingdom of God and his righteousness, and all these things will be added to you.”
          </h2>
          <p class="text-right">Matthew 6:33 ESV</p>
        </blockquote>

      </div>
    </div>
  </div>
</div>
