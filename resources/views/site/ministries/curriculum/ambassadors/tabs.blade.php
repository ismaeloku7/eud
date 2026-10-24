@php($tabs = [['id' => 1, 'name' => 'Friends'], ['id' => 2, 'name' => 'Companion'], ['id' => 3, 'name' => 'Explorer'], ['id' => 4, 'name' => 'Ranger'], ['id' => 5, 'name' => 'Voyager'], ['id' => 6, 'name' => 'Guide']])
<section class="section-curriculum bg-secondary pb-30 mobile:pb-20">
  <div class="container-xl desktop_extralarge:pl-[50px] desktop_extralarge:pr-[50px] desktop:px-10 tablet:px-6">
    <div class="rounded-xl bg-white px-24 pb-30 pt-16 desktop_large:px-16 mobile:px-9 mobile:py-9">
      <div class="achievement-tabs-nav">
        <ul>
          @foreach ($tabs as $item)
            <li @class(['active' => $item['id'] === 1])>
            <a href="#curriculum-tab-{{ $item['id'] }}">
              {{ $item['name'] }}
            </a>
            </li>
          @endforeach
        </ul>
      </div>
      <div class="achievement-tabs-content text-primary">
        
          <div id="curriculum-tab-2">
            <div class="pt-22 mobile:pt-12">
              <h2>
                Companion
              </h2>
            </div>
          </div>

          <div id="curriculum-tab-3">
            <div class="pt-22 mobile:pt-12">
              <h2>
                Explorer
              </h2>
            </div>
          </div>

          <div id="curriculum-tab-4">
            <div class="pt-22 mobile:pt-12">
              <h2>
                Ranger
              </h2>
            </div>
          </div>

          <div id="curriculum-tab-5">
            <div class="pb-5 pt-14 mobile:pt-12">
              <h2>
                Voyager
              </h2>
            </div>
          </div>

          <div id="curriculum-tab-6">
            <div class="pb-48 pt-20 desktop_medium:pb-0 mobile:pt-12">
              <h2>
                Guide
              </h2>
            </div>
          </div>
        
      </div>
    </div>
  </div>
</section>

<style>
  .section-curriculum ol {
    list-style-type: auto;
  }

  .section-curriculum ol li::marker {
    font-weight: 900;
    color: rgb(69 205 252 / 1);
  }

  .section-curriculum ol li::before {
    content: none;
  }

  .section-curriculum ol>li>ol {
    list-style-type: lower-alpha;
    margin-left: 1.5rem;
  }

  .section-curriculum ol li {
    padding-left: .5rem;
  }

  @media(max-width: 767px) {
    .achievement-tabs-nav ul {
      justify-content: space-between;
    }

    .achievement-tabs-nav ul li a {
      border-bottom-width: 2px;
    }
  }
</style>
