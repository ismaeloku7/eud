@php($tabs = [['id' => 1, 'name' => 'Little Lamb'], ['id' => 2, 'name' => 'Early Bird'], ['id' => 3, 'name' => 'Busy Bee'], ['id' => 4, 'name' => 'Sunbeam'], ['id' => 5, 'name' => 'Builder'], ['id' => 6, 'name' => 'Helping Hands']])
<section class="bg-secondary pb-30 mobile:pb-20">
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

                <div id="curriculum-tab-1">
            @include('site.ministries.curriculum.adventurers.parts.tab1')
        </div>
        <div id="curriculum-tab-2">
            @include('site.ministries.curriculum.adventurers.parts.tab2')
        </div>
        <div id="curriculum-tab-3">
            @include('site.ministries.curriculum.adventurers.parts.tab3')
        </div>
        <div id="curriculum-tab-4">
            @include('site.ministries.curriculum.adventurers.parts.tab4')
        </div>
        <div id="curriculum-tab-5">
            @include('site.ministries.curriculum.adventurers.parts.tab5')
        </div>
        <div id="curriculum-tab-6">
            @include('site.ministries.curriculum.adventurers.parts.tab6')
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
