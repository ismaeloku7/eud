@php($resourcesList = [
    ['title' => 'Ambassadors Administrative Manual', 'url' => route('resources.show', ['slug' => 'ambassadors-administrative-manual']), 'image' => asset('images/ministries/ambassadors/Resources_Ambassadors_Images.001.jpeg')],
    ['title' => 'Ambassadors Curriculum (Leader)', 'url' => route('resources.show', ['slug' => 'ambassadors-curriculum-seven-modules-leader']), 'image' => asset('images/ministries/ambassadors/2.jpeg')],
    ['title' => 'Ambassadors Curriculum (Participant)', 'url' => route('resources.show', ['slug' => 'ambassadors-seven-modules-participant']), 'image' => asset('images/Romans-pdf.png')],
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
          Ambassadors is a new level of youth ministry designed to equip leaders with resources to train a new
          generation of youths to be the hands, feet, and voice of Jesus in their local churches and communities.

          <br>

          An ambassador generally represents a country or a cause. A Christian ambassador is a representative of another
          kind; they represent the values, principles, culture, and laws of the kingdom of God. They stand for the
          character and purpose of the King of this kingdom—Jesus Christ, Himself.
        </p>
        <h2>
          <strong>
            Program Fundamentals
          </strong>
        </h2>
        <p class="mobile:text-justify">
          The 7 Foundations of the Ambassador Programming are:
        <ul>
          <li>
            A Christ-centered discipleship plan.
          </li>
          <li>
            Leadership development.
          </li>
          <li>
            A personal, public, and small group based mission lifestyle
          </li>
          <li>
            Character and personality development, including outdoor, high adventure programming.
          </li>
          <li>
            Lifestyle and vocational training.
          </li>
          <li>
            Nurturing godly relationships.
          </li>
          <li>
            Community outreach development through service projects and emergency preparedness training.
          </li>
        </ul>
        </p>
        <h2>
          <strong>
            Essential Elements
          </strong>
        </h2>
        <p class="mobile:text-justify">
          Each of these seven foundations will be presented in modules, with participants gaining certification for each
          module completed. While each module has a specific focus, there are FOUR elements that will be common
          throughout the curriculum:
        <ul>
          <li>
            Spiritual Companion
          </li>
          <li>
            Individual Discipleship Plan (IDP)
          </li>
          <li>
            Projects
          </li>
          <li>
            Social Activities
          </li>
        </ul>
        </p>
        <h6>
          <strong>
            Resources
          </strong>
        </h6>
        <div class="-mx-3 mb-10 flex max-w-2xl flex-wrap">
          @foreach ($resourcesList as $item)
            <div class="flex h-full w-1/3 flex-col px-3 mobile:mb-4 mobile:w-1/2">
              <!-- Contenedor de imagen con tamaño fijo -->
              <div class="mb-2 flex h-48 w-full items-center justify-center overflow-hidden bg-gray-100">
                <img class="h-full w-full object-cover" src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
              </div>

              <h6 class="flex-grow">
                <strong class="block">
                  {{ $item['title'] }}
                </strong>
              </h6>

              <div class="download-document mt-auto">
                <a class="mt-3 inline-flex items-center text-medium_blue hover:text-medium_blue hover:underline"
                  href="{{ $item['url'] }}">
                  <img class="mr-2 h-4 w-4" src="{{ asset('images/Download_Icon_blue.svg') }}" alt="Download">
                  Download 1,35 MB
                </a>
              </div>
            </div>
          @endforeach
        </div>

      </div>
      <div class="w-1/2 px-12 desktop_large:w-full desktop:px-6">
        <blockquote class="mb-16 ml-0">
          <h2>
            “The greatest want of the world is the want of men [and women] . . . who will not be bought or sold, . . .
            who in their inmost souls are true and honest, . . . who do not fear to call sin by its right name, . . .
            whose conscience is as true to duty as the needle to the pole, . . . who will stand for the right though the
            heavens fall.”
          </h2>
          <p class="text-right">Education, p. 57</p>
        </blockquote>
        <h6>
          <strong>
            Pathfinder History
          </strong>
        </h6>
        <div class="video-poster relative">
          <img src="{{ asset('images/priscilla-du-preez-nF8xhLMmg0c-unsplash.png') }}" alt="">
          <div class="video-top-option absolute left-0 right-0 top-0 pb-8">
            <div class="flex justify-between py-5 pl-4 pr-10 mobile:pb-0 mobile:pl-4 mobile:pr-0 mobile:pt-4">
              <div class="flex items-center">
                <img class="mr-2 inline-block" src="{{ asset('images/video-logo.png') }}" alt="">
                <p>
                  A History of Pathfinders
                </p>
              </div>
              <div class="-mx-4 flex">
                <div class="px-4 text-center mobile:px-0 mobile:pl-2">
                  <img class="inline-block align-top mobile:w-6" src="{{ asset('images/clock-ic.png') }}"
                    alt="">
                  <p class="text-10p">
                    Später ans …
                  </p>
                </div>
                <div class="px-4 text-center">
                  <img class="inline-block align-top" src="{{ asset('images/forward-ic.png') }}" alt="">
                  <p class="text-10p">
                    Teilen
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="play-btn" onclick="playMasterGuide()">
            <iframe src="https://www.youtube.com/embed/GGtfR1xqmbI?si=eSBwU3zK_7bIKmi0" title="YouTube video player"
              width="560" height="315" frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          </div>
          <video controls="">
            <source src="{{ asset('video/CABECERA-WEB-Viralgen-WHAT WE DO.mp4') }}" type="video/mp4">
            <source src="{{ asset('video/CABECERA-WEB-Viralgen-WHAT-WE-DO.ogg') }}" type="video/ogg">
            <source src="{{ asset('video/CABECERA-WEB-Viralgen-WHAT WE DO.webm') }}" type="video/webm">
          </video>
        </div>
      </div>
    </div>
  </div>
</div>
